<?php
class Input{
    //check if the fields are all filled
    public static function exists($type = 'post') {
        switch($type){
                case 'post';
                    return (!empty($_POST))? true : false;
                break;
                case 'get';
                    return (!empty($_POST))? true : false;
                break;
                default;
                    return false;
                break; 
        }
    }

    //get the data from other php page by posting or getting
    public static function get($item){
        if(isset($_POST[$item])) {
            return $_POST[$item];
        }
        else if (isset($_GET[$item])) {
            return $_GET[$item];
        }
        return '';
    }
}