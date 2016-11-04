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

        <!---
        <div class="tasks">
            <li data-action="open" class="startmenu" onclick="openstartmenu(event);"><img src="lib/win.gif"> Start</li>
        </div>
        <div class="startmenubox">
            <li >Programs</li>
            <li >Etc...</li>
            <li >Shutdown</li>
        </div>
        --->

        <div class="footer">
            ardos v1.2.2610 BETA<br>
            aramok.net &copy; 2007 - 2016<br>
            <?=ABSPATH.'::'.ABSDIR;?>
        </div>

        <?php
    }

}
