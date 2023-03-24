$(document).ready(function() {
    $('.accordion-item.active .accordion-body').slideDown();
    $('.accordion-header').click(function() {
        $(this).parent().toggleClass('active');
        $(this).parent().children('.accordion-body').slideToggle();
    });
});
