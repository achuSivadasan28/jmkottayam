<?php
class Dbconn_common
{
    public static function con()
    {
		$connect=mysqli_connect("localhost:3306","common","8@8Ric2g9","db_common");
      
        if(!$connect)
        {
            die("connection error".mysqli_connect_error());
        }
        return $connect;
    }
}

?>