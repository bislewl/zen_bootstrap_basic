<?php
/*
 * 
 * @package checkout_reloaded
 * @copyright Copyright 2003-2015 ZenCart.Codes a Pro-Webs Company
 * @copyright Copyright 2003-2015 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @filename jscript_main.php
 * @file created 2015-02-08 12:42:06 PM
 * 
 */
?>
<noscript>
<meta http-equiv="refresh" content="0; URL=<?php echo zen_href_link(FILENAME_CHECKOUT_RELOADED, 'noscript_active=1'); ?>">
</noscript>
<script language="javascript" type="text/javascript"><!--
    /* BOF core functions*/
    var selected;
            var submitter = null;
            function concatExpiresFields(fields) {
            return $(":input[name=" + fields[0] + "]").val() + $(":input[name=" + fields[1] + "]").val();
            }
    function popupWindow(url) {
    window.open(url, 'popupWindow', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
    }
    function couponpopupWindow(url) {
    window.open(url, 'couponpopupWindow', 'toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,copyhistory=no,width=450,height=320,screenX=150,screenY=150,top=150,left=150')
    }
    function submitFunction($gv, $total) {
    if ($gv >= $total) {
    submitter = 1;
    }
    }
    function session_win() {
    window.open("<?php echo zen_href_link(FILENAME_INFO_SHOPPING_CART); ?>", "info_shopping_cart", "height=460,width=430,toolbar=no,statusbar=no,scrollbars=yes").focus();
    }
    /* Ajax Core Script */
    function methodSelect(theMethod) {
    if (document.getElementById(theMethod)) {
    document.getElementById(theMethod).checked = 'checked';
    }
    }
    function collectsCardDataOnsite(paymentValue)
    {
    zcJS.ajax({
    url: "ajax.php?act=ajaxPayment&method=doesCollectsCardDataOnsite",
            data: {paymentValue: paymentValue}
    }).done(function (response) {
    if (response.data == true) {
    var str = $('form[name="checkout_payment"]').serializeArray();
            zcJS.ajax({
            url: "ajax.php?act=ajaxPayment&method=prepareConfirmation",
                    data: str
            }).done(function (response) {
    $('#checkoutPayment').hide();
            $('#navBreadCrumb').html(response.breadCrumbHtml);
            $('#checkoutPayment').before(response.confirmationHtml);
            $(document).attr('title', response.pageTitle);
    });
    } else {
    $('form[name="checkout_payment"]')[0].submit();
    }
    });
            return false;
    }
    $(document).ready(function () {
    $('form[name="checkout_payment"]').submit(function () {
    $('.paymentSubmit').attr('disabled', true);
<?php if ($flagOnSubmit) { ?>
        formPassed = check_form();
                if (formPassed == false) {
        $('.paymentSubmit').attr('disabled', false);
        }
        return formPassed;
<?php } ?>
    });
    });
            /* EOF Core Functions */
                    /* BOF Core form checks */
                            function check_form_optional(form_name) {
                            var form = form_name;
                                    if (!form.elements['firstname']) {
                            return true;
                            } else {
                            var firstname = form.elements['firstname'].value;
                                    var lastname = form.elements['lastname'].value;
                                    var street_address = form.elements['street_address'].value;
                                    if (firstname == '' && lastname == '' && street_address == '') {
                            return true;
                            } else {
                            return check_form(form_name);
                            }
                            }
                            }
                    var form = "";
                            var submitted = false;
                            var error = false;
                            var error_message = "";
                            function check_input(field_name, field_size, message) {
                            if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
                            if (field_size == 0) return;
                                    var field_value = form.elements[field_name].value;
                                    if (field_value == '' || field_value.length < field_size) {
                            error_message = error_message + "* " + message + "\n";
                                    error = true;
                            }
                            }
                            }
                    function check_radio(field_name, message) {
                    var isChecked = false;
                            if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
                    var radio = form.elements[field_name];
                            for (var i = 0; i < radio.length; i++) {
                    if (radio[i].checked == true) {
                    isChecked = true;
                            break;
                    }
                    }
                    if (isChecked == false) {
                    error_message = error_message + "* " + message + "\n";
                            error = true;
                    }
                    }
                    }
                    function check_select(field_name, field_default, message) {
                    if (form.elements[field_name] && (form.elements[field_name].type != "hidden")) {
                    var field_value = form.elements[field_name].value;
                            if (field_value == field_default) {
                    error_message = error_message + "* " + message + "\n";
                            error = true;
                    }
                    }
                    }
                    function check_password(field_name_1, field_name_2, field_size, message_1, message_2) {
                    if (form.elements[field_name_1] && (form.elements[field_name_1].type != "hidden")) {
                    var password = form.elements[field_name_1].value;
                            var confirmation = form.elements[field_name_2].value;
                            if (password == '' || password.length < field_size) {
                    error_message = error_message + "* " + message_1 + "\n";
                            error = true;
                    } else if (password != confirmation) {
                    error_message = error_message + "* " + message_2 + "\n";
                            error = true;
                    }
                    }
                    }
                    function check_password_new(field_name_1, field_name_2, field_name_3, field_size, message_1, message_2, message_3) {
                    if (form.elements[field_name_1] && (form.elements[field_name_1].type != "hidden")) {
                    var password_current = form.elements[field_name_1].value;
                            var password_new = form.elements[field_name_2].value;
                            var password_confirmation = form.elements[field_name_3].value;
                            if (password_current == '') {
                    error_message = error_message + "* " + message_1 + "\n";
                            error = true;
                    } else if (password_new == '' || password_new.length < field_size) {
                    error_message = error_message + "* " + message_2 + "\n";
                            error = true;
                    } else if (password_new != password_confirmation) {
                    error_message = error_message + "* " + message_3 + "\n";
                            error = true;
                    }
                    }
                    }
                    function check_state(min_length, min_message, select_message) {
                    if (form.elements["state"] && form.elements["zone_id"]) {
                    if (!form.state.disabled && form.zone_id.value == "") check_input("state", min_length, min_message);
                    } else if (form.elements["state"] && form.elements["state"].type != "hidden" && form.state.disabled) {
                    check_select("zone_id", "", select_message);
                    }
                    }
                    function check_form(form_name) {
                    if (submitted == true) {
                    //alert("<?php echo JS_ERROR_SUBMITTED; ?>");
                    return false;
                    }
                    error = false;
                            form = form_name;
                            error_message = "<?php echo JS_ERROR; ?>";
<?php if (ACCOUNT_GENDER == 'true') echo '  check_radio("gender", "' . ENTRY_GENDER_ERROR . '");' . "\n"; ?>
<?php if ((int) ENTRY_FIRST_NAME_MIN_LENGTH > 0) { ?>
                        check_input("firstname", <?php echo (int) ENTRY_FIRST_NAME_MIN_LENGTH; ?>, "<?php echo ENTRY_FIRST_NAME_ERROR; ?>");
<?php } ?>
<?php if ((int) ENTRY_LAST_NAME_MIN_LENGTH > 0) { ?>
                        check_input("lastname", <?php echo (int) ENTRY_LAST_NAME_MIN_LENGTH; ?>, "<?php echo ENTRY_LAST_NAME_ERROR; ?>");
<?php } ?>
<?php if (ACCOUNT_DOB == 'true' && (int) ENTRY_DOB_MIN_LENGTH != 0) echo '  check_input("dob", ' . (int) ENTRY_DOB_MIN_LENGTH . ', "' . ENTRY_DATE_OF_BIRTH_ERROR . '");' . "\n"; ?>
<?php if (ACCOUNT_COMPANY == 'true' && (int) ENTRY_COMPANY_MIN_LENGTH != 0) echo '  check_input("company", ' . (int) ENTRY_COMPANY_MIN_LENGTH . ', "' . ENTRY_COMPANY_ERROR . '");' . "\n"; ?>
<?php if ((int) ENTRY_EMAIL_ADDRESS_MIN_LENGTH > 0) { ?>
                        check_input("email_address", <?php echo (int) ENTRY_EMAIL_ADDRESS_MIN_LENGTH; ?>, "<?php echo ENTRY_EMAIL_ADDRESS_ERROR; ?>");
<?php } ?>
<?php if ((int) ENTRY_STREET_ADDRESS_MIN_LENGTH > 0) { ?>
                        check_input("street_address", <?php echo (int) ENTRY_STREET_ADDRESS_MIN_LENGTH; ?>, "<?php echo ENTRY_STREET_ADDRESS_ERROR; ?>");
<?php } ?>
<?php if ((int) ENTRY_POSTCODE_MIN_LENGTH > 0) { ?>
                        check_input("postcode", <?php echo (int) ENTRY_POSTCODE_MIN_LENGTH; ?>, "<?php echo ENTRY_POST_CODE_ERROR; ?>");
<?php } ?>
<?php if ((int) ENTRY_CITY_MIN_LENGTH > 0) { ?>
                        check_input("city", <?php echo (int) ENTRY_CITY_MIN_LENGTH; ?>, "<?php echo ENTRY_CITY_ERROR; ?>");
<?php } ?>
<?php if (ACCOUNT_STATE == 'true') { ?>
                        check_state(<?php echo (int) ENTRY_STATE_MIN_LENGTH . ', "' . ENTRY_STATE_ERROR . '", "' . ENTRY_STATE_ERROR_SELECT; ?>");
<?php } ?>
                    check_select("country", "", "<?php echo ENTRY_COUNTRY_ERROR; ?>");
<?php if ((int) ENTRY_TELEPHONE_MIN_LENGTH > 0) { ?>
                        check_input("telephone", <?php echo ENTRY_TELEPHONE_MIN_LENGTH; ?>, "<?php echo ENTRY_TELEPHONE_NUMBER_ERROR; ?>");
<?php } ?>
<?php if ((int) ENTRY_PASSWORD_MIN_LENGTH > 0) { ?>
                        check_password("password", "confirmation", <?php echo (int) ENTRY_PASSWORD_MIN_LENGTH; ?>, "<?php echo ENTRY_PASSWORD_ERROR; ?>", "<?php echo ENTRY_PASSWORD_ERROR_NOT_MATCHING; ?>");
                                check_password_new("password_current", "password_new", "password_confirmation", <?php echo (int) ENTRY_PASSWORD_MIN_LENGTH; ?>, "<?php echo ENTRY_PASSWORD_ERROR; ?>", "<?php echo ENTRY_PASSWORD_NEW_ERROR; ?>", "<?php echo ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING; ?>");
<?php } ?>
                    if (error == true) {
                    alert(error_message);
                            return false;
                    } else {
                    submitted = true;
                            return true;
                    }
                    }
                    /* EOF Core form checks */
                    /* BOF Core Address Pulldowns */
                    function update_zone(theForm) {
                    // if there is no zone_id field to update, or if it is hidden from display, then exit performing no updates
                    if (!theForm || !theForm.elements["zone_id"]) return;
                            if (theForm.zone_id.type == "hidden") return;
                            // set initial values
                            var SelectedCountry = theForm.zone_country_id.options[theForm.zone_country_id.selectedIndex].value;
                            var SelectedZone = theForm.elements["zone_id"].value;
                            // reset the array of pulldown options so it can be repopulated
                            var NumState = theForm.zone_id.options.length;
                            while (NumState > 0) {
                    NumState = NumState - 1;
                            theForm.zone_id.options[NumState] = null;
                    }
                    // build dynamic list of countries/zones for pulldown
<?php echo zen_js_zone_list('SelectedCountry', 'theForm', 'zone_id'); ?>
                    // if we had a value before reset, set it again
                    if (SelectedZone != "") theForm.elements["zone_id"].value = SelectedZone;
                    }
                    function hideStateField(theForm) {
                    theForm.state.disabled = true;
                            theForm.state.className = 'hiddenField';
                            theForm.state.setAttribute('className', 'hiddenField');
                            document.getElementById("stateLabel").className = 'hiddenField';
                            document.getElementById("stateLabel").setAttribute('className', 'hiddenField');
                            document.getElementById("stText").className = 'hiddenField';
                            document.getElementById("stText").setAttribute('className', 'hiddenField');
                            document.getElementById("stBreak").className = 'hiddenField';
                            document.getElementById("stBreak").setAttribute('className', 'hiddenField');
                    }
                    function showStateField(theForm) {
                    theForm.state.disabled = false;
                            theForm.state.className = 'inputLabel visibleField';
                            theForm.state.setAttribute('className', 'visibleField');
                            document.getElementById("stateLabel").className = 'inputLabel visibleField';
                            document.getElementById("stateLabel").setAttribute('className', 'inputLabel visibleField');
                            document.getElementById("stText").className = 'alert visibleField';
                            document.getElementById("stText").setAttribute('className', 'alert visibleField');
                            document.getElementById("stBreak").className = 'clearBoth visibleField';
                            document.getElementById("stBreak").setAttribute('className', 'clearBoth visibleField');
                    }
                    /* EOF Core Address Pulldowns */
                    function reSetupObvservers(){
                    submitForm();
                            refreshShipping();
                            refreshPayment();
                            update_zone(document.checkout_address);
                            checkoutReloadedScrollTop();
                    }
                    function prepLink(linkID) {

                    $(linkID).click(function (event) {
                    var link = $(this).attr("href");
                            if (link.indexOf("ipn_main_handler") >= 0) {
                    return;
                    }
                    event.preventDefault();
                            if (link.indexOf("checkout_shipping") >= 0 && link.indexOf("checkout_shipping_address") == 0) {
                    reloadCheckoutShipping();
                    }
                    else {
                    $.ajax(
                    {
                    url: link,
                            type: "GET",
                            dataType: 'html',
                            success: function (data)
                            {
                            loadCenterColumn(data)
                                    reSetupObvservers();
                            }
                    });
                    }
                    });
                    }
                    function prepForms(formID) {
                    $(formID).submit(function (event) {
                    $('input[type="submit"]').val('Processing...');
                            var formURL = $(formID).attr("action");
                            if (formURL.indexOf("ipn_main_handler") >= 0) {
                    return;
                    }
                    event.preventDefault();
                            var postData = $(formID).serializeArray();
                            postData.push({name: 'checkout_reloaded_post', value: '1'});
                            $.ajax(
                            {
                            url: formURL,
                                    type: "POST",
                                    data: postData,
                                    dataType: 'html',
                                    success: function (data)
                                    {
                                    loadCenterColumn(data)
                                            if (formURL.indexOf("checkout_shipping_address") >= 0) {
                                    reloadCheckoutShipping();
                                    }
                                    reSetupObvservers();
                                    }
                            });
                    });
                    }
                    function submitForm() {
                    prepForms('form[name=login]');
                            prepForms('form[name=create_account]');
                            prepForms('form[name=create]');
                            prepForms('form[name=checkout_shipping]');
                            prepForms('form[name=checkout_shipping_address]');
                            prepForms('form[name=checkout_address]');
                            prepForms('form[name=checkout_payment]');
                            prepForms('form[name=checkout_payment_address]');
                            prepForms('form[name=no_account]');
                            prepLink('.forward a');
                            prepLink('.back a');
                            prepLink('.buttonRow Forward span a');
                    }
                    function reloadCheckoutShipping() {
                    var checkoutShipping = 'index.php?main_page=checkout_shipping';
                            $.ajax(
                            {
                            url: checkoutShipping,
                                    type: "POST",
                                    dataType: 'html',
                                    data: "checkout_reloaded_post=1",
                                    success: function (data)
                                    {
                                    loadCenterColumn(data)
                                            reSetupObvservers();
                                    }
                            });
                    }
                    function reloadCheckoutPayment() {
                    var checkoutPayment = 'index.php?main_page=checkout_payment';
                            $.ajax(
                            {
                            url: checkoutPayment,
                                    type: "GET",
                                    dataType: 'html',
                                    success: function (data)
                                    {
                                    loadCenterColumn(data)
                                            reSetupObvservers();
                                    }
                            });
                    }
                    function refreshShipping() {
                    $('input[name="shipping"]').click(function () {
                    var shippingType = $("input[name='shipping']:checked").val();
                            dimOrderTotals();
                            var postData = $('form[name=checkout_address]').serializeArray();
                            var checkoutShipping = 'index.php?main_page=checkout_shipping';
                            postData.push({name: 'checkout_reloaded_post', value: '1'});
                            $.ajax(
                            {
                            url: checkoutShipping,
                                    type: "POST",
                                    data: postData,
                                    dataType: 'html',
                                    success: function (data)
                                    {
                                    $("fieldset[id='checkoutOrderTotals']").removeAttr('style');
                                            var shippingDetailsContent = $(data).find("fieldset[id='checkoutOrderTotals']").html();
                                            $("fieldset[id='checkoutOrderTotals']").html(shippingDetailsContent);
                                            // reloadCheckoutShipping();
                                            reSetupObvservers();
                                    }
                            });
                    });
                    }
                    function refreshPayment() {
                    $('input[name="dc_redeem_code"]').blur(function () {
                    if ($('input[name="dc_redeem_code"]').length > 3){
                    discCodeEntered();
                    }
                    });
                            $('input[name="opt_credit"]').blur(function () {
                    if ($('input[name="opt_credit"]').length > 2){
                    discCodeEntered();
                    }
                    });
                            $('input[name="cot_gv"]').blur(function () {
                    if ($('input[name="cot_gv"]').length > 2){
                    discCodeEntered();
                    }
                    });
                    }
                    function discCodeEntered() {
                    dimOrderTotals();
                            var postData = $('form[name=checkout_payment]').serializeArray();
                            var checkoutPayment = 'index.php?main_page=checkout_payment';
                            postData.push({name: 'checkout_reloaded_post', value: '1'});
                            $.ajax(
                            {
                            url: checkoutPayment,
                                    type: "POST",
                                    data: postData,
                                    dataType: 'html',
                                    success: function ()
                                    {
                                    reloadCheckoutPayment()
                                            reSetupObvservers();
                                    }
                            });
                    }
                    function dimOrderTotals() {
                    $("fieldset[id='checkoutOrderTotals']").attr('style', 'background: grey;opacity: .5;');
                    }
                    //inital load
                    $(document).ready(function () {
                    $.ajax({
                    url: '<?php echo zen_href_link(FILENAME_CHECKOUT_SHIPPING); ?>',
                            type: 'post',
                            data: 'checkout_reloaded_post=1',
                            dataType: 'html',
                            success: function (data) {
                            loadCenterColumn(data)
                                    reSetupObvservers();
                            }
                    });
                    });
                            function loadCenterColumn(data){
                            var centerColumnContent = $(data).find('.centerColumn').html();
                                    $('.centerColumn').html(centerColumnContent);
                                    var checkoutReloadedTop = $("#checkoutReloaded").offset().top;
                                    $(window).trigger('resize');
                                    if (centerColumnContent.indexOf("messageStackError") >= 0){
                            var checkoutReloadedTop = $("#checkoutReloaded").offset().top;
                                    $('html, body').animate({
                            scrollTop:  checkoutReloadedTop
                            }, 200);
                            }
                            if (centerColumnContent.length < 100){
                            reloadCheckoutShipping();
                            }
                            }
                    function checkoutReloadedScrollTop(){
                    $("html, body").animate({ scrollTop: 100 }, "slow");
                            return false;
                    }
//--></script>
