<?php
/**
* @package page template
* @copyright Copyright 2003-2006 Zen Cart Development Team
* @copyright Portions Copyright 2003 osCommerce
* @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
* @version $Id: Define Generator v0.1 $
*/

// THIS FILE IS SAFE TO EDIT! This is the template page for your new page 

?>
<!-- bof tpl_frequently_asked_questions_default.php -->
	<div class='centerColumn' id='frequently_asked_questions'>
		<h1 id='frequently_asked_questions-heading'><?php echo HEADING_TITLE; ?></h1>
		<div id='frequently_asked_questions-content' class='content'>
		<?php
		/**
		* require the html_define for the frequently_asked_questions page
		*/
		require($define_page);
		?>
		</div>
	</div>
<!-- eof tpl_frequently_asked_questions_default.php -->
