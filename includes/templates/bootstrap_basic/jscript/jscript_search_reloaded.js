
$(function () {
    $("#headerSearchBox").autocomplete({
        minLength: 3,
        delay: 500,
        source: function (request, response) {
            $.post("ajax.php?act=SearchResults&method=getResults", {
                keyword: $("#headerSearchBox").val()
            }, function (data) {
                // data is an array of objects and must be transformed for autocomplete to use
                var array = data.error ? [] : $.map(data.products, function (m) {
                    return {
                        label: m.products_name,
                        value: m.products_id,
                        url: m.products_link
                    };
                });
                console.log(array);
                response(array);
            });
        },
        focus: function (event, ui) {
            event.preventDefault();
            $("#headerSearchBox").val(ui.item.label)
        },
        select: function (event, ui) {
            event.preventDefault();
            var productURL = ui.item.url;
            productURL = productURL.replace(/&amp;/g, '&');
            window.location = productURL;
        }
    });
});

function showHeaderSearchResult(str) {
    var keywords = str;
    var product = '';
    var searchBox = '';
    // $('#livesearch').slideUp();
    if (keywords.length > 2) {
        $.post('ajax.php?act=SearchResults&method=getResults', {keyword: keywords}, function (data) {
            for (i in data.products) {
                product = '<a href="' + data.products[i].products_link + '">' + data.products[i].products_name + '</a>';
                product.replace('&amp;', '&');
                searchBox = searchBox + product;
            }
            $('#livesearch').html(searchBox);
            $('#livesearch').slideDown();
        });
    }
    else {
        $('#livesearch').hide();
        $('#livesearch').html(searchBox);
    }
    return false;
}

function showPageSearchResult(str, offset) {
    $('#searchPaginationBack').hide();
    $('#searchPaginationNext').hide();
    $('#searchReloadsResultsFor').text(str);
    var keywords = encodeURIComponent(str);
    var product = '';
    var searchBox = '';
    var productBox = '';
    var productTitle = '';
    var limit = $('#srProductCount').val()
    var sampleProductBox = $('#searchReloadedSampleProductBox').html();
    if (keywords.length > 2) {
        // $('#searchReloadedProductListing').html('');
        $.post('ajax.php?act=SearchResults&method=getResults', {
            keyword: keywords,
            limit: limit,
            offset: offset
        }, function (data) {
            $('#searchReloadedProductsContainer').html(' ');
            for (i in data.products) {
                productBox = sampleProductBox;
                productBox = productBox.replace(/{products_id}/g, data.products[i].products_id);
                productBox = productBox.replace(/{products_name}/g, data.products[i].products_name);
                productBox = productBox.replace(/{products_image_alt}/g, data.products[i].products_image_alt);
                productBox = productBox.replace(/{products_link}/g, data.products[i].products_link);
                productBox = productBox.replace(/{products_image}/g, data.products[i].products_image);
                productBox = productBox.replace(/{products_price}/g, data.products[i].products_price);
                productBox = productBox.replace(/{products_units}/g, data.products[i].products_units);
                productBox = productBox.replace(/{bisn_text}/g, data.products[i].bisn_text);
                productBox = productBox.replace(/{products_shipping_text}/g, data.products[i].products_shipping_text);
                productBox = productBox.replace(/{clear_fix}/g, data.products[i].clear_fix);

                productTitle = data.products[i].products_title;
                if (productTitle.length > 100) {
                    productTitle = (productTitle.substr(0, productTitle.lastIndexOf(' ', 97)) + '...');
                }
                productBox = productBox.replace(/{products_title}/g, productTitle);
                $('#searchReloadedProductsContainer').append(productBox);
            }
            $('#searchReloadedProductsCount').text(data.total_count);

            if (data.pageBack.status == 1) {
                $('#searchPaginationBack').show();
                $('#searchPaginationBack').attr('data-limit', data.pageBack.max);
                $('#searchPaginationBack').attr('data-offset', data.pageBack.offset);
            }
            if (data.pageNext.status == 1) {
                $('#searchPaginationNext').show();
                $('#searchPaginationNext').attr('data-limit', data.pageNext.max);
                $('#searchPaginationNext').attr('data-offset', data.pageNext.offset);
            }
        });
    }
    else {
        $('#searchReloadedHeaderTag').hide();
        $('#searchReloadedProductsContainer').html(' ');
        $('#searchPaginationBack').hide();
        $('#searchPaginationNext').hide();
    }

    return false;
}

function searchReloadedBISNClick(pID) {
    event.preventDefault();
    $('.back-in-stock-popup-wrapper-button-row').show();
    $('.back-in-stock-popup-content-wrapper').show();
    console.log('bisn clicked' + pID);
    $('#contact_messages').empty();
    $('#back-in-stock-product-image img').attr('src', $('#productListingProductID-'+pID+' .listingProductImage').attr('src'));
    $('#productName').html($('#productListingProductID-'+pID+' .itemTitle').text());
    $('input[name="product_id"]').attr('value', pID);
    $.fancybox({
        href: '#back-in-stock-popup-wrapper'
    });
}