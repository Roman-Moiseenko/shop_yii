$(document).ready(function() {

    $('body').on('change', '.change-attr', function () {
        let id_category = $(this).val();
        let field_text = $('#text').val();
        let id_brand = $('#brand').val();
        //let value = $(this).attr('value');
        //alert(id);
        $.post("/shop/catalog/getsearch", {id: id_category, text: field_text, brand: id_brand}, function (data) {
            $('.block-search').html(data);
        });
    });

})(window.jQuery);