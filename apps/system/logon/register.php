<?php

class register extends application {

    const application_name = 'Register System';
    const author = 'aramok';
    const version = '1.0';
    const width = 400;
    const height = 410;
    const info = '';

    public function __construct($app_file_name, $window_id, $file) {
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
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        ?>
        <style>
            div.regsub{
                padding:10px 10px;
                background-color:#f2f0f3;  
                border-radius: 5px;
                margin:10px;
            }
            div.regsub span{
                display:block;
                padding:5px 5px;
            }
            div.regsub span p{
                display:inline-block;
                width:100px;
                text-align:right;
                padding:10px 10px;
            }
            div.regsub span p img{
                vertical-align: top;
            }
            div.regsub span a.lls{
                text-decoration:none;
                color:#4587ed;
            }
            div.regsub span a.lls:hover{
                color:orangered;
            }

            div.regtab{
                display:none;
            }

            div.tabs{
                padding:0px 5px;
            }
            div.tabs li.selected{
                background-color:#dfdfdf;
            }
            div.tabs li{
                display:inline-block;
                list-style-type: none;
                padding:5px 8px;
            }
            div.tabs li:hover{cursor:pointer;}
        </style>
        <?php
    }

    public function application_javascript() {
        $jsdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        ?>
        <script>
            function register<?= $this->window_id ?>(form) {
                $.ajax({
                    url: '<?= $jsdir ?>/registeruser.php',
                    type: 'post',
                    data: $('.'+form).serialize(),
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
                        switch (data) {
                            case '0':
                                $('._register').hide();
                                $('#_register').removeClass('selected');
                                $('._activation').show();
                                $('#_activation').addClass('selected');
                                break;
                            case '1'://aggrement
                                open_app(event, 'apps/system/dialog', 9);
                                break;
                            case '2'://user exist
                                open_app(event, 'apps/system/dialog', 8);
                                break;
                            case '3'://sql query error
                                open_app(event, 'apps/system/dialog', 6);
                                break;
                            case '4'://fields are empty
                                open_app(event, 'apps/system/dialog', 7);
                                break;
                        }
                    },
                    error: function (xhr, desc, err) {
                        alert("Details: " + desc + "\nError:" + err + "--" + xhr);

                    }
                }); // end ajax call

            }
            
            function activate<?= $this->window_id ?>(form) {
                $('._activation').hide();
                $('#_activation').removeClass('selected');
                $('._done').show();
                $('#_done').addClass('selected');
                
            }
            $('._register').show();
        </script>
        <?php
    }

    public function draw_application_content() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        ?>
        <div class="regtab _register">
            <div class="regsub">
                <form class="register<?= $this->window_id ?>" method="post">
                    <span>
                        <p>&nbsp;<img src="<?= $imagedir ?>/key.png"></p>
                        <label><b>Register new user</b></label>
                    </span>
                    <span>
                        <p>Username:</p>
                        <input name="username" type="text" class="input" >
                    </span>
                    <span>
                        <p>Email:</p>
                        <input name="email" type="text" class="input" >
                    </span>
                    <span>
                        <p>Password:</p>
                        <input name="password" type="password" class="input" >
                    </span>
                    <span>
                        <p>Password:</p>
                        <input name="password2" type="password" class="input" >
                    </span>
                    <span>
                        <p>&nbsp;</p>
                        <label><input name="aggrement" type="checkbox">Accept <a class="lls" href="#">user aggrement</a></label>
                    </span>
                    <span class=""><p>&nbsp;</p>
                        <a  href="#" class="button" onclick="register<?= $this->window_id ?>('register<?= $this->window_id ?>')"> Register </a>
                    </span>
                </form>
            </div>
        </div>
        <div class="regtab _activation">
            <div class="regsub">
                <form class="register<?= $this->window_id ?>" method="post">
                    
                    <span>
                        <p>Activation key:</p>
                        <input name="activation" type="text" class="input" >
                    </span>
                    <span class=""><p>&nbsp;</p>
                        <a  href="#" class="button" onclick="activate<?= $this->window_id ?>('register<?= $this->window_id ?>')"> Avtivate</a>
                    </span>
                </form>
            </div>
        </div>
        <div class="regtab _done">
            <div class="regsub">
                <form class="register<?= $this->window_id ?>" method="post">
                    
                    <span>
                        Congratulations<br>You registered <br> you can now login system with your username and password
                    </span>
                    <span class=""><p>&nbsp;</p>
                        <a  href="#" class="button" onclick="close_window(event,<?= $this->window_id ?>)"> Close</a>
                    </span>
                </form>
            </div>
        </div>
        <?php
    }

    public function draw_application_toolbar() {
        ?>
        <div class="tabs">
            <li class="selected" id="_register">Register</li>
            <li id="_activation">Activation</li>
            <li id="_done">Done</li>
        </div>

        <?php
    }

}
