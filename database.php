<?php
class Connection
{
    public $db;
    public $dss;
    public $query;
    public $sql;
    function __construct()
    {  try{
        $this->dss = "mysql:host=localhost;dbname=avondale_community_library";
    }//endof try
    catch (PDOException $e) {
         die("ERROR: Could not connect: " . $e->getMessage());
           }
        $this->db = new PDO($this->dss, 'root', '');
    } //endof constructor
    //prepare statement function
    public function prepare()
    {
        $this->sql =  $this->db->prepare($this->query);
    }
    //no return
    public function insert()
    {
        $result = $this->sql->execute();
        return $result;
    }
    //execute one array
    public function select()
    {
        $this->sql->execute();
        return $this->sql->fetch();
    }
    //fetch multidimesional
    public function selectAll()
    {
        $this->sql->execute();
        return $this->sql->fetchAll();
    }
    public function close(){
        // close connection
        unset($this->dss);
    }
}
