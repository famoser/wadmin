<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 25.05.2015
 * Time: 12:18
 */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/crudheader.php"; ?>
    <form class="form-horizontal" action="settings/addadmin" method="post">
        <p>Nach dem Erstellen des Adminaccounts wird eine Nachricht an diese E-Mail Adresse gesendet. Die E-Mail enthält
            einen Link, durch den der Admin seinen neuen Account aktivieren kann.</p>
        <input type="hidden" name="addadmin" value="true"/>

        <div class="clearfix">
            <div class="col-md-12">
                <?php echo GetInput($this->_["obj"], "Email", "Email", "email"); ?>
            </div>
        </div>
        <div class="clearfix">
            <div class="col-md-12">
                <?php echo GetInput($this->_["obj"], "PersonId", "zugeordnete Person", "select", $this->_["persons"]); ?>
            </div>
        </div>

        <div class="clearfix">
            <div class="col-md-12">
                <?php echo GetSubmit(); ?>
            </div>
        </div>
    </form>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/crudfooter.php"; ?>