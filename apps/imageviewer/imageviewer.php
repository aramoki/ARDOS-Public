<?php

class imageviewer extends application {

    const application_name = 'Image Viever';
    const author = 'aramok';
    const version = '1.2';
    const info = "";
    const width = 200;
    const height = 200;

    public $exifdata;

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
            
            $this->window_width = ($img_w > 1200)?1200:$img_w + 20;
            $this->window_height = ($img_h > 650)?650:$img_h + 20;

            //$this->exifdata = exif_read_data($file, 0, true);
        } else {
            $this->window_width = self::width;
            $this->window_height = self::height;
        }
    }

    public function application_css() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        ?>
        <style>
            div.imview{
                background-image: url('<?= $imagedir ?>/back.gif');
                height: 100%;
                width:100%;
                text-align: center;
                max-width:1000px;
                max-height:900px;

            }

            div.imvtop{
                vertical-align: middle;
            }

            div.imview img{
            }

            div.exifinformation{
                display:none;
                background-color:#ccc;
                border-right:1px solid #999;
                height:100%;
                width:100%;
                text-align: left;
                margin-right:10px;
            }

            div.exifinformation p{
                padding:2px 4px;
                display:block;
                font-size: 12px;
            }

            div.exifinformation p:nth-child(odd){
                background-color:#eee;
            }
        </style>
        <?php
    }

    public function application_javascript() {
        ?>
        <script>
            function toggleexifdiv(event) {
                $('.exifinformation').toggle();
            }
        </script>
        <?php
    }

    public function draw_application_content() {
        $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->file);
        ?>
        <div class="imview table" >
            <div class="row">
                <div class="cell exifinformation" style="width:300px;">

                    <?php
                    /*
                    if (is_array($this->exifdata)) {
                        foreach ($this->exifdata as $key => $section) {
                            foreach ($section as $name => $val) {
                                echo '<p>' . $key . $name . ' : ' . $val . '</p>';
                            }
                        }
                    }
                     * 
                     */
                    ?>
                </div>
                <div class="cell imvtop">
                    <img src="<?= $imgdir ?>">
                </div>

            </div>

        </div>


        <?php
    }

    public function draw_application_toolbar() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        ?>
        <div class="actionbuttons">
            <a href="#" onclick="toggleexifdiv(event)">
                <img src="<?= $imagedir ?>/exif.png"> Show Informations
            </a>
        </div>
        <?php
    }

}
