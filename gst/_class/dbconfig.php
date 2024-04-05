<?php
class Dbconn
{
    public static function con()
    {
      $connect=mysqli_connect("localhost:3306","jmwell_gst","S5u6bw*4","db_jmwell_gst");
        if(!$connect)
        {
            die("connection error".mysqli_connect_error());
        }
        return $connect;
    }
    
    
}
?>