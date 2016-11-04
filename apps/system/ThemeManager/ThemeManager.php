<?php

class ThemeManager{
    
    public $themename;
    public function __construct($theme = 'default.css') {
        $this->themename = $theme;
    }

    public function set_theme() {
        ?>
        <link href="apps/system/ThemeManager/<?=$this->themename?>" rel="stylesheet" type="text/css">
            <?php
    }

}
