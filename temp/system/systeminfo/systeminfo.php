<?php
class systeminfo extends application{
    
    const application_name  = 'System Info';
    const author            = 'aramok';
    const version           = '1.0';
    const width             = 540;
    const height            = 370;
    
        
    function __construct($app_file_name,$window_id,$file) {
        parent::__construct(dirname(__FILE__),self::application_name,$app_file_name.'.png');
        $this->window_id = $window_id;
        $this->file = $file;
        $this->window_width = self::width;
        $this->window_height = self::height;
        //$projectdir = $_SERVER["DOCUMENT_ROOT"].'/aramoknet/index.php';
        $imgdir = str_replace($_SERVER["DOCUMENT_ROOT"] ,'',$this->path);
        
        
        
        $content .= '<style>'
                . 'div.systeminfo-cell{padding:20px;}'
                . 'div.systeminfo-cell:nth-child(odd){border-right:1px solid #ccc;}'
                . 'div.systeminfo-cell:nth-child(even){border-left:1px solid #eee;}'
                . '</style>';
        $content .= '<div class="table">
        <div class="row">
            <div class="cell systeminfo-cell"><img src="'.$imgdir.'/computer.png"></div>
            <div class="cell systeminfo-cell">
                <b>Host:</b><br>
                '.$_SERVER['HTTP_HOST'].'<br>'.$_SERVER['DOCUMENT_ROOT'].'<br><br>
                <b>Browser:</b><br>
                '.$_SERVER['HTTP_USER_AGENT'].'<br><br>
                <b>Server Software:</b><br>
                '.$_SERVER['SERVER_SOFTWARE'].'<br><br>
                <b>IP Address:</b><br>
                '.$_SERVER['REMOTE_ADDR'].'<br><br>
                <span class="alright"><a class="button" href="#" onclick="close_window(event,'.$this->window_id.')"> Close </a></span>
            
            </div>
        </div>
        </div>';
        
        
        
        //$toolbar .= $this->file;
        
        parent::set_content($content);   
        parent::set_toolbar($toolbar);
    }
    
    function get_name(){
        return parent::$name;
    }
    
}
