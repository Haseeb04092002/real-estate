<!-- Core libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Cropper -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<!-- Other vendor libraries -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- Utilities and plugins -->
<script src="<?= base_url('assets/js/search_box.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.13.2/jquery-ui.min.js"></script>
<script src="<?= base_url('assets/js/custom-alerts.js'); ?>"></script>
<script src="<?= base_url('assets/js/main.js'); ?>"></script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


<!-- Tippy.js Script -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>

<!-- Global Loader Script -->
<script>
$(document).ready(function() {
    // Show loader for AJAX requests
    $(document).ajaxStart(function() {
        $('#global-loader').removeClass('d-none').addClass('d-flex');
    });
    // Hide loader on AJAX complete
    $(document).ajaxStop(function() {
        $('#global-loader').removeClass('d-flex').addClass('d-none');
    });

    // Show loader on normal form submissions
    $(document).on('submit', 'form:not(.no-loader)', function() {
        $('#global-loader').removeClass('d-none').addClass('d-flex');
    });

    // Show loader on normal link navigation
    $(document).on('click', 'a[href]:not([href^="#"]):not([href^="javascript:"]):not([target="_blank"]):not(.no-loader)', function(e) {
        if (e.isDefaultPrevented()) return;
        $('#global-loader').removeClass('d-none').addClass('d-flex');
    });
    
    // Hide loader if returning via back/forward cache
    $(window).on('pageshow', function(event) {
        if (event.originalEvent && event.originalEvent.persisted) {
            $('#global-loader').removeClass('d-flex').addClass('d-none');
        }
    });
});
</script>


