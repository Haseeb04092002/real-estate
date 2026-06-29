$(document).ready(function() {

    $('#saveStatusBtn').click(function() {
        let userId = $('#statusUserId').val();
        let status = $('#statusSelect').val();
        let reason = $('#statusReason').val();

        if((status === 'Suspended' || status === 'Blocked') && reason === '') {
            alert("Please select a reason for suspension or blocking.");
            return;
        }

        $.ajax({
            url: siteUrl + 'Admin/api_update_user_status',
            type: 'POST',
            data: { user_id: userId, status: status, reason: reason },
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    alert("Status updated successfully.");
                    location.reload(); 
                }
            }
        });
    });

    $('.doc-status-select').change(function() {
        let docId = $(this).data('doc-id');
        let status = $(this).val();
        
        let selectEl = $(this);
        
        // Remove previous color classes
        selectEl.removeClass('text-success border-success text-danger border-danger text-warning border-warning');
        
        if (status === 'Approved') selectEl.addClass('text-success border-success');
        else if (status === 'Rejected') selectEl.addClass('text-danger border-danger');
        else selectEl.addClass('text-warning border-warning');

        $.ajax({
            url: siteUrl + 'Admin/api_update_document_status',
            type: 'POST',
            data: { document_id: docId, status: status },
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    // console.log("Document status updated");
                } else {
                    alert("Failed to update document status.");
                }
            }
        });
    });
});
