<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 25.05.2015
 * Time: 15:03
 */
?>

<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/centerheader.php";
?>
    <form id="login" class="no-ajax" action="activateAccount/<?php echo $this->_["admin"]->AuthHash; ?>" method="post">
        <p class="lead">Willkommen <b><?php echo $this->_["admin"]->GetIdentification(); ?></b>, bitte legen Sie ihr Passwort fest</p>
        <input type="hidden" name="AuthHash" value="<?php echo $this->_["admin"]->AuthHash; ?>">
        <input type="hidden" name="Id" value="<?php echo $this->_["admin"]->Id; ?>">

        <?php echo GetInput(null,"passwort1", "Passwort", "password"); ?><br/>
        <?php echo GetInput(null,"passwort2", "Passwort bestätigen", "password"); ?><br/>

        <?php echo GetSubmit("Passwort setzten"); ?>
    </form>
<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/footer.php";
?>

