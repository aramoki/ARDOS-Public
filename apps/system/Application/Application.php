<?php

abstract class application {

    public $window_id;  //unique id for each application window
    public $name;       //application name
    public $icon;       //application icon path
    public $path;       //application run path
    public $file;       //path of sent file to application
    public $window_width;   //app width
    public $window_height;  //app height
    public $layout_type;    //app layout

    abstract public function draw_application_content();

    abstract public function application_css();

    abstract public function application_javascript();

    abstract public function draw_application_toolbar();


    /// buraya app info cizdir diye bi secenek te koy
    // ama abstract olmasin o
}