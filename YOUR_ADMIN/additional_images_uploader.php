<?php
/**
 *  additional_images_uploader.php
 *
 * @copyright Copyright 2003-2018 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  2/19/2018 12:18 PM Modified in zencart_additional_images_uploader
 *
 */

include('includes/application_top.php');
?>
    <!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
    <html <?php echo HTML_PARAMS; ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
        <title><?php echo HEADING_TITLE; ?></title>
        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
        <link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
        <link rel="stylesheet" type="text/css" href="includes/admin_access.css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
		<?php
		$zcV155 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5.5));
		if($zcV155 != true){
			?>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
			<?php
		}
		?>
        <link rel="stylesheet" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="includes/css/additional_images_uploader.css">
        <script type="text/javascript" src="includes/menu.js"></script>
        <script type="text/javascript" src="includes/general.js"></script>
		<?php
		if($zcV155 != true){
			?>
            <script language="javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
			<?php
		}
		?>
        <script type="text/javascript">
            <!--
            function init() {
                cssjsmenu('navbar');
                if (document.getElementById) {
                    var kill = document.getElementById('hoverJS');
                    kill.disabled = true;
                }
            }

            // -->
        </script>
    </head>
    <body onLoad="init()">
    <!-- header //-->
	<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->

    <script type="text/javascript" src="includes/javascript/additional_images_uploader.js"></script>

    <div class="container" id="additionalImageUploader">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1><?php echo HEADING_TITLE; ?></h1>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div>
                    <ol>
                        <li><?php echo TEXT_AIU_INSTRUCTIONS_STEP_ONE; ?></li>
                        <li><?php echo TEXT_AIU_INSTRUCTIONS_STEP_TWO; ?></li>
                        <li><?php echo TEXT_AIU_INSTRUCTIONS_STEP_THREE; ?></li>
                        <li><?php echo TEXT_AIU_INSTRUCTIONS_STEP_FOUR; ?></li>
                        <li><?php echo TEXT_AIU_INSTRUCTIONS_STEP_FIVE; ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="additionalImagesProductSearch">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4" id="additionalImagesSearchProductForm">
					<?php
					echo zen_draw_form('search_for_product', FILENAME_ADDITIONAL_IMAGES_UPLOADER);
					?>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="search" placeholder="Search" name="search">
                        </div>
                        <div class="col-sm-2">
                            <button type="submit" class="btn btn-primary"><?php echo TEXT_AIU_SEARCH; ?></button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                    <ul id="additionalImagesProductSearchResults">

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="additionalImagesProductSelected">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2 id="additionalImageProductName"></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="additionalImagesUploaderForm">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<?php
					echo zen_draw_form('additional_image_upload', FILENAME_ADDITIONAL_IMAGES_UPLOADER, 'process=uploadAdditionalImage', 'POST', ' id="additional_image_upload" enctype="multipart/form-data"');
					echo zen_draw_hidden_field('image_target', 'images')
					?>
                    <input type="hidden" id="product_id_input" name="product_id" value="<?php echo (int)zen_db_prepare_input($_GET['product_id']); ?>">
                    <legend><?php echo TEXT_AIU_ADD_IMAGE; ?></legend>
                    <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                        <div class="form-group">
                            <label for="looks_image_file"><?php echo TEXT_AIU_ADDITIONAL_FILE_IMAGE; ?></label>
							<?php
							echo zen_draw_file_field('additional_image_file');
							?>
                            <input type="hidden" value="" name="new_filename" id="new_filename">
                            <input type="hidden" value="" name="destination" id="destination">
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                        <button type="submit" class="btn btn-primary"><?php echo TEXT_AIU_UPLOAD; ?></button>
                    </div>
					<?php
					echo '</form>';
					?>

                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="additionalImagesUploaderImagesBox">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h3><?php echo TEXT_AIU_CURRENT_IMAGES; ?></h3>
                </div>
            </div>
            <div class="row" id="additionalImagesUploaderImages">

            </div>
        </div>
    </div>

    <div class="clearfix"></div>

    <div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    © Copyright Pro-Webs.net 2017-<?php echo date("Y"); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- body_eof //-->
    <div class="bottom">
        <!-- footer //-->
		<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
        <!-- footer_eof //-->
    </div>
    </body>
    </html>
<?php

require(DIR_WS_INCLUDES . 'application_bottom.php');