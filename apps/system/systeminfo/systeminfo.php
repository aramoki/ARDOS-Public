<?php

class systeminfo extends application {

    const application_name = 'System Info';
    const author = 'aramok';
    const version = '1.0';
    const info = "";
    
    const width = 540;
    const height = 370;

    function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_default';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = $app_file_name . '.png';
        $this->window_id = $window_id;
        $this->file = $file;
    }

    function get_name() {
        return parent::$name;
    }

    public function application_css() {
        ?>
        <style>
            div.systeminfo-cell{
                padding:20px;
            }
            div.systeminfo-cell:nth-child(odd){
                border-right:1px solid #ccc;
            }
            div.systeminfo-cell:nth-child(even){
                border-left:1px solid #eee;
            }
        </style>
        <?php
    }

    public function application_javascript() {
        
    }

    public function draw_application_content() {
         $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        ?>
        <div class="table">
            <div class="row">
                <div class="cell systeminfo-cell"><img src="<?=$imgdir?>/computer.png"></div>
                <div class="cell systeminfo-cell">
                    <b>Host:</b><br>
                    <?= $_SERVER['HTTP_HOST'] ?>
                    <br><?= $_SERVER['DOCUMENT_ROOT'] ?><br><br>
                    <b>Browser:</b><br>
                    <?= $_SERVER['HTTP_USER_AGENT'] ?><br><br>
                    <b>Server Software:</b><br>
                    <?= $_SERVER['SERVER_SOFTWARE'] ?><br><br>
                    <b>IP Address:</b><br>
                    <?= $_SERVER['REMOTE_ADDR'] ?><br><br>
                    <span class="alright">
                        <a class="button" href="#" onclick="close_window(event,<?= $this->window_id ?>)"> Close </a>
                    </span>

                </div>
            </div>
        </div>
        <?php
    }

    public function draw_application_toolbar() {
        
    }

}
