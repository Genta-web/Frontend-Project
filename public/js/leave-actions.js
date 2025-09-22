/**
 * Leave Actions Service
 * Centralized service for handling all leave management actions
 */
class LeaveActionsService {
    constructor(config) {
        this.routes = config.routes;
        this.csrfToken = config.csrfToken;
        this.user = config.user;
        this.init();
    }

    init() {
        // Initialize any required setup
        this.setupEventListeners();
    }

    setupEventListeners() {
        // Setup global event listeners if needed
        document.addEventListener('click', (e) => {
            if (e.target.matches('[data-action="approve-leave"]')) {
                e.preventDefault();
                const leaveId = e.target.dataset.leaveId;
                const leaveData = JSON.parse(e.target.dataset.leaveData || '{}');
                this.approveLeave(leaveId, leaveData);
            }

            if (e.target.matches('[data-action="reject-leave"]')) {
                e.preventDefault();
                const leaveId = e.target.dataset.leaveId;
                const leaveData = JSON.parse(e.target.dataset.leaveData || '{}');
                this.showRejectModal(leaveId, leaveData);
            }

            if (e.target.matches('[data-action="delete-leave"]')) {
                e.preventDefault();
                const leaveId = e.target.dataset.leaveId;
                const leaveData = JSON.parse(e.target.dataset.leaveData || '{}');
                this.confirmDelete(leaveId, leaveData);
            }
        });
    }

    /**
     * Show notification to user
     */
    showNotification(message, type = 'info', duration = 5000) {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);';

        const iconMap = {
            success: 'check-circle',
            warning: 'exclamation-triangle',
            danger: 'exclamation-circle',
            info: 'info-circle'
        };

