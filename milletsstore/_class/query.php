<?php
include_once 'dbconfig.php';
class query
{
    public $conn;
    function __construct()
    {
        $this->conn=Dbconn::con();
    }
    public function selectData($filed,$table,$where)
    {
        $sql="select $filed from $table $where";
        return mysqli_query($this->conn,$sql);
    }
    public function selectData1($filed,$table,$where)
    {
        $sql="select $filed from $table $where";
        return $sql;
    }
    public function insertData($table,$data)
    {
        $stm="";
        foreach($data as $key1=>$data1)
        {
            if($stm=="")
            {
                $stm=$stm.$key1;
            }
            else
            {
                $stm=$stm.",".$key1;
            }
        }
        $stm1="insert into $table($stm) values(";
        $stm2="";
        $stm3=")";
        foreach($data as $key=>$data1)
        {
            if($stm2=="")
            {
                $stm2=$stm2."'".mysqli_real_escape_string($this->conn,$data1)."'";
            }
            else
            {
                $stm2=$stm2.",'".mysqli_real_escape_string($this->conn,$data1)."'";
            }
        }
        $query=$stm1.$stm2.$stm3;
        // return $query;
        mysqli_query($this->conn,$query);
    }

    public function insertData1($table,$data)
    {
        $stm="";
        foreach($data as $key1=>$data1)
        {
            if($stm=="")
            {
                $stm=$stm.$key1;
            }
            else
            {
                $stm=$stm.",".$key1;
            }
        }
        $stm1="insert into $table($stm) values(";
        $stm2="";
        $stm3=")";
        foreach($data as $key=>$data1)
        {
            if($stm2=="")
            {
                $stm2=$stm2."'".mysqli_real_escape_string($this->conn,$data1)."'";
            }
            else
            {
                $stm2=$stm2.",'".mysqli_real_escape_string($this->conn,$data1)."'";
            }
        }
        $query=$stm1.$stm2.$stm3;
        return $query;
        //exit();
        //mysqli_query($this->conn,$query);
    }
    //update query
    function updateData($table,$info,$where)
    {
        $stm="";
        foreach($info as $key1=>$data)
        {
            if($stm=="")
            {
                $stm=$stm.$key1."='".mysqli_real_escape_string($this->conn,$data)."'";
            }
            else
            {
                $stm=$stm.",".$key1."='".mysqli_real_escape_string($this->conn,$data)."'";
            }
        }
        $stmt="update $table set $stm $where";
        //echo $stmt;exit();
        mysqli_query($this->conn,$stmt);
    }

        //update query
        function updateData1($table,$info,$where)
        {
            $stm="";
            foreach($info as $key1=>$data)
            {
                if($stm=="")
                {
                    $stm=$stm.$key1."='".mysqli_real_escape_string($this->conn,$data)."'";
                }
                else
                {
                    $stm=$stm.",".$key1."='".mysqli_real_escape_string($this->conn,$data)."'";
                }
            }
            $stmt="update $table set $stm $where";
            echo $stmt;exit();
            //mysqli_query($this->conn,$stmt);
        }
	
	
    
}

?>