<?php

class ThemeManager {

    public $themename;
    public $themedir;
    public $themepath;

    public function __construct($theme = 'default') {
        $this->themename = $theme;
        $this->themepath = dirname(__FILE__). '/' . $this->themename;
        $this->themedir = str_replace(ABSPATH,'',$this->themepath);
    }

    public function set_theme() {
        ?>
        <link href="apps/system/ThemeManager/<?= $this->themename ?>/<?= $this->themename ?>.css" rel="stylesheet" type="text/css">
        <?php
    }

}
