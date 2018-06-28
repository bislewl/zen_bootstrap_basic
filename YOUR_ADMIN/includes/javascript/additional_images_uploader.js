/**
 *  additional_images_uploader.js
 *
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  5/9/2018 3:07 PM Modified in zencart_additional_images_uploader
 *
 */

function uploadAdditionalImage() {
    var form_data = new FormData($('#additional_image_upload')[0]);
    $.ajax({
        type: 'POST',
        url: 'ajax.php?act=AdditionalImagesUploader&method=uploadAdditionalImage',
        processData: false,
        contentType: false,
        async: false,
        cache: false,
        data: form_data,
        success: function (response) {
            var jsonResult = jQuery.parseJSON(response);
            var newID = jsonResult.result.success.id;
            getAdditionalImages();
        }
    });
}

function getAdditionalImages() {
    var product_id = $('#product_id_input').val();
    $('#additionalImagesUploaderImages').html('');
    $.ajax({
        type: 'POST',
        url: 'ajax.php?act=AdditionalImagesUploader&method=getAdditionalImages',
        data: 'product_id=' + product_id,
        dataType: "json",
        success: function (data) {
            var addtlImagesHTML = '';
            $(data.images).each(function (index, value) {
                addtlImagesHTML = addtlImagesHTML + '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 additionalImagesUploaderImage">';
                addtlImagesHTML = addtlImagesHTML + '<img src="' + value.filename + '" class="img-responsive"/>';
                addtlImagesHTML = addtlImagesHTML + '<br/><a href="' + value.filename + '" target="_blank"><span>' + value.filename + '</span></a>';
                addtlImagesHTML = addtlImagesHTML + '</div>';
                $('#additionalImagesUploaderImages').html(addtlImagesHTML);
            });
            $('#new_filename').val(data.new_filename);
            $('#destination').val(data.destination);
            $('#additionalImagesUploaderImagesBox').show();
        }
    });
}

function prepareUpload(event) {
    files = event.target.files;
}

function loadProductDetails() {
    var product_id = $('#product_id_input').val();
    $.ajax({
        type: 'POST',
        url: 'ajax.php?act=AdditionalImagesUploader&method=checkProductID',
        data: 'product_id=' + product_id,
        dataType: "json",
        success: function (data) {
            $('#additionalImageProductName').text(data.products.product_name);
            $('#additionalImagesUploaderForm').show();
            $('#additionalImagesUploaderImagesBox').hide();
        }
    });
}

function checkProductID() {
    var product_id = $('#product_id_input').val();
    if (product_id.length > 0 && product_id !== '0') {
        loadProductDetails();
        getAdditionalImages();
    }
}

function searchForProduct() {
    $('form[name=search_for_product]').submit(function (e) {
        e.preventDefault();
        $("#additionalImagesSearchProductResult").html('');
        $.ajax({
            type: 'POST',
            url: 'ajax.php?act=AdditionalImagesUploader&method=searchProducts',
            data: $(this).serialize(),
            dataType: "json",
            success: function (data) {
                var productSearchResult = '';
                $(data.products).each(function (index, value) {
                    productSearchResult = productSearchResult + '<div class="productSearchResult" id="pID-' + value.products_id + '">';
                    productSearchResult = productSearchResult + 'id# ' + value.products_id + ' - ' + value.products_name + '(' + value.products_model + ')';
                    productSearchResult = productSearchResult + '</div>';
                });
                $('#additionalImagesProductSearchResults').html(productSearchResult);
                $('#additionalImagesProductSearchResults').show();
                $('.productSearchResult').click(function () {
                    var prsId = $(this).attr('id');
                    console.log(prsId);
                    var pid = prsId.replace("pID-", "");
                    $('#product_id_input').val(pid);
                    checkProductID();
                });
            }
        });
    });
}

$(function () {
    var files;
    $('form[name=search_for_product]').submit(function (e) {
        e.preventDefault();
        searchForProduct();
    });
    $('#additionalImagesUploaderForm').hide();
    $('#additionalImagesUploaderImagesBox').hide();
    $('#additionalImagesProductSearchResults').hide();
    checkProductID();
    $('input[type=file]').on('change', prepareUpload);
    $("#additional_image_upload").submit(function (event) {
        event.preventDefault();
        uploadAdditionalImage();
    });
    $('#search').keydown(function (event) {
        if (event.keyCode == 13) {
            searchForProduct();
        }
    });
});

