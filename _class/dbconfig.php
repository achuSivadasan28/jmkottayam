<?php
class Dbconn
{
    public static function con()
    {
      $connect=mysqli_connect("localhost:3306","root","","db_ktm_py");
        if(!$connect)
        {
            die("connection error".mysqli_connect_error());
        }
        return $connect;
    }
    
    
}
?>