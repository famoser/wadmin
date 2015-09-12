<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 24.05.2015
 * Time: 10:15
 */
?>
<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/header.php";
?>
    <div class="col-md-3 right-content">
        <div class="col-md-12 content">
            <a href="persons/add" class="tilebutton dialogbutton" data-dialog-title="Neue Person erfassen"
               data-dialog-size="wide" data-dialog-type="primary">Neue Person erfassen
            </a>
        </div>

        <div class="col-md-12 content">
            <input type="text" class="searchinput" placeholder="Suche nach..." data-table-id="persons">
        </div>
    </div>

    <div class="col-md-9 content">
        <h1>Personenverzeichnis</h1>
        <table class="table table-hover sortable" id="persons">
            <thead>
            <tr>
                <th data-sort="string">
                    <a>Vorname</a>
                </th>
                <th data-sort="string">
                    <a>Nachname</a>
                </th>
                <th class="buttons buttons3"></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($this->_['persons'] as $user) {
                ?>
                <tr>
                    <td>
                        <?php echo $user->FirstName; ?>
                    </td>
                    <td>
                        <?php echo $user->LastName; ?>
                    </td>
                    <td>
                        <div class="btn-group">
                            <?php if ($user->AdressAlertBool)
                                echo '<span class="flaticon-caution7 tilebutton"></span>';
                            ?>
                            <a id="editbutton_<?php echo $user->Id; ?>" href="/persons/edit/<?php echo $user->Id; ?>"
                               class="tilebutton dialogbutton onlyicon"
                               data-dialog-idbutton0="deletebutton_<?php echo $user->Id; ?>"
                               data-dialog-title="Bearbeiten"
                               data-dialog-type="warning"
                               data-dialog-size="wide"
                               role="button">
                                <span class="flaticon-pencil124">bearbeiten</span>

                            </a>
                            <a id="deletebutton_<?php echo $user->Id; ?>"
                               href="/persons/delete/<?php echo $user->Id; ?>"
                               class="tilebutton dialogbutton onlyicon"
                               data-dialog-idbutton0="editbutton_<?php echo $user->Id; ?>"
                               data-dialog-title="Löschen"
                               data-dialog-type="danger"
                               role="button">
                                <span class="flaticon-cancel22">löschen</span>
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