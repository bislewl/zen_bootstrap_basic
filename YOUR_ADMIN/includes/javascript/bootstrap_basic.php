<?php
/**
 *  bootstrap_basic.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  9/8/2017 11:44 AM Modified in  everbrite_coatings
 */
?>

<script type="text/javascript">
    function wordToUpperFirst(word) {
        return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
    }

    function getBootstrapBasicDisplay(tab) {
        $('#bootstrapBasicListing').html('');
        var urlParameters = 'act=BootstrapBasic&method=getListing' + wordToUpperFirst(tab);
        $.post("<?php echo zen_href_link(FILENAME_AJAX); ?>?" + urlParameters, {id: 0}, function (data) {
            var fields = data.fields;
            $('#bootstrapBasicListing').text(fields);
            var listingData = data;
            drawListingBootstrapBasic(listingData);
        }, 'json');
    }

    function getBootstrapBasicFilteredDisplay(tab, filterField) {
        var filterValue = $('#' + filterField).val();
        var postData = filterField + '=' + filterValue;
        console.log(postData);
        $('#bootstrapBasicListing').html('');
        var urlParameters = 'act=BootstrapBasic&method=getListing' + wordToUpperFirst(tab);
        $.post("<?php echo zen_href_link(FILENAME_AJAX); ?>?" + urlParameters, postData, function (data) {
            var fields = data.fields;
            $('#bootstrapBasicListing').text(fields);
            var listingData = data;
            drawListingBootstrapBasic(listingData);
        }, 'json');
    }

    function getBootstrapBasicDrawForm(tab) {
        var urlParameters = 'act=BootstrapBasic&method=getForm' + wordToUpperFirst(tab);
        $.post("<?php echo zen_href_link(FILENAME_AJAX); ?>?" + urlParameters, {id: 0}, function (data) {
            var formHTML = data.form_html;
            $('#bootstrapBasicForm').html(formHTML);
        }, 'json');
        $('#bootstrapBasicAddButton').hide();
    }

    function clickBootstrapBasicAddEditBoxCancel() {
        $('#bootstrapBasicAddButton').show();
        $('#bootstrapBasicAddEditBox').slideUp();
    }

    function clickBootstrapBasicAddEditBoxSubmit(formID) {
        var serializedInputs = $("#" + formID).serialize();
        var errorSelector = '#' + formID + 'Errors';
        var formType = $("#bootstrapBasicFormType").val();
        console.log(formType);
        var tab = formType.split('-')[0];
        var changeType = formType.split('-')[1];
        var urlParameters = 'act=BootstrapBasic&method=' + changeType + wordToUpperFirst(tab);
        $(errorSelector).html();
        $.post("<?php echo zen_href_link(FILENAME_AJAX); ?>?" + urlParameters, serializedInputs, function (data) {
            if (data.errors !== undefined) {
                var errors = data.result.error;
                var errorContent = 'ERROR';
                $.each(errors, function (index, error) {
                    errorContent = errorContent + error;
                })
            }
            if (data.result.success !== undefined) {
                $('#bootstrapBasicFormResult').text('Saved');
            }
        }, 'json');
        setTimeout(function () {
            getBootstrapBasicDisplay(tab);
        }, 2000);

    }


    function editBootstrapBasic(classUnique) {
        var serializedInputs = $("." + classUnique).serialize();
        var tab = classUnique.split('-')[0];
        var uID = classUnique.split('-')[1];
        var urlParameters = 'act=BootstrapBasic&method=edit' + wordToUpperFirst(tab);
        $.post("<?php echo zen_href_link(FILENAME_AJAX); ?>?" + urlParameters, serializedInputs, function (data) {
            if (data.result.success !== undefined) {
                $('#editButton-' + classUnique).text('Saved');
                $('#editButton-' + classUnique).delay(2800).text('Edit');
            }
        }, 'json');

    }

    function deleteBootstrapBasic(classUnique) {
        var tab = classUnique.split('-')[0];
        var uID = classUnique.split('-')[1];
        var deleteKey = 'bootstrap_basic_' + tab + '_id';
        var urlParameters = 'act=BootstrapBasic&method=delete' + wordToUpperFirst(tab);
        var postString = deleteKey + '=' + uID;

        $.post("<?php echo zen_href_link(FILENAME_AJAX); ?>?" + urlParameters, postString, function (data) {
            if (data !== undefined) {
                var $deletedRow = $('#editButton-' + classUnique).closest('tr');
                console.log($deletedRow);
                var deletedRowCols = $deletedRow[0].childElementCount;
                console.log(deletedRowCols);
                $($deletedRow).html('<td colspan="' + deletedRowCols + '" class="deletedRow">' + 'DELETED ' + '</td>');
                $($deletedRow).slideUp('slow');
            }
        }, 'json');
    }

    function preDeleteBootstrapBasic(classUnique) {
        var tab = classUnique.split('-')[0];
        var uID = classUnique.split('-')[1];
        $('#deleteButton-' + tab + '-' + uID).show();
        $('#deleteButtonTest-' + tab + '-' + uID).hide();
//        console.log(uID);
    }

    function clickBootstrapBasicPill(dataTarget, title) {
        $('#bootstrapBasicAddEditBox').hide();
        $('#bootstrapBasicListing').hide();
        $("#bootstrapBasicPills>li.active").removeClass("active");
        $('#' + dataTarget + 'Pill').addClass('active');
        $('#bootstrapBasicListing').html('');
        $('#bootstrapBasicForm').html('');
        if (dataTarget === 'options' || dataTarget === 'defines') {
//            $('#bootstrapBasicAddButton').hide();
        }
        else {
            $('#bootstrapBasicAddButton').show();
        }
        $('#bootstrapBasicAddButton button').attr('onClick', 'getBootstrapBasicDrawForm(\'' + dataTarget + '\')');
        $('#bootstrapBasicTabTitle').text(title);
        $('#bootstrapBasicAddEditBox').slideDown();
        getBootstrapBasicDisplay(dataTarget);
    }

    function drawListingBootstrapBasic(listingData) {
        $('#bootstrapBasicListing').append('<table class="table table-hover table-responsive"><thead></thead><tbody class="sortableTbody"></tbody></table>');
        var keys = listingData.keys
        var rowContents = '<th class="bbListingCol-uniqueID"></th>';
        var rowEditButton = '';
        var rowDeleteButton = '';
        var uniqueID = '';
        var rowClass = '';
        var fieldSpecs = [];
        var keysDesc = [];
        var filters = false;
        $(keys).each(function (i, key) {
            var displayName = key.display;
            if (key.tooltip !== undefined) {
                displayName = displayName + key.tooltip;
            }
            if (key.filter !== undefined) {
                filters = true;
                displayName = displayName + '<br/>' + key.filter;
            }
            keysDesc = [];
            keysDesc['type'] = key.type;
            keysDesc['display'] = key.display;
            keysDesc['name'] = key.name;
            fieldSpecs[key.index] = keysDesc;
            rowContents = rowContents + '<th class="bbListingCol-'+key.name+'">' + displayName + '</th>';
        });
        rowContents = rowContents + '<th></th>';
        $("#bootstrapBasicListing>table>thead").append('<tr>' + rowContents + '</tr>');
        $(listingData.values).each(function (index, row) {
            rowContents = '';
            rowEditButton = '';
            rowDeleteButton = '';
            uniqueID = '';
            rowClass = '';
            $.each(row, function (index, value) {
                var inputField = '';
                var selected = '';
                var fieldType = fieldSpecs[index].type;
                var fieldName = fieldSpecs[index].name;
                var fieldLength = fieldSpecs[index].length;
                var parameters = '';
                if (value.normal !== undefined) {
                    var fvalue = value.normal;
                }
                if (value.uniqueid !== undefined) {
                    var fvalue = value.uniqueid;
                    uniqueID = value.uniqueid;
                    rowContents = '<td class="bbListingCol-uniqueID"><input type="hidden" class="uniqueID" value="' + uniqueID + '"></td>';
                    rowClass = listingData.tab + '-' + uniqueID;
                }
                if (value.apply !== undefined) {
                    var fvalue = value.apply.value;
                    var fieldType = value.apply.type;
                }
                if (value.select !== undefined) {
                    var fvalue = value.select.value;
                }
                if (fvalue == null) {
                    fvalue = '';
                }
                switch (fieldType) {
                    case 'select':
                        inputField = '<select data-input-group="' + rowClass + '" name="' + value.select.name + '" ' + parameters + ' class="' + rowClass + ' bbfieldwatch form-control">';
                        fvalue = value.select.value;
                        $.each(value.select.options, function (selOptIndex, selOptVal) {
                            selected = '';
                            if (selOptVal.id === fvalue) {
                                selected = ' SELECTED';
                            }
                            inputField = inputField + '<option value="' + selOptVal.id + '" ' + selected + '>' + selOptVal.text + '</option>';
                        });
                        inputField = inputField + '</select>';
                        break;
                    case 'readonly':
                        inputField = '<input data-input-group="' + rowClass + '" type="text" class="' + rowClass + ' bbfieldwatch form-control" name="' + fieldName + '" value="' + fvalue + '" readonly ' + parameters + '>';
                        break;
                    case 'textarea':
                        parameters = parameters + 'class="editorHook"';
                        inputField = '<textarea data-input-group="' + rowClass + '" class="' + rowClass + ' bbfieldwatch form-control" rows="5" cols="50" name="' + fieldName + '" ' + parameters + '>' + fvalue + '</textarea>';
                        break;
                    case 'password':
                    case 'hidden':
                    case 'text':
                    case 'email':
                    case 'phone':
                    case 'url':
                    case 'color':
                    case 'date':
                    case 'number':
                        if (fieldLength > 0) {
                            parameters = parameters + ' maxlength="' + fieldLength + '"';
                        }
                        inputField = '<input data-input-group="' + rowClass + '" class="' + rowClass + ' bbfieldwatch form-control" name="' + fieldName + '" type="' + fieldType + '" value="' + fvalue + '" ' + parameters + '>';
                        break;
                    case 'display':
                        inputField = '<span ' + parameters + ' class="' + rowClass + ' form-control">' + fvalue + '</span>';
                        break;
                    case 'html':
                        inputField = value.html;
                        break;
                }
                var fieldContents = inputField;
                fieldContents = '<td class="bbListingCol-' + fieldType + '">' + fieldContents + '</td>';
                rowContents = rowContents + fieldContents
            });


            rowEditButton = '<button type="button" onclick="editBootstrapBasic(\'' + rowClass + '\')" data-details="" id="editButton-' + rowClass + '" class="btn-default btn btnEdit">' + 'Edit' + '</button>';
            rowDeleteButton = '<button type="button" onclick="deleteBootstrapBasic(\'' + rowClass + '\')" data-details="" id="deleteButton-' + rowClass + '" class="btn-danger btn btnDel">' + 'Confirm?' + '</button>';
            rowDeleteButton = rowDeleteButton + '<button type="button" data-details="" onclick="preDeleteBootstrapBasic(\'' + rowClass + '\')" id="deleteButtonTest-' + rowClass + '" class="btn-danger btn btnDelTest">' + 'Delete' + '</button>';
            rowContents = rowContents + '<td>' + rowEditButton + '</td>';
            rowContents = rowContents + '<td>' + rowDeleteButton + '</td>';
            $("#bootstrapBasicListing>table>tbody").append('<tr id="' + rowClass + '">' + rowContents + '</tr>');

            $('.bbfieldwatch').change(function () {
                var classApply = $(this).attr('data-input-group');
                $('#editButton-' + classApply).text('Save');
                $('#editButton-' + classApply).show();
            });
//            $('.' + rowClass).change(function () {
//                $('#editButton-' + rowClass).text('Save');
//                $('#editButton-' + rowClass).show();
//            });
//            $('#deleteButtonTest-' + rowClass).click(function () {
//                $('#deleteButton-' + rowClass).show();
//                $('#deleteButtonTest-' + rowClass).hide();
//            });
        });
//        $('.btnEdit').hide();
        $('.btnDel').hide();
        $('#bootstrapBasicListing').slideDown();
        $('[data-toggle="tooltip"]').tooltip({
            placement: 'top',
            html: true,
        });
//        $('.sortableTbody').sortable({
//            axis: 'y',
//            cursor: "move",
//            change: function (event, ui) {
//                console.log(ui);
//            }
//        });
    }

    function getBootstrapBasicPermissions(request, html, toDivID) {
        var tab = request.split('-')[0];
        var task = request.split('-')[1];
        var postString = 'tab=' + tab + '&task=' + task;
        var urlParameters = 'act=BootstrapBasic&method=getAdminAccessPermissions';
        $.ajax({
            url: "<?php echo zen_href_link(FILENAME_AJAX); ?>?" + urlParameters,
            type: 'post',
            data: postString,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.permission !== undefined) {
                    $('#' + toDivID).append(html);
                    console.log(toDivID + ' : ' + html);
                }
                else {

                }
            }
        });
    }

    function addPillsBootstrapBasic() {
        var toDivID = 'bootstrapBasicPills';
        var htmlPill = '';
        htmlPill = '<li id="menuPill"><a data-target="menu" href="#menu">Menu</a></li>';
        $('#' + toDivID).append(htmlPill);
//        getBootstrapBasicPermissions('menu-display', htmlPill, toDivID);
        htmlPill = '<li id="optionsPill"><a data-target="options" href="#options">Options</a></li>';
        $('#' + toDivID).append(htmlPill);
//        getBootstrapBasicPermissions('options-display', htmlPill, toDivID);
        htmlPill = '<li id="definesPill"><a data-target="defines" href="#defines">Defines</a></li>';
        $('#' + toDivID).append(htmlPill);
//        getBootstrapBasicPermissions('defines-display', htmlPill, toDivID);


    }


    $(function () {
        addPillsBootstrapBasic();
        $('#bootstrapBasicAddEditBox').hide();
        $('#bootstrapBasicListing').hide();
        url = window.location;
        if (window.location.hash) {
            var hashTag = window.location.hash;
            var dataTarget = hashTag.split('#')[1]
            var title = $('#bootstrapBasicPills li a [data-target="' + hashTag + '"]').text();
            clickBootstrapBasicPill(dataTarget, title);
        }
        $('#bootstrapBasicPills li a').click(function () {
            var dataTarget = $(this).attr('data-target');
            var title = $(this).text();
            clickBootstrapBasicPill(dataTarget, title);
        });

    })

</script>
