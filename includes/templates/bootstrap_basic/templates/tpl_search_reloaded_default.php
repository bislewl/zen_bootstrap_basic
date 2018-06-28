<?php
/**
 * @package page template
 * @copyright Copyright 2003-2006 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version $Id: Define Generator v0.1 $
 */


?>
<!-- bof tpl_search_reloaded_default.php -->
<div class='centerColumn' id='search_reloaded'>
    <h1 id='search_reloaded-heading'><?php echo HEADING_TITLE; ?></h1>
    <div id='search_reloaded-content' class='content'>
        <h2 id="searchReloadedHeaderTag">Search Results for: <span
                    id="searchReloadsResultsFor"><?php echo zen_db_prepare_input($search_reloaded_keyword); ?></span>
        </h2>
        <div id="searchReloadedSearchBox">
            <?php
            echo zen_draw_form('search_reloaded', zen_href_link(FILENAME_SEARCH_RELOADED), 'POST');
            echo zen_draw_input_field('search_keywords', zen_db_prepare_input($search_reloaded_keyword), 'id="searchReloadedSearchInput" autocomplete="off" onkeyup="showPageSearchResult(this.value,0)"')
            ?>
            <a href="#" onclick="showPageSearchResult($('#searchReloadedSearchInput').val(),0)">
                <button id="searchReloadedPageButton"><i class="fa fa-search"></i> Search</button>
            </a>
            <?php
            echo '</form>';
            ?>
        </div>
        <?php
        /**
         * require the html_define for the search_reloaded page
         */
        require($define_page);
        ?>
        <div id="searchReloadedSampleProductBox">
            <li class="productListing col-xs-12 col-sm-6 col-md-4 col-lg-3" style="min-height: 395px;"
                id="productListingProductID-{products_id}">
                <div class="searchReloadedProductBox">
                    <div class="product-image-overflow">
                        <div class="product-image"><a href="{products_link}">
                                <img alt="{products_image_alt}" title="{products_title}"
                                     src="{products_image}"
                                     style="display: inline-block;" class="listingProductImage"></a>
                        </div>
                    </div>
                    <br>
                    <h3 class="itemTitle">
                        <a href="{products_link}">
                            {products_name}
                        </a>
                    </h3><br>
                    <div class="product-price">${products_price}</div>
                    <br>
                    <div class="product-units">
                        {products_units}
                    </div>
                    <br>
                    <div class="free-shipping">
                        {products_shipping_text}
                    </div>
                    <br/>
                    <div class="bisn-text">
                        {bisn_text}
                    </div>
                </div>
            </li>
            <div class="{clear_fix}"></div>
        </div>
        <div id="searchReloadedProductsFound" class="searchReloadedHide">Products Found: <span
                    id="searchReloadedProductsCount"></span></div>
        <div id="searchReloadedDisplayProductCount" class="searchReloadedHide">Display
            <select name="srProductCount" id="srProductCount"
                    onchange="showPageSearchResult($('#searchReloadedSearchInput').val(),0)">
                <option value="16" SELECTED>16</option>
                <option value="24">24</option>
                <option value="36">36</option>
                <option value="48">48</option>
                <option value="60">60</option>
                <option value="0">ALL</option>
            </select>
        </div>
        <div id="searchReloadedProductListing">
            <ul id="searchReloadedProductsContainer" class="productsContainer container-fluid">

            </ul>
        </div>
        <div id="searchPagination">
            <div id="searchPaginationBack" class="searchPaginationLink" data-limit="" data-offset="">
                Back <i class="fa fa-backward"></i>
            </div>
            <div id="searchPaginationNext" class="searchPaginationLink" data-limit="" data-offset="">
                <i class="fa fa-forward"></i> Next
            </div>
        </div>
    </div>
</div>
<!-- eof tpl_search_reloaded_default.php -->
