<?php
class dialogbox extends application{
    
    const application_name  = 'Dialog Box';
    const author            = 'aramok';
    const version           = '1.0';
    const width             = 300;
    const height            = 110;
        
    
    //$dialogbox_type
        //0:info
        //1:error
        //3:something
    function __construct($dialogbox_type,$window_id,$file) {
        parent::__construct(dirname(__FILE__),self::application_name,'dialog'.$dialogbox_type.'.png');
        $this->window_width = self::width;
        $this->window_height = self::height;
        
        $this->window_id = $window_id;
        $this->file = $file;
        $projectdir = $_SERVER["DOCUMENT_ROOT"].'/aramoknet/index.php';
        $imagedir = str_replace($_SERVER["DOCUMENT_ROOT"],'', dirname(__FILE__));
       
        $content = '<div class="dialog_layout"><p class="dialogbox_text">';
        if($dialogbox_type == 0){
            $content .= 'info box</p>';
        }else if($dialogbox_type == 1){
            $content .= '<b>Error:</b> This program is cant be opened , something is missing!</p>';
        }
        $content .= '<p class="dialogbox_action alcenter"><a href="#" class="button" onclick="close_window(event,'.$this->window_id.');">Close</a></p>';
        $content .= '</div>';
        
        
        parent::set_content($content);   
        parent::set_toolbar($toolbar);
    }
    
    function get_name(){
        return parent::$name;
    }
    
}
