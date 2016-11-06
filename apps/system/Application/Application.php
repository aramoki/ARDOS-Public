<?php

abstract class application {

    const RESIZE_X = 'horizontal';
    const RESIZE_Y = 'vertical';
    const RESIZE_FULL = 'both';
    const RESIZE_NONE = 'none';

    public $window_id;      //unique id for each application window
    public $name;           //application name
    public $icon;           //application icon path
    public $path;           //application run path
    public $file;           //path of sent file to application
    public $window_width;   //app width
    public $window_height;  //app height
    public $layout_type;    //app layout
    public $resize;

    abstract public function draw_application_content();

    abstract public function application_css();

    abstract public function application_javascript();

    abstract public function draw_application_toolbar();

    public function draw_application_info() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"] . ABSDIR . '/', '', $this->path);
        ?>
        <div class="infobar">
            <a href="#" style="position:absolute;top:0px;right:0px;" onclick="appinfo_window(event,<?= $this->window_id ?>)">
                <img src="lib/images/close.png">
            </a><br>
            <center>
                <img src="<?= $imagedir . '/' . '/icon.png' ?>"><br>
                <b><?= static::application_name ?></b><br>Version: <?= static::version ?><br>
                Author: <i><?= static::author ?></i><hr>

                <font color="#555"><?= static::info ?></font>
            </center>
        </div>
        <?php
    }

    /// buraya app info cizdir diye bi secenek te koy
    // ama abstract olmasin o
}
