<?php

class Rcode extends application {

    const application_name = 'Rcode';
    const author = 'aramok';
    const version = '1.0';
    const info = "Application Designer for ardos";
    const width = 950;
    const height = 600;

    function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_default';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = 'r' . '.png';
        $this->window_id = $window_id;
        $this->file = $file;
        $this->resize = parent::RESIZE_NONE;
    }

    public function application_css() {
        ?>
        <style>
            div.Rlayout{
                width:100%;
                height:100%;
                box-sizing: border-box;
            }
            div.Rlayout .cell{vertical-align: top;            }
            div.Rleft{
                width:200px;
                border-right:1px solid #ccc;
                font-size:12px;
                overflow-y: hidden;

            }
            div.Rleft div.helper{
                height:<?= self::height ?>px;
                overflow-y: scroll;
                display:block;
                box-sizing: border-box;
                padding:0px 3px;
            }

            div.Rleft ul{
                border:1px solid #bbb;
                padding:0px;
                margin:0px;
                background-color:#eee;
            }
            div.Rleft ul li{
                padding:0px;
                margin:0px;
                list-style-type:none;
                padding:3px 6px;
                font-size:12px;

            }
            div.Rleft ul li:nth-child(odd){
                background-color:#ddd;
            }
            div.Rleft ul li:active{
                color:#4587ed;
            }
            div.Rleft ul li p#b{
                display:inline;
                color:blue;
            }
            div.Rleft ul li p#g{
                display:inline;
                color:green;
            }
            div.Rleft ul li p#p{
                display:inline;
                color:purple;
            }
            div.Rleft ul li small{
                color:#666;
                display:inline-block;
            }


            div.Rtext{
            }

            textarea.codetext{
                box-sizing: border-box;
                width:100%;
                height:100%;
                padding:0px;
                margin:0px;
                font-size:14px;
                padding:10px;
                outline:none;
            }
            #editor { 
                width:100%;
                height:100%;
                box-sizing: border-box;
            }
        </style>
        <?php
    }

    public function application_javascript() {
        ?>
        <script src="lib/ace/ace.js" type="text/javascript" charset="utf-8"></script>
        <script>
            var editor = ace.edit("editor");
            editor.setTheme("ace/theme/xcode");
            editor.getSession().setMode("ace/mode/php");
        </script>
        </body>
        </html>
        <?php
    }

    public function draw_application_content() {
        ?>
        <div class="table Rlayout">
            <div class="row">
                <div class="cell altop Rleft">
                    <div class="helper">
                        <ul>
                            <li><p id="g">parent</p>::RESIZE_X<br>
                                <small>resizing constant 'vertical'</small>
                            </li>
                            <li><p id="g">parent</p>::RESIZE_Y
                                <small>resizing constant 'horizontal'</small>
                            </li>
                            <li><p id="g">parent</p>::RESIZE_FULL
                                <small>resizing constant 'both'</small>
                            </li>
                            <li><p id="g">parent</p>::RESIZE_NONE
                                <small>resizing constant 'none'</small>
                            </li>
                            <li><p id="g">self</p>::application_name
                                <small>application name constant used to set ${...}->name</small>
                            </li>
                            <li><p id="g">self</p>::author
                                <small>author name constant displayed at application info box</small>
                            </li>
                            <li><p id="g">self</p>::version
                                <small>version constant displayed at application info box.dont forget to update it.</small>
                            </li>
                            <li><p id="g">self</p>::info
                                <small> info text displayed in application info box</small>
                            </li>
                            <li><p id="g">self</p>::width
                                <small>window width integer constant as pixel</small>
                            </li>
                            <li><p id="g">self</p>::height
                                <small>window height integer constant as pixel</small>
                            </li>
                            <li><p id="b">public</p> $window_id
                                <small>application window unique id for actions</small>
                            </li>
                            <li><p id="b">public</p> $name
                                <small>application name set it using constant</small>
                            </li>
                            <li><p id="b">public</p> $icon
                                <small>application icon , string</small>
                            </li> 
                            <li><p id="b">public</p> $path
                                <small>application execute path</small>
                            </li>
                            <li><p id="b">public</p> $file
                                <small>send file to application </small>
                            </li>
                            <li><p id="b">public</p> $window_width
                                <small>window width set it with constant default</small>
                            </li>
                            <li><p id="b">public</p> $window_height
                                <small>window height set it with constant default</small>
                            </li>
                            <li><p id="b">public</p> $layout_type
                                <small>layouts ='layout_default' , 'layout_white' , 'layout_black' </small>
                            </li>
                            <li><p id="b">public</p> $resize
                                <small>resize property can be setted by parent constants 'RESIZE_X' , 'RESIZE_Y' , 'RESIZE_FULL' , 'RESIZE_NONE'</small>
                            </li>
                            <li><p id="p">__construct($af, $id, $f)()</p>
                                <small>Application constructor <br>$af = application file <br>$id = window id<br>$f = sent file </small>
                            </li>
                            <li><p id="p">draw_application_content()</p>
                                <small><p id='b'>abstract</p> function need to override<br>output of this function displayed as html in application content</small>
                            </li>
                            <li><p id="p">application_css()</p>
                                <small><p id='b'>abstract</p> function need to override<br>custom css</small>
                            </li>
                            <li><p id="p">application_javascript()</p>
                                <small><p id='b'>abstract</p> function need to override<br>custom javascript</small>
                            </li>
                            <li><p id="p">draw_application_toolbar()</p>
                                <small><p id='b'>abstract</p> function need to override<br>output of this function will set application toolbar</small>
                            </li>
                            <li><p id="p">draw_application_info()</p>
                                <small><p id='b'>parent</p> function can be called for displaying application info , application miniicon in toolbar will display that box as default , can be extended to display more information</small>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="cell altop Rtext">

<div id="editor">//sample application class                     
<?=  htmlspecialchars('<?php')?>
                        
class filename extends application {

    const application_name = 'application name';
    const author = 'author';
    const version = '0.0';
    const info = "Application info";
    const width = 640;
    const height = 480;

    function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_default';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = 'r' . '.png';
        $this->window_id = $window_id;
        $this->file = $file;
        $this->resize = parent::RESIZE_X;
    }

    public function application_css() {
        
    }

    public function application_javascript() {
        
    }

    public function draw_application_content() {
        
    }

    public function draw_application_toolbar() {
        
    }

}     
                    </div>
                </div>

            </div>
        </div>
        <?php
    }

    public function draw_application_toolbar() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        ?>
        <div class="actionbuttons" >
             <a href="#" onclick="">
                Application icon
            </a>
            <a href="#" onclick="">
                Download zip
            </a>
            <a href="#" onclick="">
                Run
            </a>
           
        </div>
        <?php
    }

}
