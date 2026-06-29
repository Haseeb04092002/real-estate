// ----------- sale and rent pricing  ------------ //
const ListType = document.getElementById("ListType");
const salePrice = document.getElementById("salePrice");
const rentPrice = document.getElementById("rentPrice");
window.onload = function () {
    if(salePrice && rentPrice){
        salePrice.style.display = 'd-block';
        rentPrice.style.display = 'd-none';
    }
}

if(ListType){
    if (ListType.value == 'sale')
    {
        salePrice.style.display = 'd-block';
        rentPrice.style.display = 'd-none';
    }
    if (ListType.value == 'rent')
    {
        rentPrice.style.display = 'd-block';
        salePrice.style.display = 'd-none';
    }
}




// ----------- check empty fields alerts ------------ //
function validateForm_property_add() {

    let chkPropertyType = document.forms["property_add"]["chkPropertyType"].value;
    // let email = document.forms["myForm"]["email"].value;

    // if (chkPropertyType === "" || email === "") {
    if (chkPropertyType === "") {
        alert("All fields are required!");
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}



var PropertyStatus = document.getElementById("ListType");
const Installments = document.getElementById("Installments");
// window.onload = function(e){
//     Installments.style.display = "none"
// }
if(PropertyStatus){
    PropertyStatus.onchange = function() {
        var Status = '';
        
          var Status = PropertyStatus.options[PropertyStatus.selectedIndex].value;
        // }

      if (Status === 'rent') {
        Installments.style.display = "flex"
      } else {
        Installments.style.display = "none"
      }
    };
}



// ---------- side menu display-------//
const mobileScreen = window.matchMedia("(max-width: 990px)");

$(document).ready(function() {
    $(".dashboard-nav-dropdown-toggle").click(function() {
        const parentDropdown = $(this).closest(".dashboard-nav-dropdown");

        // Toggle the clicked dropdown and close siblings
        parentDropdown.toggleClass("show");
        parentDropdown.siblings().removeClass("show");

        // Close nested dropdowns within the same parent
        parentDropdown.find(".dashboard-nav-dropdown").removeClass("show");
    });

    $(".menu-toggle").click(function() {
        if (mobileScreen.matches) {
            $(".dashboard-nav").toggleClass("mobile-show");
        } else {
            $(".dashboard").toggleClass("dashboard-compact");
        }
    });
});


(function($) {
    "use strict";

    // Spinner
    var spinner = function() {
        setTimeout(function() {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();


    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function() {
        if ($(this).scrollTop() > 45) {
            $('.nav-bar').addClass('sticky-top');
        } else {
            $('.nav-bar').removeClass('sticky-top');
        }
    });


    // Back to top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function() {
        $('html, body').animate({
            scrollTop: 0
        }, 1500, 'easeInOutExpo');
        return false;
    });


    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1500,
        items: 1,
        dots: true,
        loop: true,
        nav: true,
        navText: [
            '<i class="fa-solid fa-chevron-left"></i>',
            '<i class="fa-solid fa-chevron-right"></i>'
        ]
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        margin: 24,
        dots: false,
        loop: true,
        nav: true,
        navText: [
            '<i class="fa-solid fa-arrow-left"></i>',
            '<i class="fa-solid fa-arrow-right"></i>'
        ],
        responsive: {
            0: {
                items: 1
            },
            992: {
                items: 2
            }
        }
    });

})(jQuery);