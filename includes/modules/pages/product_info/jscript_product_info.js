$(document).ready(function () {
    // setup
    var mainProductPhotos = '#productPhotos';
    $(mainProductPhotos + ' li:first-child').clone().appendTo(mainProductPhotos);
    $(mainProductPhotos + ' li:first-child').addClass('current');
    $(mainProductPhotos + ' li:last-child').addClass('hover');
    $(mainProductPhotos + ' li.hover').hide();
    swap_product_image_current();

    // hover effects
    $(".attribWithImg").mouseover(function () {
        var hoveredVariant = $(this).children('input[type="radio"]').attr('id');
        swap_product_image_hover(hoveredVariant);
        $(mainProductPhotos + ' li.current').hide();
        $(mainProductPhotos + ' li.hover').show();
    });
    $(".attribWithImg").mouseout(function () {
        $(mainProductPhotos + ' li.hover').hide();
        $(mainProductPhotos + ' li.current').show();
    });

    $(".attribWithImg").click(function () {
        swap_product_image_current();
    });
});

function swap_product_image_current() {
    var mainProductImageA = '#productPhotos li.hover a';
    var mainProductImage = '#productPhotos li.current img';
    var selectedVariantID = $(".attribWithImg > input[type='radio']:checked").attr('id');
    var selectedVariantImg = 'label[for="' + selectedVariantID + '"] img';
    var selectedVariantLabel = 'label[for="' + selectedVariantID + '"]';
    $(mainProductImageA).attr('href', $(selectedVariantLabel).attr('data-hoverImg'));
    $(mainProductImageA).data('thumb', $(selectedVariantLabel).attr('data-hoverImg'));
    $(mainProductImageA).data('caption', $(selectedVariantLabel).attr('data-hoverImg'));
    $(mainProductImage).attr('src', $(selectedVariantLabel).attr('data-hoverImg'));
    $(mainProductImage).attr('alt', $(selectedVariantImg).attr('alt'));
    $(mainProductImage).attr('title', $(selectedVariantImg).attr('title'));
    var attribModel = $('label[for="' + selectedVariantID + '"] .attributeModel').val();
    $('#productModel').text(attribModel);
}

function swap_product_image_hover(hoverID) {
    var mainProductImageA = '#productPhotos li.hover a';
    var mainProductImage = '#productPhotos li.hover img';
    var hoverVariantImg = 'label[for="' + hoverID + '"] img';
    var selectedVariantLabel = 'label[for="' + hoverID + '"]';
    // $(mainProductImage).attr('href',$(selectedVariantImg).attr('href'));
    $(mainProductImageA).attr('href', $(selectedVariantLabel).attr('data-hoverImg'));
    $(mainProductImageA).data('thumb', $(selectedVariantLabel).attr('data-hoverImg'));
    $(mainProductImageA).data('caption', $(selectedVariantLabel).attr('data-hoverImg'));
    $(mainProductImage).attr('src', $(selectedVariantLabel).attr('data-hoverImg'));
    $(mainProductImage).attr('alt', $(hoverVariantImg).attr('alt'));
    $(mainProductImage).attr('title', $(hoverVariantImg).attr('title'));
}

function clickedPinIt() {
    var urlBase = $('base').attr('href');
    var mainImage = $('#productPhotos li.current a img').attr('src');
    $('#pinItFields input[name="media"]').val(urlBase + mainImage);
    var pinItURLParams = $('#pinItFields input').serialize();
    var pinItURL = 'https://www.pinterest.com/pin/create/button/?' + pinItURLParams;
    window.open(pinItURL, '_blank');
}
