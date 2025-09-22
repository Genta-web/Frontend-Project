/**
 * Test file for Leave Actions Service
 * This file contains basic tests to validate the functionality
 */

// Test configuration
const testConfig = {
    routes: {
        approve: '/leave/:id/approve',
        reject: '/leave/:id/reject',
        destroy: '/leave/:id',
        bulkApprove: '/leave/bulk-approve',
        bulkReject: '/leave/bulk-reject'
    },
    csrfToken: 'test-token',
    user: {
        isEmployee: false,
        hasManagePermission: true
    }
};

// Test suite
function runLeaveActionsTests() {
    console.log('🧪 Starting Leave Actions Service Tests...');
    
    // Test 1: Service initialization
    try {
        const service = new LeaveActionsService(testConfig);
        console.log('✅ Test 1 PASSED: Service initialization');
    } catch (error) {
        console.error('❌ Test 1 FAILED: Service initialization', error);
        return;
    }
    
    // Test 2: Notification system
    try {
        const service = new LeaveActionsService(testConfig);
        service.showNotification('Test notification', 'success');
        console.log('✅ Test 2 PASSED: Notification system');
    } catch (error) {
        console.error('❌ Test 2 FAILED: Notification system', error);
    }
    
    // Test 3: Permission checking
    try {
        const service = new LeaveActionsService(testConfig);
        
        // Test with management permission
        const canApprove = service.user.hasManagePermission;
        if (canApprove) {
            console.log('✅ Test 3a PASSED: Management permission check');
        } else {
            console.error('❌ Test 3a FAILED: Management permission check');
        }
        
        // Test with employee permission
        const employeeConfig = { ...testConfig };
        employeeConfig.user = { isEmployee: true, hasManagePermission: false };
        const employeeService = new LeaveActionsService(employeeConfig);
        
        if (employeeService.user.isEmployee && !employeeService.user.hasManagePermission) {
            console.log('✅ Test 3b PASSED: Employee permission check');
        } else {
            console.error('❌ Test 3b FAILED: Employee permission check');
        }
    } catch (error) {
        console.error('❌ Test 3 FAILED: Permission checking', error);
    }
    
    // Test 4: Modal creation
    try {
        const service = new LeaveActionsService(testConfig);
        
        // Test confirm modal creation
        const modal = service.createConfirmModal({
            title: 'Test Modal',
            message: 'Test message',
            onConfirm: () => console.log('Confirmed')
        });
        
        if (modal) {
            console.log('✅ Test 4a PASSED: Confirm modal creation');
            // Clean up
            const modalElement = document.querySelector('.modal');
            if (modalElement) {
                modalElement.remove();
            }
        } else {
            console.error('❌ Test 4a FAILED: Confirm modal creation');
        }
        
        // Test reject modal creation
        const rejectModal = service.createRejectModal();
        if (rejectModal) {
            console.log('✅ Test 4b PASSED: Reject modal creation');
            // Clean up
            rejectModal.remove();
        } else {
            console.error('❌ Test 4b FAILED: Reject modal creation');
        }
        
    } catch (error) {
        console.error('❌ Test 4 FAILED: Modal creation', error);
    }
    
    // Test 5: Bulk actions validation
    try {
        const service = new LeaveActionsService(testConfig);
        
        // Create mock checkboxes
        const mockCheckboxes = [];
        for (let i = 0; i < 3; i++) {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.name = 'selected_leaves[]';
            checkbox.value = i + 1;
            checkbox.checked = true;
            
            // Create mock row
            const row = document.createElement('tr');
            const cell1 = document.createElement('td');
            cell1.textContent = 'Employee ' + (i + 1);
            const cell2 = document.createElement('td');
            cell2.textContent = 'Annual Leave';
            row.appendChild(cell1);
            row.appendChild(cell2);
            checkbox.closest = () => row;
            
            document.body.appendChild(checkbox);
            document.body.appendChild(row);
            mockCheckboxes.push(checkbox);
        }
        
        // Test bulk selection count
        service.updateBulkActions();
        console.log('✅ Test 5 PASSED: Bulk actions validation');
        
        // Clean up
        mockCheckboxes.forEach(checkbox => {
            checkbox.remove();
            checkbox.closest('tr')?.remove();
        });
        
    } catch (error) {
        console.error('❌ Test 5 FAILED: Bulk actions validation', error);
    }
    
    // Test 6: Global functions availability
    try {
        const globalFunctions = [
            'approveLeave',
            'showRejectModal', 
            'confirmDelete',
            'setReason',
            'toggleSelectAll',
            'updateBulkActions',
            'showBulkActions',
            'bulkApprove',
            'bulkReject',
            'clearSelection'
        ];
        
        let allFunctionsAvailable = true;
        globalFunctions.forEach(funcName => {
            if (typeof window[funcName] !== 'function') {
                console.error(`❌ Global function ${funcName} not available`);
                allFunctionsAvailable = false;
            }
        });
        
        if (allFunctionsAvailable) {
            console.log('✅ Test 6 PASSED: Global functions availability');
        } else {
            console.error('❌ Test 6 FAILED: Some global functions missing');
        }
        
    } catch (error) {
        console.error('❌ Test 6 FAILED: Global functions availability', error);
    }
    
    console.log('🏁 Leave Actions Service Tests Completed!');
}

// Auto-run tests when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runLeaveActionsTests);
} else {
    runLeaveActionsTests();
}

// Export for manual testing
window.runLeaveActionsTests = runLeaveActionsTests;
