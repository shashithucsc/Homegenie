<?php
class TestModel {
    private $db;

    public function __construct() {
        $this->db = new Database();
       
    }

    public function test() {
        $this->db->query("SELECT * FROM test" );
        $results = $this->db->resultset();
        return $results;
    }
       
       
}
?>
