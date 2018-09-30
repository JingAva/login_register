<?php
class Cookie{
    //check if the cookie exists
    public static function exists($name){
        return (isset($_COOKIE[$name]))?true:false;
    }

    //get the cookie info
    public static function get($name){
        return $_COOKIE[$name];
    }

    //store the info into cookie with a name, value and expiry time
    public static function put($name,$value,$expiry){
        if(setcookie($name,$value,time()+$expiry,'/')){
            return true;
        }
        return false;
    }

    //to undefine/delete the cookie
    public static function delete($name){
        self::put($name,'',time()-1);
    }
}
?>