        alertDiv.innerHTML = `
            <i class="fas fa-${iconMap[type] || 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alertDiv);

        // Auto remove after duration
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, duration);
    }

    /**
     * Create and show loading overlay
     */
    showLoading(message = 'Processing...') {
        const loadingDiv = document.createElement('div');
        loadingDiv.id = 'leave-action-loading';
        loadingDiv.className = 'position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center';
        loadingDiv.style.cssText = 'background: rgba(0,0,0,0.5); z-index: 9999;';
        loadingDiv.innerHTML = `
            <div class="bg-white p-4 rounded shadow text-center">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <div>${message}</div>
            </div>
        `;
        document.body.appendChild(loadingDiv);
    }

    /**
     * Hide loading overlay
     */
    hideLoading() {
        const loadingDiv = document.getElementById('leave-action-loading');
        if (loadingDiv) {
            loadingDiv.remove();
        }
    }

    /**
     * Approve leave request with enhanced options
     */
    approveLeave(leaveId, leaveData = {}) {
        if (!this.user.hasManagePermission) {
            this.showNotification('You do not have permission to approve leave requests', 'danger');
            return;
        }

        this.showEnhancedApprovalModal(leaveId, leaveData);
    }

    /**
     * Submit approval form
     */
    submitApproval(leaveId) {
        this.showLoading('Approving leave request...');

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = this.routes.approve.replace(':id', leaveId);

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = this.csrfToken;
        form.appendChild(csrfToken);

        document.body.appendChild(form);
        form.submit();
    }

    /**
     * Show reject modal
     */
    showRejectModal(leaveId, leaveData = {}) {
        if (!this.user.hasManagePermission) {
            this.showNotification('You do not have permission to reject leave requests', 'danger');
            return;
        }

        let modal = document.getElementById('rejectModal');
        if (!modal) {
            modal = this.createRejectModal();
        }

        // Update modal content
        const form = modal.querySelector('form');
        form.action = this.routes.reject.replace(':id', leaveId);

        const employeeNameElement = modal.querySelector('#employeeName');
        const leaveTypeElement = modal.querySelector('#leaveType');

        if (employeeNameElement) employeeNameElement.textContent = leaveData.employeeName || 'Employee';
        if (leaveTypeElement) leaveTypeElement.textContent = leaveData.leaveType || 'Leave';

        // Reset form
        const textarea = form.querySelector('textarea[name="admin_notes"]');
        if (textarea) {
            textarea.value = '';
        }

        // Show modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    /**
     * Confirm delete action
     */
    confirmDelete(leaveId, leaveData = {}) {
        const itemName = leaveData.leaveType || 'leave request';

        if (confirm(`Are you sure you want to delete the ${itemName}? This action cannot be undone.`)) {
            this.showLoading('Deleting leave request...');

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = this.routes.destroy.replace(':id', leaveId);

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = this.csrfToken;
            form.appendChild(csrfToken);

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';
            form.appendChild(methodField);

            document.body.appendChild(form);
            form.submit();
        }
    }

    /**
     * Set predefined rejection reason
     */
    setReason(reason) {
        const textarea = document.getElementById('admin_notes');
        if (textarea) {
            if (textarea.value.trim() === '') {
                textarea.value = reason;
            } else {
                textarea.value += '. ' + reason;
            }
            textarea.focus();
        }
    }

    /**
     * Toggle select all checkboxes
     */
    toggleSelectAll() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('input[name="selected_leaves[]"]');

        checkboxes.forEach(checkbox => {
            checkbox.checked = selectAll.checked;
        });

        this.updateBulkActions();
    }

    /**
     * Update bulk action buttons visibility
     */
    updateBulkActions() {
        const checkedBoxes = document.querySelectorAll('input[name="selected_leaves[]"]:checked');
        const bulkActions = document.getElementById('bulkActions');
        const selectAll = document.getElementById('selectAll');

        if (bulkActions && checkedBoxes.length > 0) {
            bulkActions.style.display = 'block';
            const approveBtn = bulkActions.querySelector('.btn-success');
            const rejectBtn = bulkActions.querySelector('.btn-danger');

            if (approveBtn) {
                approveBtn.innerHTML = `<i class="fas fa-check me-1"></i>Approve Selected (${checkedBoxes.length})`;
                approveBtn.disabled = !this.user.hasManagePermission;
            }

            if (rejectBtn) {
                rejectBtn.innerHTML = `<i class="fas fa-times me-1"></i>Reject Selected (${checkedBoxes.length})`;
                rejectBtn.disabled = !this.user.hasManagePermission;
            }

            // Update select all checkbox state
            const allCheckboxes = document.querySelectorAll('input[name="selected_leaves[]"]');
            if (selectAll) {
                selectAll.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < allCheckboxes.length;
                selectAll.checked = checkedBoxes.length === allCheckboxes.length && allCheckboxes.length > 0;
            }
        } else if (bulkActions) {
            bulkActions.style.display = 'none';
            if (selectAll) {
                selectAll.indeterminate = false;
                selectAll.checked = false;
            }
        }

        // Show selection count notification
        if (checkedBoxes.length > 0) {
            this.showSelectionCount(checkedBoxes.length);
        } else {
            this.hideSelectionCount();
        }
    }

    /**
     * Show selection count
     */
    showSelectionCount(count) {
        let countElement = document.getElementById('selectionCount');
        if (!countElement) {
            countElement = document.createElement('div');
            countElement.id = 'selectionCount';
            countElement.className = 'alert alert-info alert-sm position-fixed';
            countElement.style.cssText = 'bottom: 20px; right: 20px; z-index: 1000; min-width: 200px;';
            document.body.appendChild(countElement);
        }

        countElement.innerHTML = `
            <i class="fas fa-check-square me-2"></i>
            <strong>${count}</strong> item${count > 1 ? 's' : ''} selected
            <button type="button" class="btn-close btn-sm ms-2" onclick="leaveActions.clearSelection()"></button>
        `;
        countElement.style.display = 'block';
    }

    /**
     * Hide selection count
     */
    hideSelectionCount() {
        const countElement = document.getElementById('selectionCount');
        if (countElement) {
            countElement.style.display = 'none';
        }
    }

    /**
     * Clear all selections
     */
    clearSelection() {
        const checkboxes = document.querySelectorAll('input[name="selected_leaves[]"]');
        const selectAll = document.getElementById('selectAll');

        checkboxes.forEach(checkbox => {
            checkbox.checked = false;
        });

        if (selectAll) {
            selectAll.checked = false;
            selectAll.indeterminate = false;
        }

        this.updateBulkActions();
    }

    /**
     * Show bulk actions panel
     */
    showBulkActions() {
        const pendingCheckboxes = document.querySelectorAll('input[name="selected_leaves[]"]');
        if (pendingCheckboxes.length > 0) {
            // Scroll to table
            const table = document.getElementById('leave-table');
            if (table) {
                table.scrollIntoView({ behavior: 'smooth' });
            }

            // Show notification
            this.showNotification('Select leave requests using checkboxes to perform bulk actions', 'info');
        }
    }

    /**
     * Bulk approve function
     */
    bulkApprove() {
        const checkedBoxes = document.querySelectorAll('input[name="selected_leaves[]"]:checked');
        if (checkedBoxes.length === 0) {
            this.showNotification('Please select at least one leave request', 'warning');
            return;
        }

        // Check permission
        if (!this.user.hasManagePermission) {
            this.showNotification('You do not have permission to approve leave requests', 'danger');
            return;
        }

        // Get leave details for confirmation
        const leaveDetails = Array.from(checkedBoxes).map(checkbox => {
            const row = checkbox.closest('tr');
            const employeeName = row.querySelector('td:nth-child(3)')?.textContent?.trim() || 'Unknown';
            const leaveType = row.querySelector('td:nth-child(4)')?.textContent?.trim() || 'Unknown';
            return `• ${employeeName} - ${leaveType}`;
        }).join('\n');

        const confirmModal = this.createConfirmModal({
            title: 'Bulk Approve Leave Requests',
            icon: 'check-circle',
            iconColor: 'success',
            message: `
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>
                    You are about to approve <strong>${checkedBoxes.length}</strong> leave request(s):
                </div>
                <div class="mb-3" style="max-height: 200px; overflow-y: auto;">
                    <pre style="white-space: pre-wrap; font-size: 0.9rem;">${leaveDetails}</pre>
                </div>
                <p class="text-muted">This action cannot be undone. Are you sure you want to proceed?</p>
            `,
            confirmText: 'Yes, Approve All',
            confirmClass: 'btn-success',
            onConfirm: () => {
                this.submitBulkApprove(checkedBoxes);
            }
        });

        confirmModal.show();
    }

    /**
     * Submit bulk approve form
     */
    submitBulkApprove(checkedBoxes) {
        this.showLoading('Approving selected leave requests...');

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = this.routes.bulkApprove;

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = this.csrfToken;
        form.appendChild(csrfToken);

        // Add selected leave IDs
        checkedBoxes.forEach(checkbox => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'leave_ids[]';
            hiddenInput.value = checkbox.value;
            form.appendChild(hiddenInput);
        });

        document.body.appendChild(form);
        form.submit();
    }

    /**
     * Bulk reject function
     */
    bulkReject() {
        const checkedBoxes = document.querySelectorAll('input[name="selected_leaves[]"]:checked');
        if (checkedBoxes.length === 0) {
            this.showNotification('Please select at least one leave request', 'warning');
            return;
        }

        // Check permission
        if (!this.user.hasManagePermission) {
            this.showNotification('You do not have permission to reject leave requests', 'danger');
            return;
        }

        // Show bulk reject modal
        this.showBulkRejectModal(checkedBoxes);
    }

    /**
     * Show bulk reject modal
     */
    showBulkRejectModal(checkedBoxes) {
        let modal = document.getElementById('bulkRejectModal');
        if (!modal) {
            modal = this.createBulkRejectModal();
        }

        // Get leave details for display
        const leaveDetails = Array.from(checkedBoxes).map(checkbox => {
            const row = checkbox.closest('tr');
            const employeeName = row.querySelector('td:nth-child(3)')?.textContent?.trim() || 'Unknown';
            const leaveType = row.querySelector('td:nth-child(4)')?.textContent?.trim() || 'Unknown';
            return `• ${employeeName} - ${leaveType}`;
        }).join('\n');

        // Update count and details
        const countElement = modal.querySelector('#bulkRejectCount');
        if (countElement) {
            countElement.textContent = checkedBoxes.length;
        }

        const detailsElement = modal.querySelector('#bulkRejectDetails');
        if (detailsElement) {
            detailsElement.textContent = leaveDetails;
        }

        // Clear form
        const form = modal.querySelector('form');
        const textarea = form.querySelector('textarea[name="admin_notes"]');
        if (textarea) {
            textarea.value = '';
        }

        // Add selected leave IDs to form
        const existingInputs = form.querySelectorAll('input[name="leave_ids[]"]');
        existingInputs.forEach(input => input.remove());

        checkedBoxes.forEach(checkbox => {
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'leave_ids[]';
            hiddenInput.value = checkbox.value;
            form.appendChild(hiddenInput);
        });

        // Add form validation
        form.addEventListener('submit', (e) => {
            const textarea = form.querySelector('textarea[name="admin_notes"]');
            if (!textarea.value.trim()) {
                e.preventDefault();
                this.showNotification('Please provide a reason for rejection', 'warning');
                textarea.focus();
                return false;
            }

            this.showLoading('Rejecting selected leave requests...');
        });

        // Show modal
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
    }

    /**
     * Create confirm modal
     */
    createConfirmModal(options) {
        const modalId = 'confirmModal_' + Date.now();
        const confirmModal = document.createElement('div');
        confirmModal.className = 'modal fade';
        confirmModal.id = modalId;
        confirmModal.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                    <div class="modal-header bg-${options.iconColor || 'primary'} text-white">
                        <h5 class="modal-title">
                            <i class="fas fa-${options.icon || 'question-circle'} me-2"></i>${options.title}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        ${options.message}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="button" class="btn ${options.confirmClass || 'btn-primary'}" id="confirmAction">
                            <i class="fas fa-${options.icon || 'check'} me-2"></i>${options.confirmText || 'Confirm'}
                        </button>
                    </div>
                </div>
            </div>
        `;

