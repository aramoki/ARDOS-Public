<?php

class donate extends application {

    const application_name = 'Donation';
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
            div.lay{
                width:100%;
            }
            div.lay .cell {
                padding:10px 5px;
            }

            p.btcaddress{
                background-color:#dedeef;
                border:1px inset #eef;
            }

        </style>
        <?php
    }

    public function application_javascript() {
        ?>
        <script>
            function copyToClipboard() {
                var text = $('.btcaddress').attr('addres');
                window.prompt("Copy to clipboard: Ctrl+C, Enter", text);
            }
        </script>
        <?php
    }

    public function draw_application_content() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        ?>

        <div class="lay table">
            <div class="row">
                <div class="cell alcenter altop" style="width:222px">
                    <img class="qr" src="<?= $imagedir ?>/donate.gif">
                </div>
                <div class="cell alcenter almiddle" >
                    <p class="btcaddress" addres="14kbMPfwhnv25oFfFwAsDuiEC732gRQ3hR">14kb MPfw hnv2 <br>5oFf FwAs DuiE <br>C732 gRQ3 hR</p>
                    <a href="#" class="button" onclick="copyToClipboard();">Copy</a>

                </div>
            </div>
        </div>
        <?php
    }

    public function draw_application_toolbar() {
        
    }

}
