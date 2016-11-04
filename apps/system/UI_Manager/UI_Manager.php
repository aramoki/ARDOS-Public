<?php
class UI_manager {

    function __construct() {
        
    }

    public function load_app($app_path, $app_file_name, $window_id, $file) {
        if (!class_exists($app_file_name)) {
            include ABSPATH.$app_path . '/' . $app_file_name . '.php';
            if (class_exists($app_file_name)) {
                $application = new $app_file_name($app_file_name, $window_id, $file);
            } else {
                include ABSPATH.'apps/system/dialog/dialog.php';
                $application = new dialog(2,$window_id);
            }
        }else{
            include ABSPATH.'apps/system/dialog/dialog.php';
            $application = new dialog(1,$window_id);
        }
        
        return $application;
    }
    

    public function draw_icons($icons, $open_new_window = 1, $window_id = null) {
        $data = '';
        if ($icons == null) {
            return null;
        }
        foreach ($icons['name'] as $icon) {
            $full_path = $icons['path'] . '/' . $icon;
            $extension = end((explode('.', $icon)));
            $isfolder = is_dir($full_path);
            //buna bi bak
            $is_app_shortcut = ($extension == 'app');
            $is_folder_shortcut = ($extension == 'dir');

            if ($isfolder || $is_app_shortcut || $is_folder_shortcut) {
                $is_application = file_exists($full_path . '/' . $icon . '.php');
                if ($is_application || $is_app_shortcut) {
                    $exe = str_replace('-', '/', reset((explode('.', $icon))));
                    $exef = str_replace('.app', '', end((explode('-', $icon))));
                    $ext_image = (($is_app_shortcut) ? '/'.ABSDIR.'/apps/' . $exe : str_replace($_SERVER['DOCUMENT_ROOT'].'/'.ABSDIR.'/', '', $full_path)) . '/icon.png';
                    $command = 'open_window(event,\'' . $exef . '\',\'' . (($is_app_shortcut) ? 'apps/' . $exe : str_replace($_SERVER['DOCUMENT_ROOT'].'/'.ABSDIR.'/', '', $full_path)) . '\')';
                    $file_info = 'Application';
                } else {                                                                        //v---- buraya resetten null gelirse / koymuyoruz
                    $fdir = (($is_folder_shortcut) ? $_SERVER["DOCUMENT_ROOT"].'/'.ABSDIR.'/'. reset((explode('.', $icon))) : $full_path);
                    $ext_image = '/'.ABSDIR.'/lib/images/filetypes/folder.png';
                    $command = (($open_new_window == 1) ? 'open_window(event,\'filemanager\',\'apps/filemanager\',\'' . $fdir . '\')' : 'refresh_window(event,\'' . $fdir . '\',\'' . $window_id . '\')' );
                    $file_info = 'Folder';
                }
            } else {
                //hata burda iconlar icin
                $ext_file = 'lib/images/filetypes/' . $extension . '.png';
                $ext_image = (file_exists(ABSPATH.$ext_file)) ? $ext_file : 'lib/images/filetypes/file.png';
                $command = 'filetry(event,\'' . $extension . '\',\'' . $full_path . '\')';
                $fsize = filesize($icons['path'].'/'.$icon);
                $file_info = (($fsize / 1024 > 1024)?round($fsize / (1024 * 1024) ).' MB':round($fsize / (1024)).' KB') ;
            }
            $scut_icon = '<img class="shortcut" src="lib/images/scut.png">';

            $vowels = array(".dir", ".app");
            $icon_name = str_replace($vowels, '', $icon);
            $data .=
                    '<div id="' . $icon . '" class="icon draggable" ondblclick="' . $command . '">
                <p class="icon">' . (($is_app_shortcut || $is_folder_shortcut) ? $scut_icon : '') . '<img src="' . ((strlen($icon_name) > 0) ? $ext_image : 'lib/images/filetypes/root.png') . '"></p>
                <p class="name"><span class="nameselective">' . ((strlen($icon_name) > 0) ? $icon_name : 'root') . '</span><br>
                    <span class="nameinfo">' . $file_info . '<span></p>
            </div>';
        }
        
        
        
        return $data;
    }

    public function draw_dialog($application){
        
        
    }
    
    public function draw_window($application) {
        ?>
        <script>feature_draggable();</script>
        <?= $application->application_javascript(); ?>
        <?= $application->application_css(); ?>
        <div  onclick="focus_window(event,<?= $application->window_id ?>)"  class="window draggable" id="window<?= $application->window_id ?>">
            <div class="titlebar fullwidth table">
                <div class="row">
                    <div class="cell appicon">
                        <a href="#" onclick="close_window(event,<?= $application->window_id ?>)">
                            <img src="<?= (($application->icon == 'default') ? 'lib/images/defaultapp.png' : '/'.ABSDIR.'/'.str_replace(ABSPATH, '', $application->path.'/'. $application->icon)) ?>">
                        </a>
                    </div>
                    <div class="cell appname">
                        <?= $application->name ?>
                    </div>
                    <div class="cell windowsactions">
                        <a href="#" onclick="close_window(event,<?= $application->window_id ?>)">
                            <img src="lib/images/green.png">
                        </a>
                        <a href="#" onclick="minimize_window(event,<?= $application->window_id ?>)">
                            <img src="lib/images/yellow.png">
                        </a>
                        <a href="#" onclick="close_window(event,<?= $application->window_id ?>)">
                            <img src="lib/images/close.png">
                        </a>
                    </div>
                </div>
            </div>
            <div class="toolbar">
                <?= $application->draw_application_toolbar(); ?>
            </div>
            <div class="content <?= $application->layout_type ?>" 
                 style="width:<?= $application->window_width ?>px;
                 height:<?= $application->window_height ?>px;">
                <?= $application->draw_application_content(); ?>
            </div>
        </div>
        <?php
    }

}