        document.body.appendChild(confirmModal);

        const modal = new bootstrap.Modal(confirmModal);

        // Setup confirm action
        const confirmBtn = confirmModal.querySelector('#confirmAction');
        confirmBtn.addEventListener('click', () => {
            modal.hide();
            if (options.onConfirm) {
                options.onConfirm();
            }
        });

        // Clean up modal after it's hidden
        confirmModal.addEventListener('hidden.bs.modal', function () {
            document.body.removeChild(confirmModal);
        });

        return modal;
    }

    /**
     * Show enhanced approval modal with templates
     */
    showEnhancedApprovalModal(leaveId, leaveData) {
        const modalHtml = `
            <div class="modal fade" id="enhancedApprovalModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-success text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-check-circle me-2"></i>Approve Leave Request
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Leave Details -->
                            <div class="alert alert-info border-0 mb-4">
                                <h6 class="alert-heading mb-3">
                                    <i class="fas fa-info-circle me-2"></i>Leave Request Details
                                </h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div><strong>Employee:</strong> ${leaveData.employeeName || 'N/A'}</div>
                                        <div><strong>Leave Type:</strong> ${leaveData.leaveType || 'N/A'}</div>
                                    </div>
                                    <div class="col-md-6">
                                        <div><strong>Duration:</strong> ${leaveData.duration || 'N/A'}</div>
                                        <div><strong>Total Days:</strong> ${leaveData.totalDays || 'N/A'} day(s)</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Approval Options -->
                            <div class="mb-4">
                                <h6 class="mb-3">
                                    <i class="fas fa-bolt me-2"></i>Quick Approval Options
                                </h6>
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-success w-100" onclick="leaveActions.quickApprove('${leaveId}', 'standard')">
                                            <i class="fas fa-check me-2"></i>Standard Approval
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-success w-100" onclick="leaveActions.quickApprove('${leaveId}', 'conditional')">
                                            <i class="fas fa-check-double me-2"></i>Conditional Approval
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-success w-100" onclick="leaveActions.quickApprove('${leaveId}', 'early_approval')">
                                            <i class="fas fa-star me-2"></i>Early Approval
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="button" class="btn btn-outline-success w-100" onclick="leaveActions.quickApprove('${leaveId}', 'urgent_approved')">
                                            <i class="fas fa-exclamation-circle me-2"></i>Urgent Approval
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Custom Message -->
                            <div class="mb-3">
                                <label for="approval_message" class="form-label">
                                    <i class="fas fa-comment me-2"></i><strong>Custom Message to Employee</strong>
                                </label>
                                <textarea class="form-control" id="approval_message" rows="4"
                                          placeholder="Add a personal message to the employee (optional)..."></textarea>
                                <div class="form-text">
                                    This message will be sent to the employee along with the approval notification.
                                </div>
                            </div>

                            <!-- Template Suggestions -->
                            <div class="mb-3">
                                <label class="form-label"><strong>Message Templates:</strong></label>
                                <div class="d-flex flex-wrap gap-2">
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="leaveActions.setApprovalMessage('Your leave request has been approved. Please ensure proper handover of your responsibilities.')">
                                        Standard Message
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="leaveActions.setApprovalMessage('Approved with conditions: Please coordinate with your team lead.')">
                                        Conditional Message
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="leaveActions.setApprovalMessage('Thank you for the advance notice. Your leave is approved.')">
                                        Appreciation Message
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i>Cancel
                            </button>
                            <button type="button" class="btn btn-success" onclick="leaveActions.submitEnhancedApproval('${leaveId}')">
                                <i class="fas fa-check me-2"></i>Approve with Message
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Remove existing modal if any
        const existingModal = document.getElementById('enhancedApprovalModal');
        if (existingModal) {
            existingModal.remove();
        }

        document.body.insertAdjacentHTML('beforeend', modalHtml);
        const modal = new bootstrap.Modal(document.getElementById('enhancedApprovalModal'));
        modal.show();
    }

    /**
     * Quick approve with template
     */
    quickApprove(leaveId, templateType) {
        const templates = {
            'standard': 'Your leave request has been approved. Please ensure proper handover of your responsibilities before your leave begins.',
            'conditional': 'Your leave request has been approved with conditions. Please coordinate with your team lead and ensure all pending tasks are completed.',
            'early_approval': 'Your leave request has been approved earlier than usual due to good planning and advance notice. Thank you for your professionalism.',
            'urgent_approved': 'Your urgent leave request has been approved. We understand the circumstances and hope everything works out well for you.'
        };

        const message = templates[templateType] || templates['standard'];
        this.setApprovalMessage(message);

        // Auto submit after setting message
        setTimeout(() => {
            this.submitEnhancedApproval(leaveId);
        }, 500);
    }

    /**
     * Set approval message
     */
    setApprovalMessage(message) {
        const textarea = document.getElementById('approval_message');
        if (textarea) {
            textarea.value = message;
            textarea.focus();
        }
    }

    /**
     * Submit enhanced approval
     */
    submitEnhancedApproval(leaveId) {
        this.showLoading('Processing approval...');

        const message = document.getElementById('approval_message')?.value || '';

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = this.routes.approve.replace(':id', leaveId);

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = this.csrfToken;
        form.appendChild(csrfToken);

        if (message.trim()) {
            const messageInput = document.createElement('input');
            messageInput.type = 'hidden';
            messageInput.name = 'admin_message';
            messageInput.value = message;
            form.appendChild(messageInput);
        }

        document.body.appendChild(form);
        form.submit();
    }

    /**
     * Create enhanced reject modal with templates
     */
    createRejectModal() {
        const modalHtml = `
            <div class="modal fade" id="rejectModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content shadow">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-times-circle me-2"></i>Reject Leave Request
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST">
                            <input type="hidden" name="_token" value="${this.csrfToken}">
                            <div class="modal-body">
                                <div class="alert alert-warning border-0 shadow-sm mb-4">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle text-warning me-3" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>You are about to reject this leave request</strong><br>
                                            <span class="text-muted">Employee: <span id="employeeName">Employee</span></span><br>
                                            <span class="text-muted">Leave Type: <span id="leaveType">Leave</span></span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quick Rejection Templates -->
                                <div class="mb-4">
                                    <h6 class="mb-3">
                                        <i class="fas fa-bolt me-2"></i>Quick Rejection Templates
                                    </h6>
                                    <div class="row g-2">
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="leaveActions.setRejectionTemplate('insufficient_notice')">
                                                <i class="fas fa-clock me-1"></i>Insufficient Notice
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="leaveActions.setRejectionTemplate('peak_period')">
                                                <i class="fas fa-chart-line me-1"></i>Peak Business Period
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="leaveActions.setRejectionTemplate('staffing_shortage')">
                                                <i class="fas fa-users me-1"></i>Staffing Shortage
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="leaveActions.setRejectionTemplate('conflicting_requests')">
                                                <i class="fas fa-calendar-times me-1"></i>Conflicting Requests
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="leaveActions.setRejectionTemplate('incomplete_docs')">
                                                <i class="fas fa-file-times me-1"></i>Incomplete Docs
                                            </button>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="leaveActions.setRejectionTemplate('exceeds_allowance')">
                                                <i class="fas fa-exclamation-circle me-1"></i>Exceeds Allowance
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="admin_notes" class="form-label">
                                        <i class="fas fa-comment me-2"></i><strong>Reason for Rejection *</strong>
                                    </label>
                                    <textarea class="form-control" id="admin_notes" name="admin_notes" rows="5"
                                              placeholder="Please provide a clear and constructive reason for rejecting this leave request..." required></textarea>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        This message will be sent to the employee. Please be professional and constructive.
                                    </div>
                                </div>

                                <!-- Alternative Suggestions -->
                                <div class="mb-3">
                                    <label for="alternative_suggestions" class="form-label">
                                        <i class="fas fa-lightbulb me-2"></i><strong>Alternative Suggestions (Optional)</strong>
                                    </label>
                                    <textarea class="form-control" id="alternative_suggestions" name="alternative_suggestions" rows="3"
                                              placeholder="Suggest alternative dates, solutions, or next steps for the employee..."></textarea>
                                    <div class="form-text">
                                        Help the employee by suggesting alternatives or next steps.
                                    </div>
                                </div>

                                <!-- Follow-up Actions -->
                                <div class="mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-tasks me-2"></i><strong>Follow-up Actions:</strong>
                                    </label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="schedule_meeting" name="follow_up_actions[]" value="schedule_meeting">
                                        <label class="form-check-label" for="schedule_meeting">
                                            Schedule a meeting to discuss alternatives
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="request_documents" name="follow_up_actions[]" value="request_documents">
                                        <label class="form-check-label" for="request_documents">
                                            Request additional documentation
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="coordinate_team" name="follow_up_actions[]" value="coordinate_team">
                                        <label class="form-check-label" for="coordinate_team">
                                            Coordinate with team for alternative dates
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-ban me-2"></i>Reject Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);
        return document.getElementById('rejectModal');
    }

    /**
     * Set rejection template
     */
    setRejectionTemplate(templateType) {
        const templates = {
            'insufficient_notice': 'Your leave request cannot be approved due to insufficient notice period. Please submit your request at least 14 days in advance as per company policy.',
            'peak_period': 'Unfortunately, your leave request coincides with our peak business period. We need all hands on deck during this time. Please consider rescheduling your leave to a different period.',
            'staffing_shortage': 'Your leave request cannot be approved due to current staffing shortage in your department. Please coordinate with your team and resubmit when adequate coverage is available.',
            'conflicting_requests': 'Multiple team members have requested leave for the same period. Please coordinate with your colleagues and submit alternative dates that work for the team.',
            'incomplete_docs': 'Your leave request is missing required documentation. Please provide the necessary supporting documents and resubmit your request.',
            'exceeds_allowance': 'Your request exceeds your available leave balance. Please check your current leave balance and adjust your request accordingly.'
        };

        const message = templates[templateType] || '';
        const textarea = document.getElementById('admin_notes');
        if (textarea && message) {
            textarea.value = message;
            textarea.focus();
        }
    }

    /**
     * Create bulk reject modal
     */
    createBulkRejectModal() {
        const modalHtml = `
            <div class="modal fade" id="bulkRejectModal" tabindex="-1">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-danger text-white">
                            <h5 class="modal-title">
                                <i class="fas fa-times-circle me-2"></i>Bulk Reject Leave Requests
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="${this.routes.bulkReject}" method="POST">
                            <input type="hidden" name="_token" value="${this.csrfToken}">
                            <div class="modal-body">
                                <div class="alert alert-warning border-0">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-exclamation-triangle text-warning me-3" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>You are about to reject <span id="bulkRejectCount">0</span> leave request(s)</strong>
                                            <div class="text-muted mt-1">This action cannot be undone.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>Selected Leave Requests:</strong></label>
                                    <div class="border rounded p-3 bg-light" style="max-height: 150px; overflow-y: auto;">
                                        <pre id="bulkRejectDetails" style="white-space: pre-wrap; margin: 0; font-size: 0.9rem;"></pre>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="bulk_admin_notes" class="form-label">
                                        <strong>Reason for Rejection <span class="text-danger">*</span></strong>
                                    </label>
                                    <textarea class="form-control" id="bulk_admin_notes" name="admin_notes" rows="4"
                                              placeholder="Please provide a clear reason for rejecting these leave requests. This will be visible to all affected employees." required></textarea>
                                    <div class="form-text">
                                        This reason will be recorded and visible to the employees.
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><strong>Common Rejection Reasons:</strong></label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="leaveActions.setBulkReason('Insufficient staffing during requested period')">
                                            Insufficient staffing
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="leaveActions.setBulkReason('Peak business period - leave not advisable')">
                                            Peak business period
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="leaveActions.setBulkReason('Conflicting leave requests from team members')">
                                            Conflicting requests
                                        </button>
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="leaveActions.setBulkReason('Insufficient notice period provided')">
                                            Insufficient notice
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </button>
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-ban me-2"></i>Reject All Selected
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        `;

        document.body.insertAdjacentHTML('beforeend', modalHtml);
        return document.getElementById('bulkRejectModal');
    }

    /**
     * Set bulk rejection reason
     */
    setBulkReason(reason) {
        const textarea = document.getElementById('bulk_admin_notes');
        if (textarea) {
            if (textarea.value.trim() === '') {
                textarea.value = reason;
            } else {
                textarea.value += '. ' + reason;
            }
            textarea.focus();
        }
    }
}

