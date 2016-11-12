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

    function __construct($error, $window_id, $ext_error = null) {
        $this->layout_type = 'layout_default';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->window_id = $window_id;
        $this->resize = parent::RESIZE_NONE;

        if ($ext_error != null) {
            $error = $ext_error;
        }

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
            case 4:
                $this->icon = 'warning.png';
                $this->image = 'key.png';
                $this->error_type = 'Restricted:';
                $this->error_message .= 'User Not Authorized<br>';
                $this->error_message .= 'use <a href="#" onclick="open_app(event,\'apps/system/logon\')" >logon application</a> to login system' . '<br>';
                break;
            case 5:
                $this->icon = 'warning.png';
                $this->image = 'user.png';
                $this->error_type = 'User not found:';
                $this->error_message .= 'Given informations are not match<br>';
                break;
            case 6:
                $this->icon = 'error.png';
                $this->image = 'fatal.png';
                $this->error_type = 'Error:';
                $this->error_message .= 'sql query error<br>';
                break;
            case 7:
                $this->icon = 'warning.png';
                $this->image = 'user.png';
                $this->error_type = 'Fields are not proper:';
                $this->error_message .= 'please fill the blanks properly<br>';
                break;
            case 8:
                $this->icon = 'warning.png';
                $this->image = 'user.png';
                $this->error_type = 'User exist';
                $this->error_message .= 'username or mail address allready registered<br>';
                break;
            case 9:
                $this->icon = 'warning.png';
                $this->image = 'user.png';
                $this->error_type = 'User Aggrement';
                $this->error_message .= 'you must accept user aggrement to register<br>';
                break;
            
            case 100:
                $ref = htmlspecialchars($_SERVER['HTTP_REFERER']);
                $this->icon = 'warning.png';
                $this->image = 'link.png';
                $this->error_type = 'Error: hotlink protection';
                $this->error_message .= 'Hotlink is not enabled you can visit <a href="http://aramok.net">Main page</a> and seek for the file you looking for';
                break;

            case 404:
                $ref = htmlspecialchars($_SERVER['HTTP_REFERER']);
                $this->icon = 'warning.png';
                $this->image = '404.png';
                $this->error_type = 'Error: Page not found';
                $this->error_message .= '"' . $ref . '"<br><br>';
                $this->error_message .= 'You can visit the <a href="http://aramok.net">Main page</a> or you can get <a target="_blank" href="https://www.wikipedia.org/wiki/HTTP_404">more information</a> about this error';
                break;


            default:
                $this->icon = 'dialogdialogbox.png';
                $this->image = 'icon.png';
                $this->error_type = 'info:';
                $this->error_message = "hello";
                break;
        }
    }

    public function application_css() {
        
    }

    public function application_javascript() {
        ?>
        <script>
            
            /*$(document).ready(function () {
                var audio = new Audio("lib/sounds/error.mp3");
                audio.play();
            });*/

        </script>
        <?php
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
                    &nbsp
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
