<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 24.05.2015
 * Time: 11:20
 */
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/crudheader.php"; ?>

    <form action="persons/<?php echo $this->_['mode'] ?>/<?php echo GetValue($this->_['obj'], "Id") ?>/" method="post">

        <input type="hidden" name="<?php echo $this->_['mode'] ?>" value="true"/>

        <div class="clearfix">
            <div class="col-md-6">
                <?php echo GetInput($this->_["obj"], "FirstName", "Vorname"); ?>
            </div>

            <div class="col-md-6">
                <?php echo GetInput($this->_["obj"], "LastName","Nachname"); ?>
            </div>
        </div>

        <hr/>
        <div class="clearfix">
            <div class="col-md-5">
                <?php echo GetInput($this->_["obj"], "AdressExtension","Adresszusatz"); ?>
            </div>

            <div class="col-md-5">
                <?php echo GetInput($this->_["obj"], "Street","Strasse"); ?>
            </div>

            <div class="col-md-2">
                <?php echo GetInput($this->_["obj"], "AdressAlertBool", "Adresswarnung", "checkbox"); ?>
            </div>

        </div>
        <div class="clearfix">
            <div class="col-md-2">
                <?php echo GetInput($this->_["obj"], "Land", "Land"); ?>
            </div>

            <div class="col-md-4">
                <?php echo GetInput($this->_["obj"], "ZipCode","PLZ"); ?>
            </div>

            <div class="col-md-6">
                <?php echo GetInput($this->_["obj"], "Place","Ort"); ?>
            </div>

        </div>
        <hr/>
        <div class="clearfix">

            <div class="col-md-6">
                <?php echo GetInput($this->_["obj"], "TelPrivat", "Telefon Privat"); ?>
            </div>

            <div class="col-md-6">
                <?php echo GetInput($this->_["obj"], "TelBusiness", "Telefon Geschäft"); ?>
            </div>

        </div>

        <div class="clearfix">
            <div class="col-md-6">
                <?php echo GetInput($this->_["obj"], "Mobile","Mobile"); ?>
            </div>

            <div class="col-md-6">
                <?php echo GetInput($this->_["obj"], "Email", "E-Mail"); ?>
            </div>

        </div>
        <hr/>
        <div class="clearfix">

            <div class="col-md-6">
                <?php echo GetInput($this->_["obj"], "BirthDate", "Geburtsdatum", "date"); ?>
            </div>

        </div>
        <div class="clearfix">

            <div class="col-md-6">
                <?php echo GetInput($this->_["obj"], "WakeUpTime", "Zeit", "time"); ?>
            </div>

            <div class="col-md-6">
                <?php echo GetInput($this->_["obj"], "FirstContactDateTime", "Zeit & Datum", "datetime"); ?>
            </div>

        </div>

        <hr/>

        <div class="clearfix">
            <div class="col-md-12">
                <?php echo GetInput($this->_["obj"], "Description", "Bemerkung", "textarea"); ?>
            </div>
        </div>

        <div class="clearfix">
            <div class="col-md-12">
                <?php echo GetSubmit() ?>
            </div>
        </div>
    </form>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/crudfooter.php"; ?>