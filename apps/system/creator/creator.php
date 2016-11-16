<?php

class creator extends application {

    const application_name = 'Creator';
    const author = 'aramok';
    const version = '1.0';
    const width = 400;
    const height = 320;
    const info = '';

    public function __construct($app_file_name, $window_id, $uploadlocation) {
        $this->layout_type = 'layout_default';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = $app_file_name . '.png';
        $this->window_id = $window_id;
        $this->file = $uploadlocation;
    }

    public function application_css() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        ?>

        <style>
            div.creator{
                padding:10px;
                box-sizing: border-box;
            }
            /* Essential FileDrop zone element configuration: */
            .fd-zone {
                position: relative;
                overflow: hidden;
                /* The following are not required but create a pretty box: */
                width: 15em;
                margin: 0 auto;
                text-align: center;
            }

            /* Hides <input type="file"> while simulating "Browse" button: */
            .fd-file {
                opacity: 0;
                font-size: 118px;
                position: absolute;
                right: 0;
                top: 0;
                z-index: 1;
                padding: 0;
                margin: 0;
                cursor: pointer;
                filter: alpha(opacity=0);
                font-family: sans-serif;
            }

            /* Provides visible feedback when user drags a file over the drop zone: */
            .fd-zone.over { border-color: maroon; background: #eee; }
        </style>
        <?php
    }

    public function application_javascript() {
        $jsdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        ?>

        <script>
            function upload(event){
                event.preventDefault();
                $.ajax({
                    url: '<?= $jsdir ?>/upload.php',
                    type: 'post',
                    data: $('.uploadform').serialize(),
                    xhr: function () {
                        var xhr = new window.XMLHttpRequest();

                        // Upload progress
                        xhr.upload.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                //Do something with upload progress
                                //console.log(percentComplete);
                                $("html").css('cursor', 'wait');
                                $(".loading").show();
                            }
                        }, false);

                        // Download progress
                        xhr.addEventListener("progress", function (evt) {
                            if (evt.lengthComputable) {
                                var percentComplete = evt.loaded / evt.total;
                                // Do something with download progress
                                //console.log(percentComplete);
                                $("html").css('cursor', 'wait');
                                $(".loading").show();
                            }
                        }, false);


                        //Done progress
                        xhr.addEventListener("load", function (evt) {
                            $("html").css('cursor', 'auto');
                            $(".loading").hide();
                        }, false);


                        return xhr;
                    },
                    success: function (data, status) {
                        alert(data);
                    },
                    error: function (xhr, desc, err) {
                        alert("Details: " + desc + "\nError:" + err + "--" + xhr);

                    }
                }); // end ajax call
            }
        </script>
        <?php
    }

    public function draw_application_content() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        $username_cookie = filter_input(INPUT_COOKIE, "username", FILTER_DEFAULT);
        if (isset($username_cookie)) {
            $this->dd_content();
        } else {
            echo 'restricted';
        }
    }

    private function dd_content() {
        ?>
        <div class="creator">
            upload path: <?= $this->file ?> , or file create path

            <form class="uploadform" method="post" action="#" enctype="multipart/form-data">
                <input type="hidden" name="path" value="<?= $this->file ?>">
                <input type="file" name="files" multiple="multiple">
                <input type="submit" onclick="upload(event);" value="upload">
            </form>
            
        </div>
        <?php
    }

    public function draw_application_toolbar() {

        $username_cookie = filter_input(INPUT_COOKIE, "username", FILTER_DEFAULT);
        if (isset($username_cookie)) {
            ?>
            <?php
        }
    }

}
