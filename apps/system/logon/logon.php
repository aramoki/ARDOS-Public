<?php

class logon extends application {

    const application_name = 'Login System';
    const author = 'aramok';
    const version = '1.0';
    const width = 440;
    const height = 220;

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
        ?>
        <style>
            div.loginbox{
                padding:10px;
            }
            div.loginbox span{
                display:block;
                padding:3px;
            }
            div.loginbox span p{
                display:inline-block;
                width:100px;
                text-align:right;
                padding:0px 10px;
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
                            close_window(event,<?=$this->window_id?>);
                        }else{
                            //$("li.userloginindicator").remove();
                            alert('error loggging in');
                        }
                    }}); // end ajax call
            }
            function logout<?= $this->window_id ?>(event) {
                event.preventDefault();
                eraseCookie('username');
                close_window(event,<?=$this->window_id?>);
            }
        </script>
        <?php
    }

    public function draw_application_content() {
        $username_cookie = filter_input(INPUT_COOKIE, "username", FILTER_DEFAULT);
        ?><div class="loginbox"><?php
        if (isset($username_cookie)) {
            ?>
                Your are allready logged in!<br>
                <span><p>&nbsp;</p><a onclick="logout<?= $this->window_id ?>(event);" href="#" class="button"> Logout </a></span>   
                <?php
            } else {
                ?>

                <span><p>&nbsp;</p>Enter Password for login</span>
                <span><p>Username:</p><input id="aramok-username<?= $this->window_id ?>" type="text" class="input"></span>
                <span><p>Password:</p><input id="aramok-password<?= $this->window_id ?>" type="password" class="input"></span>

                <span><p>&nbsp;</p><a onclick="login<?= $this->window_id ?>(event);" href="#" class="button"> Login </a></span>
                <div id="connection_result<?= $this->window_id ?>"> </div>
                <?php
            }
            ?>
        </div>
        <?php
        //include __DIR__.'/../database/database.php';
    }

    public function draw_application_toolbar() {
        
    }

}
