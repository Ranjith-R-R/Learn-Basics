<?php
    session_start();
    class DbConnect{
        private $host = '127.0.0.1';
        private $dbname = 'ques_entry1';
        private $user = 'root';
        private $pass = '';
        
        public function connect(){
            try {
                $conn = new PDO('mysql:host=' . $this -> host . '; dbname=' . $this->dbname,$this->user,$this->pass);
                $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
                return $conn;
            }catch(PDOException $e){
                echo 'Database Error : ' . $e->getMessage();
            }
        }
    }
    if(isset($_POST['all']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select * from main_1 order by syllabus");
        $stmt -> execute();
        $lo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo);
    }
    if(isset($_POST['con']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select count(*) from questions_tb1 where concept_id = ? and ques_type = 'mcq'");
        $stmt -> execute([$_POST['con']]);
        $lo =  $stmt->fetchColumn();
        echo json_encode($lo);
    }
    if(isset($_POST['con1']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select count(*) from questions_tb1 where concept_id = ? and ques_type = 'fib'");
        $stmt -> execute([$_POST['con1']]);
        $lo = $stmt->fetchColumn();
        echo json_encode($lo);
    }
    if(isset($_POST['pen']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select count(*) from questions_tb1 where concept_id = ? and ques_status = 'pending'");
        $stmt -> execute([$_POST['pen']]);
        $lo = $stmt->fetchColumn();
        echo json_encode($lo);
    }
    if(isset($_POST['app']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select count(*) from questions_tb1 where concept_id = ? and ques_status = 'approved'");
        $stmt -> execute([$_POST['app']]);
        $lo = $stmt->fetchColumn();
        echo json_encode($lo);
    }
    if(isset($_POST['rew']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select count(*) from questions_tb1 where concept_id = ? and ques_status = 'rework'");
        $stmt -> execute([$_POST['rew']]);
        $lo = $stmt->fetchColumn();
        echo json_encode($lo);
    }
    if(isset($_POST['user_in']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select * from user_ui order by user_id");
        $stmt -> execute();
        $lo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo);
    }
    if(isset($_POST['ad_k']))
    {
        if($_POST['ad_k'] == "0101")
        {
            $lo = 1;
        }else
        {
            $lo = 0;
        }
        echo $lo;
    }
?>