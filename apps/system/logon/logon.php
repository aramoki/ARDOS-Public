<?php

class logon extends application {

    const application_name = 'Login System';
    const author = 'aramok';
    const version = '1.0';
    const width = 400;
    const height = 300;
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
            div.loginbox div.cell div.uholder{
                overflow: hidden;
                padding:10px 0px;
                background-color:#ebebeb;  
                border-radius: 3px;
            }
            div.loginbox div.cell div.sub{
                padding:10px 0px;
                background-color:#f2f0f3;  
                border-radius: 5px;
                margin:10px 5px;
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
            div.loginbox span p img{
                vertical-align: top;
            }
            div.loginbox span a.lls{
                text-decoration:none;
                color:#4587ed;
            }
            div.loginbox span a.lls:hover{
                color:orangered;
            }

            div.tab{
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
                eraseCookie('username').success(
                        function (data) {
                            $('.user').hide('slow');
                        });

                close_window(event,<?= $this->window_id ?>);
            }
            function selecttab(e, tab) {
                $('.tabs li').removeClass('selected');
                $(e.target).addClass('selected');
                $('.tab').hide();
                $('.' + tab).show();
            }

            $('._profile').show();
        </script>
        <?php
    }

    public function draw_application_content() {
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        $username_cookie = filter_input(INPUT_COOKIE, "username", FILTER_DEFAULT);
        ?><div class="loginbox table">
            <div class="row">
                <div class="cell">
                    <?php
                    if (isset($username_cookie)) {
                        ?>






                        <div class="tab _profile">
                            <div class="sub">
                                <span>
                                    <p>Name:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span>
                                    <p>Email:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span>
                                    <p>URL:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span>
                                    <p>Location:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span>
                                    <p>Company:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span class=""><p>&nbsp;</p>
                                    <a  href="#" class="button"> Update </a>
                                </span>
                            </div>

                            <div class="sub">
                                <span>
                                    <p>Avatar:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span class=""><p>&nbsp;</p>
                                    <a  href="#" class="button"> Update </a>
                                </span>
                            </div>
                        </div>






                        <div class="tab _account">

                            <div class="sub">
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
                            <div class="sub">
                                <span>
                                    <p>Username:</p>
                                    <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                                </span>
                                <span class="">
                                    <p>&nbsp;</p><a  href="#" class="button"> Change Password </a>
                                </span>
                            </div>

                            <div class="sub">
                                <span>
                                    <p>&nbsp;</p>
                                    <label><input type="checkbox"> im sure , delete my account</label>
                                </span>
                                <span class="">
                                    <p>&nbsp;</p><a  href="#" class="button"> Delete Permanently</a>
                                </span>
                            </div>
                        </div>




                        <div class="tab _preferences">
                            <div class="sub">
                                <span>
                                    <label><input type="checkbox"> Put me out of data rest</label>
                                </span>
                                <span>
                                    <label><input type="checkbox"> Rest information need</label>
                                </span>
                                <span>
                                    <label><input type="checkbox"> i dont know what to do whit this</label>
                                </span>
                                <span>
                                    <label><input type="checkbox"> let thes hor much it can go further and we know it better</label>
                                </span>
                                <span>
                                    <label><input type="checkbox"> some little cases with <small> ittle information</small></label>
                                </span>
                                <center>
                                    <span class="">
                                        <a  href="#" class="button"> Update </a>
                                    </span>
                                </center>
                            </div>
                        </div>

                        <div class="tab _logins">

                            <div class="sub">
                                <span class=""><p>Logins:</p>
                                    You are logged in those locations
                                </span>
                                <span class=""><p>&nbsp;</p>
                                    <a onclick="logout<?= $this->window_id ?>(event);" href="#" class="button"> Logout </a>
                                </span>
                            </div>
                        </div>








                        <?php
                    } else {
                        ?>
                        <div class="uholder">
                            <span>
                                <p>&nbsp;<img src="<?= $imagedir ?>/key.png"></p>
                                <label><b>User Login</b></label>
                            </span>
                            <span>
                                <p><label>Username:</label></p>
                                <input id="aramok-username<?= $this->window_id ?>" type="text" class="input">
                            </span>
                            <span>
                                <p><label>Password:</label></p>
                                <input id="aramok-password<?= $this->window_id ?>" type="password" class="input">
                            </span>

                            <span>
                                <p>&nbsp;</p>
                                <a onclick="login<?= $this->window_id ?>(event);" href="#" class="button"> Login </a>
                                <label><input type="checkbox"> Keep me logged in</label>
                            </span>
                            <span>
                                <p>&nbsp;</p>
                                <a href="#" class="lls">Forgot password</a> | <a href="#" class="lls">Register</a>
                            </span>
                        </div>
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

        $username_cookie = filter_input(INPUT_COOKIE, "username", FILTER_DEFAULT);
        if (isset($username_cookie)) {
            ?>
            <div class="tabs">
                <li onclick="selecttab(event, '_profile')" class="selected">Profile</li>
                <li onclick="selecttab(event, '_account')" >Account</li>
                <li onclick="selecttab(event, '_preferences')">Preferences</li>
                <li onclick="selecttab(event, '_logins')">Logins</li>
            </div>

            <?php
        }
    }

}
