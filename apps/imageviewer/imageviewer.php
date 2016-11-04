<?php

class imageviewer extends application {

    const application_name = 'Image Viever';
    const author = 'aramok';
    const version = '1.0';
    const width = 200;
    const height = 200;

    function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_white';
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = $app_file_name . '.png';
        $this->window_id = $window_id;
        $this->file = $file;
        $this->resize = parent::RESIZE_FULL;

        if (file_exists($file)) {
            list($img_w, $img_h) = getimagesize($file);
            $this->window_width = $img_w;
            $this->window_height = $img_h;
        } else {
            $this->window_width = self::width;
            $this->window_height = self::height;
        }
    }

    public function application_css() {
        
    }

    public function application_javascript() {
        
    }

    public function draw_application_content() {
        $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->file);
        ?>
        <div style="text-align:center;"><img src="<?= $imgdir ?>"></div>
        <?php
    }

    public function draw_application_toolbar() {
        
    }

}
