<?php

class carbon extends application {

    const application_name = 'Carbon Browser';
    const author = 'aramok';
    const version = '1.1';
    const width = 840;
    const height = 580;

    function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_white';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = $app_file_name . '.png';
        $this->window_id = $window_id;
        $this->file = $file;
    }

    public function application_css() {
        ?>
<style>
    iframe.carbon_content{
        width:100%;
        height:100%;
        display:inline-block;
        border:0px;
    }
</style>
<?php
    }

    public function application_javascript() {
        ?>
        <script>
            function go_url() {
                var url = $('#carbon_url').val();
                $('.carbon_content').attr('src', url);
            }
        </script>
        <?php
    }

    public function draw_application_content() {
        $filedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->file);
        /*if (isset($this->file)) {
            $fo = fopen($this->file, "r");
            $file_content = fread($fo, filesize($this->file));
            fclose($fo);
        } else {
            $file_content = "Notepad 1.1 v1.1-class system added.";
        }*/
        
        ?>
        
        <iframe class="carbon_content" src="<?=$filedir?>" >
            loading...
        </iframe>
        <?php
    }

    public function draw_application_toolbar() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        $filedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->file);
        ?>
        <div class="table fullwidth">
            <div class="row">
                <div class="cell dirpath">
                    <input id="carbon_url" class="input_dirpath" type="text" value="<?=$filedir?>">
                </div>
                <div class="cell actionbuttons">
                    <a href="#" onclick="go_url(event)">
                        <img src="<?= $imagedir ?>/goweb.png"> Go
                    </a>
                    
                </div>
            </div>
        </div>
        <?php
    }

}
