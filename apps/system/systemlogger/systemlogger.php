<?php

class shell extends application {

    const application_name = 'System Console';
    const author = 'aramok';
    const version = '1.0';
    const width = 540;
    const height = 370;

    function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_black';
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
            div.console{
                height:100%;
                padding:10px;
            }
            
            div.console p.info{
                color:yellow;
                padding:0px;
                margin:0px;
                display:inline;
            }
            div.console p.user{
                color:pink;
                padding:0px;
                margin:0px;
                display:inline;
            }
        </style>
        <?php
    }

    public function application_javascript() {
        
    }

    public function draw_application_content() {
         $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        ?>
        <div class="console">
<pre>
<p class="info">Login <?=$_SERVER["HTTP_HOST"]?> :<?=date('m/d/Y h:i:s a', time());?></p><br>
<?=$_SERVER["SERVER_SOFTWARE"]?><br>
<p class="user">guest<?=rand(1000,8000)?></p>[<?=$_SERVER["SERVER_ADDR"]?>]~$/ _
</pre>
        </div>
        <?php
    }

    public function draw_application_toolbar() {
        ?>
        <ul>File
            <div>
            <li> Save </li>
            <li> Print </li>
            <li> Exit </li>
            </div>
        </ul>  
        <ul>Terminal
            <div>
            <li> Help </li>
            <li> Run Commands </li>
            <li> Style Change </li>
            <li> Connect external </li>
            </div>
        </ul>
        <?php
    }

}
