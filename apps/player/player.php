<?php

class player extends application {

    const application_name = 'Media Player';
    const author = 'aramok';
    const version = '1.0';
    const info = "";
    const width = 400;
    const height = 80;

    private $filetype;

    function __construct($app_file_name, $window_id, $file) {
        
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = $app_file_name . '.png';
        $this->window_id = $window_id;
        $this->file = $file;
        $this->filetype = end(explode('.', basename($this->file)));
        
        if ($this->filetype == 'mp4') {
            
        $this->layout_type = 'layout_black';
            $this->window_width = 1280 / 2;
            $this->window_height = 720 / 2;
        }else{
            
        $this->layout_type = 'layout_black';
            $this->window_width = self::width;
            $this->window_height = self::height;
        }
        
    }

    public function application_css() {
        ?>
        <style>
            div.time{
                text-align:right;
                width:40px;
            }
            div.layout{
                vertical-align:middle;
                padding:5px;
                border-bottom:1px solid #ccc;
                border-top:1px solid #eee;
                box-shadow:0px 1px 0px #eee , 0px -1px 0px #ccc;
            }
            div.slider{
                width:100%;
                position:relative;
                background-color:#eee;
                border-radius:2px;
                border:1px solid #666;
                height:12px;
                box-sizing: border-box;
            }
            div.slider p.slide<?=$this->window_id?>{
                box-shadow:inset 0px -2px 3px #2a81b4, inset 0px 1px 2px #6aa8cb;
                position:absolute;
                height:10px;
                top:0px;
                left:0px;
                background-color:#4587ed;
                border-radius:0px;
                border-right:1px solid #666;
            }
            div.controls{
                text-align: center;
            }
            a.control img{
                -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
                filter: grayscale(100%);
            }
            a.control:hover img{
                -webkit-filter: grayscale(0%); /* Safari 6.0 - 9.0 */
                filter: grayscale(0%);
            }
            
            .video-js{
                margin:0px;
                padding:0px;
                box-sizing: border-box;
                width:100%;
                height:100%;
            }
        </style>
        <?php
    }

    public function application_javascript() {
        $music_file = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->file);
        $img_path = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        if ($this->filetype == 'mp4') {
            ?>
        <link href="http://vjs.zencdn.net/5.8.8/video-js.css" rel="stylesheet">
        <script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
        <?php
        }else{
        ?>
        <script>
            $(document).ready(function () {
                event.preventDefault();

                var audioElement = document.createElement("audio");
                audioElement.setAttribute("src", "<?= $music_file ?>");
                //audioElement.setAttribute("autoplay", "autoplay");

                audioElement.load();//basa aliyor
                $.get();

                var duration;
                audioElement.addEventListener("loadedmetadata", function (_event) {
                    duration = audioElement.duration;
                    var seeking = audioElement.progress;
                    $(".time").html(Math.round(duration / 60) + ":" + Math.round(duration % 60));
                });

                $(".stop<?=$this->window_id?>").click(function () {
                    audioElement.load();
                    $(".play<?=$this->window_id?>").attr("id", "0");
                    $(".play<?=$this->window_id?>").html("<img src=\'<?= $img_path ?>/img/play.png\'>");
                });



                $(".play<?=$this->window_id?>").click(function () {
                    if ($(this).attr("id") === "0") {
                        $(this).attr("id", "1");
                        $(this).html("<img src=\'<?= $img_path ?>/img/pause.png\'>");
                        audioElement.play();
                    } else {
                        $(this).attr("id", "0");
                        $(this).html("<img src=\'<?= $img_path ?>/img/play.png\'>");
                        audioElement.pause();
                    }
                });

                function live_slider() {
                    $(".slide<?=$this->window_id?>").css("width", Math.round((100 * audioElement.currentTime / duration)) + "%");
                    setTimeout(live_slider, 1000);
                }
                live_slider();

            });
        </script>
        <?php
        }
    }

    public function draw_application_content() {

        $music_file = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->file);
        $img_path = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        if ($this->filetype == 'mp4' || true) {
            ?>

            <video id="my-video" class="video-js" controls preload="auto" width="640" height="264" poster="MY_VIDEO_POSTER.jpg" data-setup="{}">
                <source src="<?= $music_file ?>" type='video/mp4'>
                <source src="<?= $music_file ?>" type='video/webm'>
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a web browser that
                    <a href="http://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                </p>
            </video>

            <script src="http://vjs.zencdn.net/5.8.8/video.js"></script>

            <?php
        } else {
            ?>
            <div class="layout audioinfo">

            </div>
            <div class="layout">
                <marquee><?= $music_file ?></marquee>
            </div>
            <div class="layout">
                <div class="slider">
                    <p class="slide<?=$this->window_id?>" ></p>
                </div>
            </div>


            <div class="layout controls">
                <a class="control stop<?=$this->window_id?>">
                    <img src="<?= $img_path ?>/img/stop.png">
                </a>
                <a class="control play<?=$this->window_id?>" id="0">
                    <img src="<?= $img_path ?>/img/play.png">
                </a>
            </div>
            <?php
        }
    }

    public function draw_application_toolbar() {
    }

}
