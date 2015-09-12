<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 01.06.2015
 * Time: 20:53
 */ ?>
<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/header.php";
?>
    <div class="col-md-12 content">
        <h1>Export</h1>
        <p>Wählen Sie eine Vorlage aus, um von der Datenbank zu exportieren</p>
    </div>
    <div class="col-md-mg-3 content">
        <a class="tilebutton" href="export/download/excel/">
            Adressverzeichnis herunterladen
        </a>
    </div>
    <div class="col-md-mg-3 content">
        <a class="tilebutton" href="export/download/database/">
            Sicherungsdatei herunterladen
        </a>
    </div>
<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/footer.php";
?>