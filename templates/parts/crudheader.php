<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 04.09.2015
 * Time: 10:50
 */ ?>
<?php if (!IsAjaxRequest())
{
include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/header.php"; ?>
<div class="row content">
    <?php
    }
    else { ?>
    <div class="row no-gutters content">
        <?php
        }
        include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/messagetemplate.php"; ?>

