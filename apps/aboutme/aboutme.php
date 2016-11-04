<?php
class aboutme extends application {

    const application_name = 'About me';
    const author = 'aramok';
    const version = '1.0';
    const width = 580;
    const height = 440;

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

    public function application_css() {
        ?>
        <style>
            div.content div.pad{
                height:100%;
                background-color:#fc0;
                padding:10px;
            }
            div.content div.cell {
                padding:10px;
                vertical-align:top;
            }
            div.content div.roundpict img{
                border-radius:5px;
            }
        </style>
        <?php
    }

    public function application_javascript() {
        
    }

    public function draw_application_content() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        ?>


        <div class="table">
            <div class="row">
                <div class="cell roundpict"  style="border-right:1px solid #ccc;">
                    <img  src="<?=$imagedir?>/S.gif">
                </div>
                <div class="cell" style="text-align: left;border-left:1px solid #eee;">
                    <h2>Sencer Aramok</h2> <br>
                    Electronics Engineer<br>
                    <small>sencer@aramok.net</small>
                    <hr>
                    <b>Education:</b><br>
                    Graduated from Marmara University<br>
                    <small>Continue master degree...</small><br>
                    <br>
                    <b>Additional Projects:</b><br>
                    This web page... <small> was a dream , to real @2007</small><br>
                    Unique kernel... <small> just a little step after B-loader </small><br>
                    <small> @verilog {css} .php. +js  *c  jaVa  ;asm  ./unix </small>
                    <br><hr>
                    <a href="#" class="button" ><img src="<?=$imagedir?>/face.png"> Facebook</a><br>
                    <a href="#" class="button" ><img src="<?=$imagedir?>/in.png"> Linkedin</a><br>
                    <a href="#" class="button" ><img src="<?=$imagedir?>/git.png"> GitHub</a><br>
                </div>
            </div>
        </div>

        <?php
    }

    public function draw_application_toolbar() {
        echo $this->file;
    }

}
