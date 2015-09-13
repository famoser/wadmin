<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 08.09.2015
 * Time: 15:59
 */
function GetInput($obj, $prop, $display = null, $type = "text", $special = null, $placeholder = null)
{
    if ($display == null)
        $display = $prop;
    if ($placeholder != null)
        $placeholder = ' placeholder="' . $placeholder . '" ';

    $val = GetValue($obj, $prop);

    $html = '<label for="' . $prop . '">' . $display . '</label><br/>';
    if ($type == "textarea") {
        $html .= '<textarea' . $placeholder . ' class="interactive" id="' . $prop . '" name="' . $prop . '">' . $val . '</textarea>';
    } else if ($type == "select" || (strpos($type, "multiple") !== false && strpos($type, "select") !== false)) {
        $html .= '<select' . $placeholder . ' name="' . $prop . '" id="' . $prop . '"';
        if (strpos($type, "multiple") !== false) {
            $html .= 'multiple';
        }
        $html .= '>';
        foreach ($special as $item) {
            $html .= '<option value="' . GetValue($item, "Id") . '">' . $item->GetIdentification() . '</option>';
        }
        $html .= '</select>';
    } else {

        $html .= '<input' . $placeholder . ' id="' . $prop . '" name="' . $prop . '" type="' . $type . '"';
        if ($type == "checkbox") {
            if ($val == 1) {
                $html .= ' checked="checked" value="true"';
            }
        } else  {
            if ($val != null) {
                if ($type == "date") {
                    $date = DateTime::createFromFormat(DATE_FORMAT_DATABASE, $val);
                    if ($date != false && $val != null)
                        $html .= ' value="' . $date->format(DATE_FORMAT_INPUT) . '"';
                } else if ($type == "datetime") {
                    $date = DateTime::createFromFormat(DATETIME_FORMAT_DATABASE, $val);
                    if ($date != false)
                        $html .= ' value="' . $date->format(DATETIME_FORMAT_INPUT) . '"';
                } else if ($type == "time") {
                    $date = DateTime::createFromFormat(TIME_FORMAT_DATABASE, $val);
                    if ($date != false)
                        $html .= ' value="' . $date->format(TIME_FORMAT_INPUT) . '"';
                } else {
                    $html .= ' value="' . $val . '"';
                }
            }
        }
        $html .= ">";
        if ($type == "checkbox")
            $html .= '<input type="hidden" name="' . $prop . 'CheckboxPlaceholder" value="true">';
    }

    return $html;
}

function GetSubmit($customText = "Speichern")
{
    return '<input type="submit" value="' . $customText . '" class="btn">';
}

function GetValue($obj, $prop)
{
    $val = null;
    if ($obj != null) {
        if (is_array($obj) && isset($obj[$prop]))
            $val = $obj[$prop];
        if (is_object($obj) && isset($obj->$prop))
            $val = $obj->$prop;
    }
    return $val;
}