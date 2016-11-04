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
                dataObject["username"] = $("#username<?= $this->window_id ?>").val();
                dataObject["password"] = $("#password<?= $this->window_id ?>").val();
                $.ajax({
                    url: "<?= $jsdir ?>/login.php",
                    type: "post",
                    data: dataObject,
                    success: function (data, status) {
                        $("#connection_result<?= $this->window_id ?>").html(data);
                    }}); // end ajax call
            }
        </script>
        <?php
    }

    public function draw_application_content() {
        ?><div class="loginbox"><?php
        include $_SERVER["DOCUMENT_ROOT"].'/aramoknet/apps/system/database/database.php';
        $db = new mysql_connector();
        
        ?>
        
            <span><p>&nbsp;</p>Enter Password for login</span>
            <span><p>Username:</p><input id="username<?= $this->window_id ?>" type="text" class="input"></span>
            <span><p>Password:</p><input id="password<?= $this->window_id ?>" type="password" class="input"></span>
            
            <span><p>&nbsp;</p><a onclick="login<?= $this->window_id ?>(event);" href="#" class="button"> Login </a></span>
            <div id="connection_result<?= $this->window_id ?>"> </div>
        </div>
        <?php
        //include __DIR__.'/../database/database.php';
        
    }

    public function draw_application_toolbar() {
        
    }

}
