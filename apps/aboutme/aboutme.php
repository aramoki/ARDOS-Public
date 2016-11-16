<?php
class aboutme extends application {

    const application_name = 'About me';
    const author = 'aramok';
    const version = '1.0';
    const info = "";
    
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
                width:100%;
                padding:10px;
                box-sizing: border-box;
            }
            div.content div.cell {
                padding:10px;
                vertical-align:top;
            }
            div.content div.roundpict{
                width:150px;
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


        <div class="table pad">
            <div class="row">
                <div class="cell roundpict"  style="border-right:1px solid #ccc;">
                    <img  src="<?=$imagedir?>/S.gif">
                </div>
                <div class="cell" style="text-align: left;border-left:1px solid #eee;">
                    <h2>Aramok</h2> <br>
                    Electronics Engineer<br>
                    <small>nrec@aramok.net</small>
                    <hr>
                    <!---<b>Education:</b><br>
                    Graduated from Marmara University<br>
                    <small>Continue master degree...</small><br>
                    <br>-->
                    <b>Additional Projects:</b><br>
                    ardos... <small> always wanted to have something simple like this </small><br>
                    Unique kernel... <small> just a little step after B-loader </small><br>
                    GL Works <small>Funn part of mathmatic ^_^</small><br>
                    8 to 16 <small>cute sisc to risc , much more fun</small><br>
                    Mitma <small>Canvas of davinci</small><br>
                    esurrive<small> well , consider this one is a pixel art</small>
                    <br><br><b>Hobbies:</b><br>
                    <small> @verilog {css} .php. +js rb *c&pp d- jaVa ;asm ./unix cas etc</small><br>
                    <small> Real brush art and  PIXEL Art</small><br>
                    <small> Pink Head Night Elf Death Knight , pushing ladder since 2007</small><br>
                    <br><hr>
                    <a href="https://github.com/aramoki" target="_blank" class="button" ><img src="<?=$imagedir?>/git.png"> GitHub</a><br>
                </div>
            </div>
        </div>

        <?php
    }

    public function draw_application_toolbar() {
        echo $this->file;
    }

}
