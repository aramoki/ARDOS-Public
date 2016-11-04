<?php

class player extends application {

    const application_name = 'Media Player';
    const author = 'aramok';
    const version = '1.0';
    const width = 400;
    const height = 370;

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
                height:10px;
            }
            div.slider p.slide{
                position:absolute;
                height:10px;
                top:0px;
                left:0px;
                background-color:#4587ed;
                border-radius:0px;
                border-right:1px solid #666;
            }
        </style>
        <?php
    }

    public function application_javascript() {
        $music_file = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->file);
        $img_path = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
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

                $(".stop").click(function () {
                    audioElement.load();
                    $(".play").attr("id", "0");
                    $(".play").html("<img src=\'<?= $img_path ?>/play.png\'>");
                });

                $(".play").click(function () {
                    if ($(this).attr("id") == "0") {
                        $(this).attr("id", "1");
                        $(this).html("<img src=\'<?= $img_path ?>/pause.png\'>");
                        audioElement.play();
                    } else {
                        $(this).attr("id", "0");
                        $(this).html("<img src=\'<?= $img_path ?>/play.png\'>");
                        audioElement.pause();
                    }
                });

                function live_slider() {
                    $(".slide").css("width", Math.round((100 * audioElement.currentTime / duration)) + "%");
                    setTimeout(live_slider, 1000);
                }
                live_slider();

            });
        </script>
        <?php
    }

    public function draw_application_content() {

        $music_file = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->file);
        $img_path = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        ?>
        <img id="visual" src="<?= $img_path ?>/visual.png">

        <div class="layout">
            <marquee><?=$music_file?></marquee>
        </div>
        <div class="layout">
            <div class="slider">
                <p class="slide"></p>
            </div>
        </div>
        <div class="layout">
            <a class="button stop">
                <img src="<?= $img_path ?>/stop.png">
            </a>
            <a class="button play" id="0">
                <img src="<?= $img_path ?>/play.png">
            </a>
        </div>
        <?php
    }

    public function draw_application_toolbar() {
        
    }

}
