<?php
class Dbconn
{
    public static function con()
    {
      $connect=mysqli_connect("localhost:3306","ktm_phy","bX2p51w^1","db_ktm_phy");
        if(!$connect)
        {
            die("connection error".mysqli_connect_error());
        }
        return $connect;
    }
    
    
}
?>