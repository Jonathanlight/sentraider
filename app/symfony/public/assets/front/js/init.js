// Animations initialization
$(document).ready(function() {
    new WOW().init();
    $("#mdb-lightbox-ui").load("assets/front/mdb-addons/mdb-lightbox-ui.html");
    $(".mdb-select").materialSelect();
    $('.select-wrapper.md-form.md-outline input.select-dropdown').bind('focus blur', function () {
        $(this).closest('.select-outline').find('label').toggleClass('active');
        $(this).closest('.select-outline').find('.caret').toggleClass('active');
    });
    $(".button-collapse").sideNav();
    $('.datepicker').pickadate({
        format: 'yyyy-mm-dd'
    });
    $('#seance_heure_start').pickatime({
        format: 'HH:mm'
    });
    $('#seance_heure_end').pickatime({
        format: 'HH:mm'
    });
    $('.chips').on('chip.add', function(e, chip){
        // you have the added chip here
    });

    $('.chips').on('chip.delete', function(e, chip){
        // you have the deleted chip here
    });

    $('.chips').on('chip.select', function(e, chip){
        // you have the selected chip here
    });

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "md-toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 300,
        "hideDuration": 1000,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
});
$('.carousel.carousel-multi-item.v-2 .carousel-item').each(function(){
    var next = $(this).next();
    if (!next.length) {
        next = $(this).siblings(':first');
    }
    next.children(':first-child').clone().appendTo($(this));

    for (var i=0;i<4;i++) {
        next=next.next();
        if (!next.length) {
            next=$(this).siblings(':first');
        }
        next.children(':first-child').clone().appendTo($(this));
    }
});