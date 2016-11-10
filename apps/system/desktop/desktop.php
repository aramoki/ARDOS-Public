<?php

class desktop {
    private $theme;
    public function __construct($theme) {
        $this->theme = $theme;
        $this->theme->set_theme();
    }
    
    function draw_desktop($icons) {
        global $theme;
        $UI = new UI_manager();
        $username = filter_input(INPUT_COOKIE, "username", FILTER_DEFAULT);
        ?>

        <ul class='contextmenu iconmenu'>
            <li data-action="open_folder" >Open</li>
        </ul>

        <ul class='contextmenu desktopmenu'>
            <li data-action="first" >Open</li>
            <li data-action="second">Desktop</li>
        </ul>

        <div class="desktop" style="z-index: 0;">
            <?= $UI->draw_icons($icons,$theme); ?>
        </div>
        <script>
            feature_draggable();
        </script>

        <!---    <li data-action="open" class="startmenu" onclick="openstartmenu(event);">Start</li>
           --->
        <div class="tasks">
            <li data-action="open" class="showhidetasks" onclick="showhidetasks(event)">
                <img src="<?=$theme->themedir?>/images/tasks.png"><p class="info">Hide / Show Tasks</p>
            </li>

            <div class="taskscontainer">
            </div>
        </div>

        <div class="loading" style="z-index: 1000;">
            <img src="<?=$theme->themedir?>/images/loading.gif">
            <!---<p class="progress">&nbsp;</p>-->
        </div>

        <!---
        <div class="ardosinfo" style="z-index: 1000;">
            <img src="lib/emotes/rise.gif">
            ardos is rising!<br>
            Will be available to download in <a href="https://github.com/aramoki/ardos">Github</a> and here after first stable version launches.<br>
            <img src="lib/emotes/1.gif"><img src="lib/emotes/2.gif"><img src="lib/emotes/3.gif"><br>
            donations really helps <a href="#donate" class="button" onclick="open_window(event, 'donate', 'apps/donate')"><img src="lib/emotes/ex.gif"> &nbsp;Donate &nbsp;&nbsp;</a>
        </div>
        -->

        <!---<div class="user">
            <p class="avatar"><img src="lib/useravatar/aramok.png"></p>
            <img class="rotate" src="lib/drawer.png" onclick="sliderusermenu(event)">
        </div>--->

        <div class="user table">
            <div class="row">
                <div class="cell">
                    <p class="username">
                        ~<?= $username ?>
                    </p>
                    <p class="umenu">
                        <a href="#"><img src="<?=$theme->themedir?>/images/bal.png"> 12</a>
                    </p>
                </div>
                <div class="cell avatar" onclick="sliderusermenu(event)">
                    <img src="lib/useravatar/test.jpeg">
                </div>
            </div>
        </div>

        
        <div class="usermenu">
            <ul>
                <li><a href="#">Contributions</a></li>
                <li><a href="#">Messages</a></li>
                <li><a href="#">Creator</a></li>
                <li><a href="#" onclick="open_app(event,'apps/system/logon')">Logon</a></li>
            </ul>
        </div>
        


        <div class="footer">
            <?= str_replace(ABSPATH,'',$this->theme->themedir) ?><br>
            <?=print_r($_COOKIE).'--'?>
            ardos v1.3.00  beta<br>
            aramok.net &copy; 2007 - 2016<br>
            <?= ABSPATH . '::' . ABSDIR; ?>
        </div>

        <?php
    }

}
