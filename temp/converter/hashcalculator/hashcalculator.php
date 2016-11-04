<?php

class hashcalculator extends application {

    const application_name = 'Hash Calculator';
    const author = 'aramok';
    const version = '1.0';
    const width = 540;
    const height = 340;

    function __construct($app_file_name, $window_id, $file) {
        parent::__construct(dirname(__FILE__), self::application_name, $app_file_name . '.png');
        $this->window_id = $window_id;
        $this->file = $file;
        $this->window_width = self::width;
        $this->window_height = self::height;
        //$projectdir = $_SERVER["DOCUMENT_ROOT"].'/aramoknet/index.php';
        $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"], '', $this->path);



        $content .= '<style>'
                . 'div.systeminfo-cell{padding:20px;}'
                . 'div.systeminfo-cell:nth-child(odd){border-right:1px solid #ccc;}'
                . 'div.systeminfo-cell:nth-child(even){border-left:1px solid #eee;}'
                . '</style>';

        //$("#'.$window_id.'hash_result").val(string + type + "'.$this->path.'");

        $content .= '<script>
                function calculate_hash' . $window_id . '(event){
                    event.preventDefault();
                    var dataObject = {};
                    dataObject["string"] = $("#' . $window_id . 'hash_string").val();
                    dataObject["type"]   = $("#' . $window_id . 'hash_type").val();
                        $.ajax({
                            url: "' . $imgdir . '/hash.php",
                            type: "post" ,
                            data: dataObject,
                            success: function (data, status) {
                                $("#' . $window_id . 'hash_result").val(data);
                            }}); // end ajax call
                }
                </script>';

                foreach (hash_algos() as $v) {
                $hash_types_select .= '<option>'.$v.'</option>';
                }
        
        $content .= '<div class="table">
        <div class="row">
            <div class="cell systeminfo-cell"><img src="' . $imgdir . '/hash.png"></div>
            <div class="cell systeminfo-cell">
                String:<br>
                <input type="text" class="input" size="40" id="' . $window_id . 'hash_string"><br><br>
                Hashing Method:<br>
                <select class="select" id="' . $window_id . 'hash_type">
                    '.$hash_types_select.' 
                </select><br><br>
                Result:<br>
                <input type="text" class="input" size="55" id="' . $window_id . 'hash_result"><br>
                <span class="alright">
                <a class="button" href="#" onclick="calculate_hash' . $window_id . '(event)"> Calculate </a>
                 </span>
            
            </div>
        </div>
        </div>';



        //$toolbar .= $this->file;

        parent::set_content($content);
        parent::set_toolbar($toolbar);
    }

    function get_name() {
        return parent::$name;
    }

}
