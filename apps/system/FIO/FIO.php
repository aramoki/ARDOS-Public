<?php

class FIO {

    public $absolute_path;

    function __construct() {
        $this->absolute_path = ABSPATH;
    }

    public function list_dir($directory = null) {
        if ($directory === null) {
            $directory = $this->absolute_path;
        } else if ($directory == '') {
            $directory = "/";
        }
        $scanned_directory['path'] = str_replace('//', '/', $directory);
        $scanned_directory['name'] = array_diff(scandir($directory), array('..', '.', '.DS_Store'));
        return $scanned_directory;
    }

    public function list_dir_sorted($directory = null) {
        if ($directory === null) {
            $directory = $this->absolute_path;
        } else if ($directory == '') {
            $directory = "/";
        }
        $scanned_directory['path'] = $directory;
        $scanned_directory['name'] = (array_diff(scandir($directory), array('..', '.', '.DS_Store')));
        //sort($scanned_directory['name'],SORT_NUMERIC);
        usort($scanned_directory['name'], create_function('$a,$b', '
	return	is_dir ($a)
		? (is_dir ($b) ? strnatcasecmp ($a, $b) : -1)
		: (is_dir ($b) ? 1 : (
			strcasecmp (pathinfo ($a, PATHINFO_EXTENSION), pathinfo ($b, PATHINFO_EXTENSION)) == 0
			? strnatcasecmp ($a, $b)
			: strcasecmp (pathinfo ($a, PATHINFO_EXTENSION), pathinfo ($b, PATHINFO_EXTENSION))
		))
	;'));
        return $scanned_directory;
    }


    public static function is_folder($file) {
        return is_dir($file);
    }
    
    public static function delete_file($file){
        if(file_exists($file)){;
            if(@unlink($file)){
                echo 'success';
            }else{
                echo 'failure';
            }
        }
    }
     public static function rename_file($file,$newfilename){
        if(file_exists($file)){
            if(@rename($file,dirname($file).'/'.$newfilename)){
                echo 'success';
                
            }else{
                echo 'failure';
                
            }
        }
    }

  
}
