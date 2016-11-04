<?php

class filemanager extends application {

    const application_name = 'File Manager';
    const author = 'aramok';
    const version = '1.1';
    const width = 640;
    const height = 380;
    
    public $UI;
    public $filereader;

    function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_white';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = $app_file_name . '.png';
        $this->window_id = $window_id;


        //$projectdir = $_SERVER["DOCUMENT_ROOT"] . '/aramoknet/index.php';
        //filemanager-absolutepath == projectdir oluyor
        $this->UI = new UI_manager();
        $this->filereader = new FIO();
        $this->file = $file;
    }

    function draw_application_content() {
        $icons = $this->filereader->list_dir($this->file);
        ?>
        <div class="file-manager-content iconview-horizontal">
            <?= $this->UI->draw_icons($icons, 0, $this->window_id) ?>
        </div>
        <?php
    }

    public function application_css() {
        
    }

    public function application_javascript() {
        ?>
        <script>
            $(document).ready(function () {
                features_init();
            });

            function uplevel_dir(event, window_id) {
                var path = $('#window' + window_id + ' .input_dirpath').val();
                var uplevel = path.substring(0, path.lastIndexOf("/"));
                refresh_window(event, uplevel, window_id);
            }

            function refresh_window(event, dir, window_id) {
                var dataObject = {};
                dataObject['directory'] = dir;
                dataObject['window_id'] = window_id;
                $.ajax({
                    url: 'apps/filemanager/navigate.php',
                    type: 'post',
                    data: dataObject,
                    success: function (data, status) {
                        $('#window' + window_id + ' .file-manager-content').html(data);
                        $('#window' + window_id + ' .input_dirpath').val(dir);
                    },
                    error: function (xhr, desc, err) {
                        alert("Details: " + desc + "\nError:" + err + "--" + xhr);

                    }
                }); // end ajax call
            }
        </script>
        <?php
    }

    public function draw_application_toolbar() {
        $up_action = 'uplevel_dir(event,' . $this->window_id . ')';
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"], '', dirname(__FILE__));
        ?>
        <div class="table fullwidth">
            <div class="row">
                <div class="cell actionbuttons">
                    <a href="#" onclick="<?= $up_action ?>">
                        <img src="<?= $imagedir ?>/folder_up.png"> Up
                    </a>
                </div>
                <div class="cell dirpath">
                    <!--- NOT: BURAYA HOME:: YAPILCAK VALUE ICINE  -->
                    <input class="input_dirpath" type="text" value="<?= (isset($this->file))?$this->file:"/" ?>">
                </div>
            </div>
        </div>
        <?php
    }

}
