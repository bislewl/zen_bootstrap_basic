<?php
/**
 *  bootstrap_basic_functions.php
 *
 * @copyright Copyright 2003-2017 Zen Cart Development Team
 * @copyright Portions Copyright 2003 osCommerce
 * @license http://www.zen-cart.com/license/2_0.txt GNU Public License V2.0
 * @version Author: bislewl  12/1/2017 1:33 PM Modified in yogalifestyle
 */

function build_bs_form_field($array)
{
    if (!isset($array['label'])) $array['label'] = $array['name'];
    if (!isset($array['id'])) $array['id'] = $array['name'];
    if (!isset($array['class'])) $array['class'] = '';
    if (!isset($array['value'])) $array['value'] = '';
    if (!isset($array['placeholder'])) $array['placeholder'] = '';
    if (!isset($array['field_type'])) $array['field_type'] = 'text';
    switch ($array['field_type']) {
        case 'hidden':
            $return = zen_draw_hidden_field($array['name'], $array['value']);
            break;
        case 'checkbox':
            $return = build_bs_form_field_checkbox($array);
            break;
        case 'textarea':
            $return = build_bs_form_field_textarea($array);
            break;
        case 'text':
        default:
            $return = build_bs_form_field_text($array);
            break;
    }
    return $return;
}

function build_bs_form_field_text($array)
{
    $parameters = 'class="form-control ' . $array['id'] . '"';
    if ($array['id'] != '') $parameters .= ' id="' . $array['id'] . '"';
    if ($array['placeholder'] != '') $parameters .= ' placeholder="' . $array['placeholder'] . '"';
    $return = '<div class="form-group">';
    $return .= '<label for="' . $array['name'] . '" class="col-sm-2 control-label">' . $array['label'] . ':</label>';
    $return .= '<div class="col-sm-10" >';
    $return .= zen_draw_input_field($array['name'], $array['value'], $parameters);
    $return .= '</div>';
    $return .= '</div>';
    return $return;
}

function build_bs_form_field_checkbox($array)
{
    $return = '<div class="form-group">';
    $return .= '<div class="row">';
    $return .= '<label class="col-sm-2 control-label">';
    $return .= $array['label'] . ':';
    $return .= '</label>';
    $return .= '<div class="col-sm-10">';
    $return .= zen_draw_checkbox_field($array['name'], '1', ($array['value'] == '1' ? true : false), 'id="' . $array['id'] . '" class="' . $array['class'] . '"');
    $return .= '</div>';
    $return .= '</div>';
    $return .= '</div>';
    return $return;
}

function build_bs_form_field_textarea($array)
{
    $parameters = 'class="form-control ' . $array['id'] . '"';
    if ($array['id'] != '') $parameters .= ' id="' . $array['id'] . '"';
    $return = '<div class="form-group">';
    $return .= '<label for="' . $array['name'] . '" class="col-sm-2">' . $array['label'] . ':</label>';
    $return .= '<div class="col-sm-10">';
    $return .= zen_draw_textarea_field($array['name'], 'soft', 60, 5, $array['value'], $parameters);
    $return .= '</div>';
    $return .= '</div>';
    return $return;
}