// Global functions for backward compatibility
function approveLeave(leaveId, leaveData) {
    if (window.leaveActions) {
        window.leaveActions.approveLeave(leaveId, leaveData);
    } else {
        console.error('LeaveActionsService not initialized');
        alert('System error: Leave actions service not available. Please refresh the page.');
    }
}

function showRejectModal(leaveId, employeeName, leaveType) {
    if (window.leaveActions) {
        window.leaveActions.showRejectModal(leaveId, {
            employeeName: employeeName,
            leaveType: leaveType
        });
    } else {
        console.error('LeaveActionsService not initialized');
        alert('System error: Leave actions service not available. Please refresh the page.');
    }
}

function confirmDelete(itemName, deleteUrl) {
    if (window.leaveActions) {
        const leaveId = deleteUrl.split('/').pop();
        window.leaveActions.confirmDelete(leaveId, { leaveType: itemName });
    }
}

function setReason(reason) {
    if (window.leaveActions) {
        window.leaveActions.setReason(reason);
    }
}

function toggleSelectAll() {
    if (window.leaveActions) {
        window.leaveActions.toggleSelectAll();
    }
}

function updateBulkActions() {
    if (window.leaveActions) {
        window.leaveActions.updateBulkActions();
    }
}

function showBulkActions() {
    if (window.leaveActions) {
        window.leaveActions.showBulkActions();
    }
}

function bulkApprove() {
    if (window.leaveActions) {
        window.leaveActions.bulkApprove();
    }
}

function bulkReject() {
    if (window.leaveActions) {
        window.leaveActions.bulkReject();
    }
}

function clearSelection() {
    if (window.leaveActions) {
        window.leaveActions.clearSelection();
    }
}
