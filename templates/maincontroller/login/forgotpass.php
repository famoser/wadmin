<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 24.05.2015
 * Time: 10:15
 */
?>
<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/centerheader.php";
?>

    <form id="login" class="no-ajax" action="forgotpass" method="post">
        <p>Geben Sie Ihre E-Mail an, mit der Sie hier registriert sind.
            Sofern diese E-Mail im System gefunden wird, bekommen Sie eine Email zugesendet mit Informationen, wie Sie das Passwort zurücksetzten können</p>
        <input type="hidden" name="AuthHash" value="<?php echo $this->_["admin"]->AuthHash; ?>"
        <input type="hidden" name="Id" value="<?php echo $this->_["admin"]->Id; ?>"

        <?php echo GetInput(null,"email", "Passwort", "email", null, "Ihre Email"); ?><br/>

        <?php echo GetSubmit("Email senden") ?>
    </form>

<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/footer.php";
?>