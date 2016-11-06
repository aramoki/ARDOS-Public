<?php

class pascal extends application {

    const application_name = 'Pascal';
    const author = 'aramok';
    const version = '1.2';
    const info = "see whats inside compressed things :D";
    const width = 440;
    const height = 480;

    public $UI;
    public $filereader;

    function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_white';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = $app_file_name . '.png';
        $this->window_id = $window_id;
        $this->resize = parent::RESIZE_FULL;

        //$projectdir = $_SERVER["DOCUMENT_ROOT"] . '/aramoknet/index.php';
        //filemanager-absolutepath == projectdir oluyor
        $this->UI = new UI_manager();
        $this->filereader = new FIO();
        $this->file = $file;
    }

    function draw_application_content() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        ?>
        <div class="list">
            <?php
            $zip = new ZipArchive;
            if($this->file != ''){
            if (@$zip->open($this->file) === TRUE) {
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $stat = $zip->statIndex($i);
                    $fpath = $stat['name'];
                    $dirs = split('/', $fpath);
                    $key = count($dirs) -1;
                    if($key > 1){
                        $value = $dirs[$key - 1];
                    }else{
                        $value= $dirs[0];
                    }
                    
                    if ($fpath[strlen($fpath) - 1] == '/') {
                        echo '<li style="padding-left:' . ($key * 20 + 5) . 'px">'
                        . '<img src="' . $imagedir . '/folder.png"> ' . $value . ''        
                        . '</li>';
                    } else {
                        echo '<li style="padding-left:' . ($key * 20 + 5) . 'px">'
                        . '<img src="' . $imagedir . '/file.png"> ' . end((explode('/', $stat['name'])))
                        . '&nbsp;<small>'.round($stat['size']/1024).'kbyte</small>'
                        . '</li>';
                        
                    }

                    //echo '<li>'.$zip->getNameIndex($i) . '</li>';
                }
            } else {
                echo 'Failed to open the archive!';
            }}else{
                echo 'Pascal';
            }
            ?>
        </div>
        <?php
    }

    public function application_css() {
        ?>
        <style>
            div.list{
            }
            div.list ul{
                border:1px solid red;
            }
            div.list li{
                padding:3px 6px;
                list-style-type: none;
                margin:0px;
                color:#333;
            }
            div.list li small{
                color:#666;
            }
            div.list li:nth-child(odd){
                background-color:#eee;
            }
            div.list li:nth-child(even){
                background-color:#fff;
            }
        </style>
        <?php
    }

    public function application_javascript() {
        ?>
        <script>
         
        </script>
        <?php
    }

    public function draw_application_toolbar() {
        $username = filter_input(INPUT_COOKIE, "username", FILTER_DEFAULT);
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
?>
        <div class="table fullwidth">
            <div class="row">
                <div class="cell actionbuttons" style="width:100px;">
                    <a href="#" onclick="">
                        <img src="<?=$imagedir?>/ex.png"> Extract
                    </a>
                    <a href="#" onclick="">
                        <img src="<?=$imagedir?>/addf.png"> Add File
                    </a>
                    <a href="#" onclick="">
                        Set comment
                    </a>
                    <a href="#" onclick="">
                        Set Password
                    </a>
                </div>
            </div>
        </div>
        <?php
    }

}
