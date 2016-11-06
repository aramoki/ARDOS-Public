<?php

class desktop {

    function draw_desktop($icons) {
        $UI = new UI_manager();
        ?>

        <ul class='contextmenu iconmenu'>
            <li data-action="open_folder" >Open</li>
        </ul>

        <ul class='contextmenu desktopmenu'>
            <li data-action="first" >Open</li>
            <li data-action="second">Desktop</li>
        </ul>

        <div class="desktop" style="z-index: 0;">
            <?= $UI->draw_icons($icons); ?>    
        </div>
        <script>
            feature_draggable();
        </script>

        <!---    <li data-action="open" class="startmenu" onclick="openstartmenu(event);">Start</li>
           --->
        <div class="tasks">
            <li data-action="open" class="showhidetasks" onclick="showhidetasks(event)">
                <img src="lib/tasks.png"><p class="info">Hide / Show Tasks</p>
            </li>

            <div class="taskscontainer">
            </div>
        </div>

        <div class="loading" style="z-index: 1000;">
            <img src="lib/loading.gif">
            <!---<p class="progress">&nbsp;</p>-->
        </div>

        <div class="ardosinfo" style="z-index: 1000;">
            <img src="lib/emotes/rise.gif">
            ardos is rising!<br>
            Will be available to download in <a href="https://github.com/aramoki/ardos">Github</a> and here after first stable version launches.<br>
            <img src="lib/emotes/1.gif"><img src="lib/emotes/2.gif"><img src="lib/emotes/3.gif"><br>
            donations really helps <a href="#donate" class="button" onclick="open_window(event, 'donate', 'apps/donate')"><img src="lib/emotes/ex.gif"> &nbsp;Donate &nbsp;&nbsp;</a>
        </div>

        <div class="user">
            <img src="lib/drawer.png" onclick="sliderusermenu(event)">
        </div>

        <div class="usermenu">
            <ul>
                <li><a href="#">Contributions</a></li>
                <li><a href="#">User Profile</a></li>
                <li><a href="#">Preferences</a></li>
                <li><a href="#">logout</a></li>
            </ul>
        </div>


        <div class="footer">
            ardos v1.3.00 BETA still beta :(<br>
            aramok.net &copy; 2007 - 2016<br>
            <?= ABSPATH . '::' . ABSDIR; ?>
        </div>

        <?php
    }

}
