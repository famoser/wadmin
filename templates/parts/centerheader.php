<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 01.07.2015
 * Time: 19:21
 */
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/_headerPart.php"; ?>

<body>
<div class="mobile-container">
<div id="loadingbar"></div>
<header class="no-menu">
    <div class="container">
        <div class="clearfix">
            <div class="col-md-6">
                <a href="<?php echo BASEURL ?>">
                    <img class="brand" width="111" height="33" alt="Admin Logo" src="/images/Logo.png">
                </a>
            </div>
            <div class="col-md-6">
                <h2 class="application"><?php echo APPLICATION_TITLE ?></h2>
            </div>
        </div>
    </div>
</header>

<div class="center-content-wrapper">
    <div class="container">
        <?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/messagetemplate.php"; ?>
        <div class="center-content content">
