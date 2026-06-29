function customAlert(title, message, type = 'info') {
    let iconClass = 'fa-info-circle text-info';
    if (type === 'success') iconClass = 'fa-check-circle text-success';
    if (type === 'error') iconClass = 'fa-times-circle text-danger';
    if (type === 'warning') iconClass = 'fa-exclamation-triangle text-warning';

    if ($('#customGlobalAlertModal').length === 0) {
        let modalHtml = `
        <div class="modal fade" id="customGlobalAlertModal" tabindex="-1" aria-hidden="true" style="z-index: 99999;">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
              <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-center pt-0 pb-5">
                <i id="customGlobalAlertIcon" class="fa fa-4x mb-3"></i>
                <h4 class="modal-title mb-2 fw-bold" id="customGlobalAlertTitle"></h4>
                <p id="customGlobalAlertMessage" class="text-muted mb-4"></p>
                <button type="button" class="btn btn-primary px-5 py-2" data-bs-dismiss="modal">OK</button>
              </div>
            </div>
          </div>
        </div>`;
        $('body').append(modalHtml);
    }

    $('#customGlobalAlertIcon').removeClass().addClass('fa fa-4x mb-3 ' + iconClass);
    $('#customGlobalAlertTitle').text(title);
    $('#customGlobalAlertMessage').html(message);

    var alertModal = new bootstrap.Modal(document.getElementById('customGlobalAlertModal'));
    alertModal.show();
}

function customConfirm(title, message, type, confirmCallback, confirmText = 'Confirm', cancelText = 'Cancel') {
    let iconClass = 'fa-question-circle text-warning';
    if (type === 'error') iconClass = 'fa-times-circle text-danger';
    if (type === 'warning') iconClass = 'fa-exclamation-triangle text-warning';

    if ($('#customGlobalConfirmModal').length === 0) {
        let modalHtml = `
        <div class="modal fade" id="customGlobalConfirmModal" tabindex="-1" aria-hidden="true" style="z-index: 99999;">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
              <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body text-center pt-0 pb-4">
                <i id="customGlobalConfirmIcon" class="fa fa-4x mb-3"></i>
                <h4 class="modal-title mb-2 fw-bold" id="customGlobalConfirmTitle"></h4>
                <p id="customGlobalConfirmMessage" class="text-muted mb-4"></p>
                <div class="mt-4">
                    <button type="button" class="btn btn-light px-4 py-2 me-2" data-bs-dismiss="modal" id="customGlobalCancelBtn">Cancel</button>
                    <button type="button" class="btn btn-primary px-4 py-2" id="customGlobalConfirmBtn">Confirm</button>
                </div>
              </div>
            </div>
          </div>
        </div>`;
        $('body').append(modalHtml);
    }

    $('#customGlobalConfirmIcon').removeClass().addClass('fa fa-4x mb-3 ' + iconClass);
    $('#customGlobalConfirmTitle').text(title);
    $('#customGlobalConfirmMessage').html(message);
    $('#customGlobalCancelBtn').text(cancelText);
    $('#customGlobalConfirmBtn').text(confirmText);

    // Track if confirmed
    let isConfirmed = false;

    $('#customGlobalConfirmBtn').off('click').on('click', function() {
        isConfirmed = true;
        var confirmModalEl = document.getElementById('customGlobalConfirmModal');
        var confirmModal = bootstrap.Modal.getInstance(confirmModalEl);
        confirmModal.hide();
    });

    $('#customGlobalConfirmModal').off('hidden.bs.modal').on('hidden.bs.modal', function () {
        if (typeof confirmCallback === 'function') {
            confirmCallback(isConfirmed);
        }
    });

    var confirmModal = new bootstrap.Modal(document.getElementById('customGlobalConfirmModal'));
    confirmModal.show();
}

// Wrapper to intercept Swal.fire calls dynamically if missed:
window.Swal = {
    fire: function(arg1, arg2, arg3) {
        if (typeof arg1 === 'object') {
            if (arg1.showCancelButton || (arg1.icon === 'warning' && arg1.confirmButtonText)) {
                // Confirmation
                let title = arg1.title || 'Confirm';
                let message = arg1.text || 'Are you sure?';
                let type = arg1.icon || 'warning';
                
                return new Promise((resolve) => {
                    let confirmText = arg1.confirmButtonText || 'Confirm';
                    let cancelText = arg1.cancelButtonText || 'Cancel';
                    customConfirm(title, message, type, function(confirmed) {
                        resolve({ isConfirmed: confirmed });
                    }, confirmText, cancelText);
                });
            } else {
                let title = arg1.title || '';
                let message = arg1.text || '';
                let type = arg1.icon || 'info';
                customAlert(title, message, type);
                return Promise.resolve({ isConfirmed: true });
            }
        } else {
            let title = arg1 || '';
            let message = arg2 || '';
            let type = arg3 || 'info';
            customAlert(title, message, type);
            return Promise.resolve({ isConfirmed: true });
        }
    }
};

