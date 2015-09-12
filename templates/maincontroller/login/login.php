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

    <form id="login" class="no-ajax" action="/" method="post">

        <?php echo GetInput($this->_["save"],"email", "Email", "email", null, "Ihre E-Mail"); ?><br/>
        <?php echo GetInput($this->_["save"],"password", "Passwort", "password", null, "Ihr Passwort"); ?><br/>

        <p><a href="forgotpass">Passwort vergessen</a></p>
        <?php echo GetSubmit("Einloggen") ?>
    </form>

<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/footer.php";
?>