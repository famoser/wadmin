<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 25.05.2015
 * Time: 10:08
 */
?>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/crudheader.php"; ?>

    <form action="<?php echo $this->controller ?>/<?php echo $this->link ?>/<?php echo GetValue($this->_['obj'], "Id") ?>/"
        method="post">
        <input type="hidden" name="delete" value="true"/>

        <p>Soll <b><?php echo $this->_['obj']->GetIdentification() ?></b> wirklich gelöscht werden?</p>

        <div class="clearfix">
            <div class="col-md-12">
                <input type="submit" value="Löschen" class="btn">
            </div>
        </div>
    </form>

<?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/crudfooter.php"; ?>