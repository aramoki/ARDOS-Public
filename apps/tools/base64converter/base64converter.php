<?php

class hashcalculator extends application {

    const application_name = 'Hash Calculator';
    const author = 'aramok';
    const version = '1.0';
    const width = 540;
    const height = 340;

    function __construct($app_file_name, $window_id, $file) {
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
            div.systeminfo-cell{
                padding:20px;
            }
            div.systeminfo-cell:nth-child(odd){
                border-right:1px solid #ccc;
            }
            div.systeminfo-cell:nth-child(even){
                border-left:1px solid #eee;
            }
        </style>
        <?php
    }

    public function application_javascript() {
        $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        ?>
        <script>
            function calculate_hash<?= $this->window_id ?>(event) {
                event.preventDefault();
                var dataObject = {};
                dataObject["string"] = $("#<?= $this->window_id ?>hash_string").val();
                dataObject["type"] = $("#<?= $this->window_id ?>hash_type").val();
                $.ajax({
                    url: "<?= $imgdir ?>/hash.php",
                    type: "post",
                    data: dataObject,
                    success: function (data, status) {
                        $("#<?= $this->window_id ?>hash_result").val(data);
                    }}); // end ajax call
            }
        </script>
        <?php
    }

    public function draw_application_content() {
        $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);
        foreach (hash_algos() as $v) {
            $hash_types_select .= '<option>' . $v . '</option>';
        }
        ?>
        <div class="table">
            <div class="row">
                <div class="cell systeminfo-cell">
                    <img src="<?= $imgdir ?>/hash.png">
                </div>
                <div class="cell systeminfo-cell">
                    String:<br>
                    <input type="text" class="input" size="40" id="<?= $this->window_id ?>hash_string"><br><br>
                    Hashing Method:<br>
                    <select class="select" id="<?= $this->window_id ?>hash_type">
        <?= $hash_types_select ?> 
                    </select><br><br>
                    Result:<br>
                    <input type="text" class="input" size="55" id="<?= $this->window_id ?>hash_result"><br>
                    <span class="alright">
                        <a class="button" href="#" onclick="calculate_hash<?= $this->window_id ?>(event)"> Calculate </a>
                    </span>

                </div>
            </div>
        </div>

        <?php
    }

    public function draw_application_toolbar() {
        
    }

}
