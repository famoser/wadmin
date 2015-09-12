<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 24.05.2015
 * Time: 10:15
 */
?>

<?php if (!IsAjaxRequest()) {
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/centerheader.php";
} ?>
<div class="clearfix">
    <?php
    DoLog($this->message, $this->loglevel);
    $logs = GetLog();
    if ($logs != null) {
        foreach ($logs as $log) { ?>
            <div class="col-md-12 content <?php echo $log["class"]; ?>">
                <div class="col-md-12">
                    <?php echo $log["message"]; ?>
                </div>
            </div>

            <?php
        }
    } ?>
</div>
<?php if (!IsAjaxRequest())
    include $_SERVER['DOCUMENT_ROOT'] . "/templates/parts/footer.php";
?>
