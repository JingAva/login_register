<?php

$db = mysqli_connect('localhost','ava','Telecom3','sklogin');

if (!$db) {
    echo "fail";
    die ("connection error"."---".mysqli_connect_error());
}




$sql="INSERT INTO `users` (`username`, `password`, `salt`) VALUES ('aaa', 'bbb', 'ccc')";
if(mysqli_query($db,$sql)){
    echo "success";
}

