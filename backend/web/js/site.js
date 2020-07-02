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
    $('body').on('click', '.test_oauth2', function () {
        var data = "{'grant_type':'password','username':'admin','password':'1111','client_id':'testclient','client_secret':'testpass'}";
        $.json("http://api.shop.loc/oauth2/token", data, function (data) {
            alert(data);
        });
    });
})(window.jQuery);