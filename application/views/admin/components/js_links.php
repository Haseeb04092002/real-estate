<!-- Custom Bootstrap Alerts -->
<script src="<?= base_url('assets/js/custom-alerts.js'); ?>"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Chart.js for Graphs -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sidebar Toggle
        const toggleBtn = document.getElementById("sidebarToggle");
        const body = document.body;
        
        if (toggleBtn) {
            toggleBtn.addEventListener("click", function () {
                body.classList.toggle("sidebar-toggled");
            });
        }
    });

    $(document).ready(function() {
        if($.fn.DataTable) {
            $('.init-datatable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "info": true,
                "dom": '<"row align-items-center mb-3"<"col-md-6"l><"col-md-6 text-end"f>>rt<"row align-items-center mt-3"<"col-md-6"i><"col-md-6 text-end"p>>',
                "language": {
                    search: "_INPUT_",
                    searchPlaceholder: "Search..."
                }
            });
        }
    });
</script>

