<?php

class dialog extends application {

    const application_name = 'Dialog box';
    const author = 'aramok';
    const version = '1.3';
    const info = "i like it";
    
    const width = 340;
    const height = 190;

    public $error_message;
    public $error_type;

    function __construct($error, $window_id) {
        $this->layout_type = 'layout_default';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->window_id = $window_id ;
        $this->resize = parent::RESIZE_NONE;

        
        switch ($error) {
            case 1:
                $this->icon = 'warning.png';
                $this->image = 'app.png';
                $this->error_type = 'Warning:';
                $this->error_message = "Not allowed more than one instance";
                break;
            case 2:
                $this->icon = 'error.png';
                $this->image = 'app.png';
                $this->error_type = 'Error:';
                $this->error_message = "Class definition error!";
                break;
            case 3:
                $this->icon = 'error.png';
                $this->image = 'bug.png';
                $this->error_type = 'Bugged:';
                $errorinfo = error_get_last();
                $this->error_message .= $errorinfo['message'] . '<br>';
                $this->error_message .= $errorinfo['file'] . '<br>';
                $this->window_height += 110;
                $this->window_width += 240;
                break;


            default:
                $this->icon = 'dialogdialogbox.png';
                $this->image = 'icon.png';
                $this->error_type = 'info:';
                $this->error_message = "Dialogbox!";
                break;
        }
    }

    public function application_css() {
        
    }

    public function application_javascript() {
        
    }

    public function draw_application_content() {
        $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        ?>
<div class="table dialog_layout" >
            <div class="row" >
                <div class="cell" style="text-align: right;">
                    <img src="<?= $imgdir ?>/<?= $this->image ?>">
                </div>
                <div class="cell wrap">
                    <b><?= $this->error_type ?></b><br>
                    <?= $this->error_message ?>
                </div>
            </div>
            <div class="row">
                <div class="cell">
                    &nbsp;
                </div>
                <div class="cell">
                    <a href="#" class="button" onclick="close_window(event,<?= $this->window_id ?>);">Close</a>  

                </div>
            </div>
        </div>
        <?php
    }

    public function draw_application_toolbar() {
        
    }

}
