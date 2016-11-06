<?php

class logon extends application {

    const application_name = 'Login System';
    const author = 'aramok';
    const version = '1.0';
    const width = 400;
    const height = 400;

    public function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_black';
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
            div.loginbox{
                padding:10px;
                height:100%;
                width:100%;
                box-sizing: border-box;
                background-image:url('<?= $imagedir ?>/log.gif');
            }
            div.loginbox div.cell{
                vertical-align: middle;
            }
            div.loginbox div.cell div.holder{
                border:1px solid darkgreen;
                border-radius:5px;
                color:darkkhaki;
                overflow: hidden;
                padding:10px 0px;
                background-color:rgba(0,0,0,0.5);
            }
            div.loginbox span{
                display:block;
                padding:5px 5px;
            }
            div.loginbox span p{
                display:inline-block;
                width:100px;
                text-align:right;
                padding:10px 10px;
            }
            input[type="text"].input_login, input[type="password"].input_login{
                border:1px solid green;
                background-color:rgba(52,0,49,0.5);
                padding:5px 8px;
                outline:none;
                font-size:14px;
                color:yellow;
                box-sizing: border-box;
                margin:0px;
            }
            input[type="text"].input_login:focus, input[type="password"].input_login:focus{
                border:1px solid lightcyan;
                background-color:rgba(152,100,149,0.8);
                color:lightyellow;
            }

            .button_login{
                border:1px solid green;
                background-color:rgba(52,0,49,0.6);
                padding:4px 10px;
                display:inline-block;
                width:100px;
                font-size:13px;
                color:yellow;
                text-decoration: none;
                text-align: center;
            }
            .button_login:hover{
                border:1px solid lightgreen;
                color:lightyellow;
                background-color:rgba(152,100,149,0.6);
            }

        </style>
        <?php
    }

    public function application_javascript() {
        $jsdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        ?>
        <script>
            function login<?= $this->window_id ?>(event) {
                event.preventDefault();
                var dataObject = {};
                dataObject["username"] = $("#aramok-username<?= $this->window_id ?>").val();
                dataObject["password"] = $("#aramok-password<?= $this->window_id ?>").val();
                $.ajax({
                    url: "<?= $jsdir ?>/login.php",
                    type: "post",
                    data: dataObject,
                    success: function (data, status) {
                        var result = data.split(',');
                        var loginsuccess = (result[2] === 'true');

                        if (loginsuccess) {
                            createCookie('username', result[0], 1);
                            //$(".tasks").append('<li class="userloginindicator"><img src="lib/user.gif"><p class="info">username</li>');
                            close_window(event,<?= $this->window_id ?>);
                            check_user_login();
                        } else {
                            //$("li.userloginindicator").remove();
                            alert('error loggging in');
                        }
                    }}); // end ajax call
            }
            function logout<?= $this->window_id ?>(event) {
                event.preventDefault();
                eraseCookie('username');
                check_user_login();
                close_window(event,<?= $this->window_id ?>);
            }
        </script>
        <?php
    }

    public function draw_application_content() {
        $username_cookie = filter_input(INPUT_COOKIE, "username", FILTER_DEFAULT);
        ?><div class="loginbox table">
            <div class="row">
                <div class="cell">
                    <div class="holder"><?php
                        if (isset($username_cookie)) {
                            ?>
                            <center>
                            <span class="">
                                Your are allready logged in!
                            </span>
                            <span class="">
                                <a onclick="logout<?= $this->window_id ?>(event);" href="#" class="button_login"> Logout </a>
                            </span> 
                            </center>  
                            <?php
                        } else {
                            ?>

                            <span>
                                <p>Username:</p>
                                <input id="aramok-username<?= $this->window_id ?>" type="text" class="input_login">
                            </span>
                            <span>
                                <p>Password:</p>
                                <input id="aramok-password<?= $this->window_id ?>" type="password" class="input_login">
                            </span>

                            <span>
                                <p>&nbsp;</p>
                                <a onclick="login<?= $this->window_id ?>(event);" href="#" class="button_login"> Login </a>
                            </span>
                            <!---<div id="connection_result<?= $this->window_id ?>"> 
                            
                            </div>--->
                            <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        //include __DIR__.'/../database/database.php';
    }

    public function draw_application_toolbar() {
        
    }

}
