<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 24.05.2015
 * Time: 10:15
 */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/_headerPart.php"; ?>
    <body>
    <div id="loadingbar"></div>

    <a class="arrow-top"></a>

    <header>
        <div class="container">
            <div class="clearfix">
                <div class="col-md-3">
                    <a href="<?php echo BASEURL ?>">
                        <img class="brand" width="111" height="33" alt="Admin Logo" src="/images/Logo.png">
                    </a>
                    <ul class="tiles menu-toggle">
                        <li>
                            <a href="#">
                                <span class="flaticon-menu55" aria-hidden="true"></span>Menu
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <h2 class="application"><?php echo APPLICATION_TITLE ?></h2>
                </div>
                <div class="col-md-3">
                    <div class="support">
                        <p><a href="mailto:wadmin@florianalexandermoser.ch">Support kontaktieren</a></p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div id="topbar" class="clearfix">
        <div class="container">
            <?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/menu.php"; ?>
        </div>
    </div>

    <div id="tab-content-slider">
        <div class="container">
            <div id="tab-content" class="clearfix">
<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/messagetemplate.php"; ?>