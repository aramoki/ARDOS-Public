<?php
class imagaeviewer extends application{
    
    const application_name  = 'Image Viever';
    const author            = 'aramok';
    const version           = '1.0';
    
        
    function __construct($app_file_name,$window_id,$file) {
        parent::__construct(dirname(__FILE__),self::application_name,$app_file_name.'.png');
        $this->window_id = $window_id;
        $this->file = $file;
        $projectdir = $_SERVER["DOCUMENT_ROOT"].'/aramoknet/index.php';
        $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"] ,'',$this->file);
        
        list($img_w, $img_h) = getimagesize($file);
        $this->window_width = $img_w;
        $this->window_height = $img_h;
        
        
        
        $content .= '<div style="text-align:center;"><img src="'.$imgdir.'"></div>';
        
        //$toolbar .= $this->file;
        
        parent::set_content($content);   
        parent::set_toolbar($toolbar);
        ?></div><?php
    }
    
    function get_name(){
        return parent::$name;
    }
    
}
