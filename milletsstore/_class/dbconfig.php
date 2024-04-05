<?php
class Dbconn
{
    public static function con()
    {
      $connect=mysqli_connect("localhost:3306","ktm_millet","!O9j7t34b","db_ktm_millet");
        if(!$connect)
        {
            die("connection error".mysqli_connect_error());
        }
        return $connect;
    }
    
    
}
?>