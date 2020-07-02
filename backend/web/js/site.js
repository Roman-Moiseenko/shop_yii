$(document).ready(function() {

    $('body').on('click', '.featured-check', function () {
        let id = $(this).attr('data-id');
        let value = $(this).attr('value');
        $.post("/shop/product/featured?id="+id+"&featured="+value, {id: id, featured: value}, function (data) {
        });
    });
    $('body').on('click', '.discount-check', function () {
        let id = $(this).attr('data-id');
        let value = $(this).attr('value');
        $.post("/shop/discount/activate?id="+id, {id: id, activate: value}, function (data) {
        });
    });
})(window.jQuery);