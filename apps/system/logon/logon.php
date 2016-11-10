<?php

class logon extends application {

    const application_name = 'Login System';
    const author = 'aramok';
    const version = '1.0';
    const width = 400;
    const height = 300;

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
            div.loginbox{
                padding:10px;
                height:100%;
                width:100%;
                box-sizing: border-box;
                background-image:url('<?= $imagedir ?>/red.jpg');
            }
            div.loginbox div.cell{
                vertical-align: top;
            }
            div.loginbox div.cell div.holder{
                overflow: hidden;
                padding:10px 0px;
                background-color:#ebebeb;  
                border-radius: 3px;
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
            
            div.tab{
                display:none;
            }
            div.tabs{
                padding:0px 5px;
            }
            div.tabs li.selected{
                background-color:#ebebeb;
            }
            div.tabs li{
                 
                border-radius: 3px 3px 0px 0px;
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
            function login<?= $this->window_id ?>(event) {
                event.preventDefault();
                var dataObject = {};
                dataObject["username"] = $("#aramok-username<?= $this->window_id ?>").val();
                dataObject["password"] = $("#aramok-password<?= $this->window_id ?>").val();
                dataObject["days"] = 1;
                $.ajax({
                    url: "<?= $jsdir ?>/login.php",
                    type: "post",
                    data: dataObject,
                    success: function (data, status) {
                        switch (data) {
                            case '1':
                                close_window(event,<?= $this->window_id ?>);
                                check_user_login();
                                break;
                            case '2'://user not found
                                open_app(event, 'apps/system/dialog', 5);
                                break;
                            case '3'://sql query error
                                open_app(event, 'apps/system/dialog', 6);
                                break;
                            case '4'://fields are empty
                                open_app(event, 'apps/system/dialog', 7);
                                break;
                        }
                    }}); // end ajax call
            }
            function logout<?= $this->window_id ?>(event) {
                event.preventDefault();

                eraseCookie('username').success(
                        function (data) {
                            check_user_login();
                        });

                close_window(event,<?= $this->window_id ?>);
            }
            function selecttab(e,tab){
                $('.tabs li').removeClass('selected');
                $(e.target).addClass('selected');
                $('.tab').hide();
                $('.'+tab).show();
            }
            
            $('._informations').show();
        </script>
        <?php
    }

    public function draw_application_content() {
        $username_cookie = filter_input(INPUT_COOKIE, "username", FILTER_DEFAULT);
        ?><div class="loginbox table">
            <div class="row">
                <div class="cell">
                    <?php
                    if (isset($username_cookie)) {
                        ?>
                    <div class="tabs">
                        <li onclick="selecttab(event,'_informations')" class="selected">Informations</li>
                        <li onclick="selecttab(event,'_password')" >Password</li>
                        <li onclick="selecttab(event,'_avatar')">Avatar</li>
                        <li onclick="selecttab(event,'_options')">Preferences</li>
                    </div>
                        <div class="holder">   
                            
                            <div class="tab _informations">
                                <span>
                                    <p>username:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span>
                                    <p>Name:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span class=""><p>&nbsp;</p>
                                    <a  href="#" class="button"> Update </a>
                                </span>
                            </div>
                            
                            <div class="tab _password">
                                <span>
                                    <p>Old Password:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span>
                                    <p>New Password:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span>
                                    <p>Retry:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span class="">
                                    <p>&nbsp;</p><a  href="#" class="button"> Change Password </a>
                                </span>
                            </div>

                            <div class="tab _avatar">
                                <span>
                                    <p>Avatar:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span class=""><p>&nbsp;</p>
                                    <a  href="#" class="button"> Update </a>
                                </span>
                            </div>

                            <div class="tab _options">
                                <span>
                                    <p>Options:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span class=""><p>&nbsp;</p>
                                    <a  href="#" class="button"> Update </a>
                                </span>
                            </div>

                            

                            <div class="tab _options">
                                <span class="">
                                    Your are allready logged in!
                                </span>
                                <span class=""><p>&nbsp;</p>
                                    <a onclick="logout<?= $this->window_id ?>(event);" href="#" class="button"> Logout </a>
                                </span>
                            </div>
                        </div> 
                        <?php
                    } else {
                        ?>
                        <div class="holder">
                            <span>
                                <p>Username:</p>
                                <input id="aramok-username<?= $this->window_id ?>" type="text" class="input">
                            </span>
                            <span>
                                <p>Password:</p>
                                <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                            </span>

                            <span>
                                <p>&nbsp;</p>
                                <a onclick="login<?= $this->window_id ?>(event);" href="#" class="button"> Login </a>
                            </span>
                        </div>
                                    <!---<div id="connection_result<?= $this->window_id ?>"> 
                                    
                                    </div>--->
                        <?php
                    }
                    ?>

                </div>
            </div>
        </div>
        <?php
        //include __DIR__.'/../database/database.php';
    }

    public function draw_application_toolbar() {
        
    }

}
