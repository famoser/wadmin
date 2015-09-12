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
        <h1>Import</h1>

        <?php if (!isset($this->_["step"])) {
            ?>
            <p>Wählen Sie eine Datei aus, die Sie importieren möchten.</p>

            <form action="/import/upload/" data-replaceparent="true" method="post" enctype="multipart/form-data">
                <input type="hidden" name="step" value="1">
                <input type="file" name="importfile">

                <input type="submit" value="Überprüfen">
            </form>
        <?php } else if ($this->_["step"] == 2) {
            ?>
            <form action="/import/upload/" method="post" data-replaceparent="true">
                <input type="hidden" name="filepath" value="<?php echo $this->_["filepath"]; ?>">
                <input type="hidden" name="step" value="2">
                <input type="hidden" name="type" value="<?php echo $this->_["type"]; ?>">
                <input type="submit" value="Ich habe die Warnung gelesen, Import starten!">
            </form>
        <?php } else {
            ?>
            <p><a href="import">zurück</a></p>
        <?php } ?>
    </div>
<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/footer.php";
?>