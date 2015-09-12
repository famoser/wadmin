<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 04.09.2015
 * Time: 01:58
 */
?>
<?php $logs = GetLog();
if ($logs != null) {
    foreach ($logs as $log) { ?>
        <div class="col-md-12 content <?php echo $log["class"]; ?>">
            <div class="col-md-11">
                <?php echo $log["message"]; ?>
            </div>
            <div class="col-md-1">
                <button class="close removebutton" data-remove-parent="2">×</button>
            </div>
        </div>

    <?php
    }
} ?>