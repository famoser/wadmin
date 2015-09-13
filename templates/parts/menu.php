<?php
/**
 * Created by PhpStorm.
 * User: Florian Moser
 * Date: 01.07.2015
 * Time: 18:12
 */ ?>

<div class="primary-menu clearfix">
    <div class="primary-menu-items">
        <ul class="tiles">
            <li <?php echo GetClassesForMenuItem($this, array("persons")); ?>>
                <a href="persons/">
                    <span class="flaticon-profile29" aria-hidden="true"></span>Users
                </a>
            </li>
            <li <?php echo GetClassesForMenuItem($this, array("export")); ?>>
                <a href="export/">
                    <span class="flaticon-download181" aria-hidden="true"></span>Export
                </a>
            </li>
            <li <?php echo GetClassesForMenuItem($this, array("import")); ?>>
                <a href="import/">
                    <span class="flaticon-outbox4" aria-hidden="true"></span>Import
                </a>
            </li>
            <li <?php echo GetClassesForMenuItem($this, array("settings")); ?>>
                <a href="settings/">
                    <span class="flaticon-screwdriver26" aria-hidden="true"></span>Einstellungen
                </a>
            </li>
        </ul>
    </div>

    <div class="secondary-menu-items">
        <ul class="tiles">
            <li>
                <a class="tile floatright" href="logout">
                    <span class="flaticon-cancel22" aria-hidden="true"></span>Logout
                </a>
            </li>
        </ul>
    </div>
</div>

<?php if ($this->submenu != null) {
    ?>
    <div class="submenu-items">
        <ul class="oneline-nav">
            <?php
            foreach ($this->submenu as $menuitem) {
                echo '<li ' . GetClassesForMenuItem($this, array($this->params[0], $menuitem["href"])) . '>
                            <a href="' . $this->controller . "/" . $menuitem["href"] . '">' . $menuitem["content"] . '</a>
                      </li>';
            }
            ?>
        </ul>
    </div>
<?php } ?>
