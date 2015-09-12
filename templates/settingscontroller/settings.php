<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 25.05.2015
 * Time: 10:42
 */
?>
<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/header.php";
?>
    <div class="col-md-3 right-content">
        <div class="col-md-12 content">
            <form class="clearfix no-replace clear-after-submit" action="settings" method="post">
                <input type="hidden" name="changepass" value="changepass">
                <input name="Password1" id="Passwort1" placeholder="Neues Passwort festlegen" type="password">
                <input name="Password2" id="Passwort2" placeholder="Neues Passwort wiederholen" type="password">
                <input type="submit" value="Speichern">

                <?php include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/loading-replacement.php" ?>
            </form>
        </div>

        <div class="col-md-12 content">
            <a href="settings/addadmin" class="tilebutton dialogbutton" data-dialog-title="Neuer Admin erfassen"
               data-dialog-size="wide" data-dialog-type="primary">Neuer Admin erfassen
            </a>
        </div>

        <div class="col-md-12 content">
            <input type="text" class="searchinput" placeholder="Suche nach..." data-tableid="admins">
        </div>
    </div>

    <div class="col-md-9 content">
        <h1>Administratoren</h1>
        <table class="table table-hover sortable" id="admins">
            <thead>
            <tr>
                <th data-sort="string">
                    <a>Account</a>
                </th>
                <th data-sort="string">
                    <a>Email</a>
                </th>
                <th class="buttons löschen"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->_['admins'] as $admin) { ?>
                <tr>
                    <td>
                        <?php echo $admin->GetIdentification(); ?>
                    </td>
                    <td>
                        <?php echo $admin->Email; ?>
                    </td>
                    <td>
                        <div class="btn-group">

                            <a href="/settings/deleteadmin/<?php echo $admin->Id; ?>"
                               class="tilebutton dialogbutton"
                               data-dialog-idbutton0="editbutton_0"
                               data-dialog-title="Löschen" data-dialog-type="danger" role="button">
                                <span class="flaticon-cancel22"></span>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/footer.php";
?>