<?php
class Dbconn
{
    public static function con()
    {
		$connect=mysqli_connect("localhost:3306", "ktm_con", "sG^56c50w", "db_ktm_con");
      
        if(!$connect)
        {
            die("connection error".mysqli_connect_error());
        }
        return $connect;
    }
}

?>