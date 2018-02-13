<?php
/**
 *  bootstrap_basic_config.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/7/2017 8:01 PM Modified in  everbrite_coatings
 */
include('includes/application_top.php');

?>
    <!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
    <html <?php echo HTML_PARAMS; ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
        <title><?php echo TITLE; ?></title>
        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
        <link rel="stylesheet" type="text/css" href="includes/cssjsmenuhover.css" media="all" id="hoverJS">
        <link rel="stylesheet" type="text/css" href="includes/admin_access.css">
        <?php
        $zcV155 = (PROJECT_VERSION_MAJOR > 1 || (PROJECT_VERSION_MAJOR == 1 && substr(PROJECT_VERSION_MINOR, 0, 3) >= 5.5));
        if ($zcV155 != true) {
            ?>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
            <?php
        }
        ?>
        <link rel="stylesheet" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="includes/css/bootstrap_basic.css">
        <script type="text/javascript" src="includes/menu.js"></script>
        <script type="text/javascript" src="includes/general.js"></script>
        <?php
        if ($zcV155 != true) {
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

            function checkAll(form, header, value) {
                for (var i = 0; i < form.elements.length; i++) {
                    if (form.elements[i].className == header) {
                        form.elements[i].checked = value;
                    }
                }
            }

            // -->
        </script>
    </head>
    <body onload="init()">
    <!-- header //-->
    <?php require(DIR_WS_INCLUDES . 'header.php'); ?>
    <!-- header_eof //-->

    <?php include('includes/javascript/bootstrap_basic.php'); ?>

    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h1><?php echo HEADING_TITLE; ?></h1>
            </div>
        </div>
    </div>
    <div class="container" id="bootstrapBasicPillsBox">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <ul class="nav nav-pills" id="bootstrapBasicPills">

                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <h2 id="bootstrapBasicTabTitle"></h2>
            </div>
        </div>
    </div>
    <div class="container" id="bootstrapBasicAddEditBox">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
                <div id="bootstrapBasicForm">

                </div>

                <div id="bootstrapBasicAddButton">
                    <button type="button" onclick="getBootstrapBasicForm()" class="btn-primary btn yls-btn">
                        <i class="fa fa-plus-circle"></i> Add
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="bootstrapBasicListingBox">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div id="bootstrapBasicListing">

                </div>
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
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<?php
