<?php

class officeviewer extends application {

    const application_name = 'Office';
    const author = 'aramok';
    const version = '1.0';
    const width = 900;
    const height = 600;

    function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_default';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = $app_file_name . '.png';
        $this->window_id = $window_id;
        $this->file = $file;
        $this->resize = parent::RESIZE_FULL;
    }

    public function application_css() {
        ?>
        <style>
            div.content-office{
                width:100%;
                height:100%;
            }
            div.content-office iframe{
                width:100%;
                height:100%;
                resize:none;
            }
        </style>
        <?php
    }

    public function application_javascript() {
        
    }

    public function draw_application_content() {
        $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->file);
        ?>
        <div class="content-office">
            <iframe src="http://docs.google.com/viewer?url=http://aramok.net<?= $imgdir ?>&embedded=true">
                Loading
            </iframe>
        </object>
        <?php
    }

    public function draw_application_toolbar() {
        
    }

}
