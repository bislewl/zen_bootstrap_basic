$(document).ready(function () {
    showPageSearchResult($('#searchReloadedSearchInput').val(), 0);
    $('.searchPaginationLink').click(function () {
        console.log('page button clicked');
        var str = $('#searchReloadedSearchInput').val();
        var limit = $(this).attr('data-limit');
        var offset = $(this).attr('data-offset');
        showPageSearchResult(str, offset);
        $('html,body').animate({scrollTop: 100}, 350);
    });
//                $("#searchReloadedSearchInput").bind("keyup change", function(e) {
//                    showPageSearchResult($('#searchReloadedSearchInput').val(), 10, 0);
//                })
//                $('#srProductCount').change(function () {
//                    ($('#searchReloadedSearchInput').val(), 0);
//                })
});
