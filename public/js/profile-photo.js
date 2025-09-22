/**
 * Profile Photo Management JavaScript
 * Handles real-time photo updates across all pages
 */

// Global function to update profile photos
window.updateProfilePhotos = function (userId, broadcast = true) {
    const timestamp = new Date().getTime();
    const baseUrl = window.location.origin;
    const newPhotoUrl = `${baseUrl}/profile-photo/${userId}?v=${timestamp}`;

    // Update all profile images for this user
    const profileImages = document.querySelectorAll(`img[data-user-id="${userId}"]`);
    profileImages.forEach(img => {
        img.src = newPhotoUrl;
    });

    // Also update images by alt text (fallback)
    const altImages = document.querySelectorAll('img[alt="Profile Photo"]');
    altImages.forEach(img => {
        if (img.src.includes(`profile-photo/${userId}`) || img.src.includes('profile-photos/')) {
            img.src = newPhotoUrl;
        }
    });

    // Broadcast to other tabs/windows
    if (broadcast && localStorage) {
        localStorage.setItem('profilePhotoUpdate', JSON.stringify({
            userId: userId,
            timestamp: timestamp,
            url: newPhotoUrl
        }));

        // Remove the item after a short delay to trigger storage event
        setTimeout(() => {
            localStorage.removeItem('profilePhotoUpdate');
        }, 100);
    }

    console.log(`Updated profile photos for user ${userId}`);
};

// Global function to show alerts
window.showProfileAlert = function (type, message) {
    // Remove existing alerts
    const existingAlerts = document.querySelectorAll('.alert-auto-dismiss');
    existingAlerts.forEach(alert => alert.remove());

    // Create new alert
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show alert-auto-dismiss`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    // Find the best place to insert the alert
    let targetContainer = document.querySelector('main .container-fluid');
    if (!targetContainer) {
        targetContainer = document.querySelector('.container-fluid');
    }
    if (!targetContainer) {
        targetContainer = document.querySelector('main');
    }
    if (!targetContainer) {
        targetContainer = document.body;
    }

    // Insert alert at the top
    targetContainer.insertBefore(alertDiv, targetContainer.firstChild);

    // Auto dismiss after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
};

// Global function to handle AJAX photo upload
window.handlePhotoUpload = function (formElement, options = {}) {
    const form = typeof formElement === 'string' ? document.getElementById(formElement) : formElement;
    if (!form) return;

    const fileInput = form.querySelector('input[type="file"]');
    const submitBtn = form.querySelector('button[type="submit"]');
    const progressContainer = form.querySelector('[id*="progress"], .upload-progress');

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const file = fileInput.files[0];

        if (!file) {
            alert('Please select a photo first');
            return;
        }

        // Show progress and disable button
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Uploading...';
        }

        if (progressContainer) {
            progressContainer.style.display = 'block';
        }

        // Create XMLHttpRequest for progress tracking
        const xhr = new XMLHttpRequest();

        // Track upload progress
        xhr.upload.addEventListener('progress', function (e) {
            if (e.lengthComputable && progressContainer) {
                const percentComplete = (e.loaded / e.total) * 100;
                const progressBar = progressContainer.querySelector('.progress-bar');
                if (progressBar) {
                    progressBar.style.width = percentComplete + '%';
                    progressBar.textContent = Math.round(percentComplete) + '%';
                }
            }
        });

        // Handle response
        xhr.addEventListener('load', function () {
            if (xhr.status === 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Update all profile photos
                        window.updateProfilePhotos(response.user_id);

                        // Show success message
                        window.showProfileAlert('success', response.message);

                        // Reset form
                        fileInput.value = '';

                        // Call success callback if provided
                        if (options.onSuccess) {
                            options.onSuccess(response);
                        }
                    } else {
                        window.showProfileAlert('danger', response.message || 'Upload failed');
                    }
                } catch (e) {
                    // Handle non-AJAX response (redirect)
                    if (options.fallbackReload !== false) {
                        window.location.reload();
                    }
                }
            } else {
                window.showProfileAlert('danger', 'Upload failed. Please try again.');
            }

            // Reset button and hide progress
            resetUploadButton();
        });

        // Handle errors
        xhr.addEventListener('error', function () {
            window.showProfileAlert('danger', 'Upload failed. Please check your connection.');
            resetUploadButton();
        });

        // Send request
        xhr.open('POST', form.action);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]');
        if (csrfToken) {
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken.getAttribute('content'));
        }

        xhr.send(formData);

        // Local function to reset upload button
        function resetUploadButton() {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-camera me-1"></i>Update Photo';
            }

            if (progressContainer) {
                progressContainer.style.display = 'none';
                const progressBar = progressContainer.querySelector('.progress-bar');
                if (progressBar) {
                    progressBar.style.width = '0%';
                    progressBar.textContent = '';
                }
            }
        }
    });
};

// Listen for storage events to sync across tabs
window.addEventListener('storage', function (e) {
    if (e.key === 'profilePhotoUpdate' && e.newValue) {
        try {
            const data = JSON.parse(e.newValue);
            // Update photos without broadcasting (to avoid infinite loop)
            window.updateProfilePhotos(data.userId, false);
        } catch (err) {
            console.error('Error parsing profile photo update:', err);
        }
    }
});

// Function to handle photo preview
window.setupPhotoPreview = function (inputId, previewId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const previewImage = preview ? preview.querySelector('img') : null;

    if (input && preview && previewImage) {
        input.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    previewImage.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
    }
};

// Auto-initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    // Auto-handle forms with class 'ajax-photo-upload'
    const ajaxForms = document.querySelectorAll('.ajax-photo-upload');
    ajaxForms.forEach(form => {
        window.handlePhotoUpload(form);
    });

    // Auto-handle form with ID 'photoUploadForm'
    const photoForm = document.getElementById('photoUploadForm');
    if (photoForm) {
        window.handlePhotoUpload(photoForm);
    }

    // Setup photo preview
    window.setupPhotoPreview('profilePhotoInput', 'photoPreview');
});
