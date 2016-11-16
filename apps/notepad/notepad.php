<?php

class notepad extends application {

    const application_name = 'Notepad ';
    const author = 'aramok';
    const version = '1.1';
    const info = "";
    
    const width = 840;
    const height = 580;

    function __construct($app_file_name, $window_id, $file) {
        $this->layout_type = 'layout_white';
        $this->window_width = self::width;
        $this->window_height = self::height;
        $this->path = dirname(__FILE__);
        $this->name = self::application_name;
        $this->icon = $app_file_name . '.png';
        $this->window_id = $window_id;
        $this->file = $file;
        $this->resize = parent::RESIZE_FULL;
    }

    public function application_css() {
        ?>
        <style>
            pre.dot span:before {
                counter-increment: line;
                content: counter(line);
                display: inline-block;
                border-right: 1px solid #ddd;
                padding: 0 .5em;
                margin-right: .5em;
                color: #888
            }
        </style>
        <?php
    }

    public function application_javascript() {
        ?>
        <script>
            $(document).ready(function () {
                $('code').each(function () {
                    hljs.highlightBlock(this);
                });
            });
        </script>
        <?php
    }

    public function draw_application_content() {
        if (isset($this->file)) {
            $fo = fopen($this->file, "r");
            $file_content = fread($fo, filesize($this->file));
            fclose($fo);
        } else {
            $file_content = "Notepad 1.1 v1.1-class system added.";
        }
        ?>
        <pre><code><?= htmlspecialchars($file_content,ENT_QUOTES); ?></code></pre>   
        <?php
    }

    public function draw_application_toolbar() {
        echo $this->file;
    }

}
