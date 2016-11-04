<?php
class hashcalculator extends application{
    
    const application_name  = 'Hash Calculator';
    const author            = 'aramok';
    const version           = '1.0';
        
    function __construct($app_file_name,$window_id,$file) {
        parent::__construct(dirname(__FILE__),self::application_name,$app_file_name.'.png');
        $this->window_width = self::width;
        $this->window_height = self::height;
        
        $this->window_id = $window_id;
        $this->file = $file;
        $projectdir = $_SERVER["DOCUMENT_ROOT"].'/aramoknet/index.php';
        
       if (isset($this->file)) {
            $fo = fopen($this->file, "r");
            $file_content = fread($fo, filesize($this->file));
            fclose($fo);
        } else {
            $file_content = "int Notepad 1.0 //There is nothing to see here ";
        }
        $content .= "<script>
            $(document).ready(function () {
    $('code').each(function() {
    hljs.highlightBlock(this);
    });
});
</script>";
        $content .= '<pre><code>'.htmlspecialchars($file_content).'</code></pre>';
        
        $toolbar .= $this->file;
        
        parent::set_content($content);   
        parent::set_toolbar($toolbar);
        ?></div><?php
    }
    
    function get_name(){
        return parent::$name;
    }
    
}
