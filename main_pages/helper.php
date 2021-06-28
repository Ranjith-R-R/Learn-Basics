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
    if(isset($_POST['mcq']))
    {
        $_SESSION['qtype'] = $_POST['mcq'];
    }
    if(isset($_POST['fib']))
    {
        $_SESSION['qtype'] = $_POST['fib'];
    }
    /*function load1(){
        $db = new DbConnect;
        $conn = $db->connect();

        $stmt = $conn ->prepare("select syllabus from main_1");
        $stmt -> execute();
        $lo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $lo;
    }*/
    if(isset($_POST['syl']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $_SESSION['syl'] = $_POST['syl'];
        $stmt = $conn ->prepare("select DISTINCT class from main_1 where syllabus = ?");
        $stmt -> execute([$_POST['syl']]);
        $lo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo);
    }
    if(isset($_POST['cls']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $_SESSION['cls'] = $_POST['cls'];
        $stmt = $conn ->prepare("select DISTINCT subject from main_1 where class = ? and syllabus = ?");
        $stmt -> execute([$_POST['cls'],$_SESSION['syl']]);
        $lo1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo1);
    }
    if(isset($_POST['sub']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $_SESSION['sub'] = $_POST['sub'];
        $stmt = $conn ->prepare("select DISTINCT chapter from main_1 where subject = ? and syllabus = ? and class = ?");
        $stmt -> execute([$_POST['sub'],$_SESSION['syl'],$_SESSION['cls']]);
        $lo2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo2);
    }
    if(isset($_POST['chap']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $_SESSION['chap'] = $_POST['chap'];
        $stmt = $conn ->prepare("select DISTINCT topic from main_1 where chapter = ? and syllabus = ? and class = ? and subject = ?");
        $stmt -> execute([$_POST['chap'],$_SESSION['syl'],$_SESSION['cls'],$_SESSION['sub']]);
        $lo3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo3);
    }
    if(isset($_POST['topic']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $_SESSION['topic'] = $_POST['topic'];
        $stmt = $conn ->prepare("select DISTINCT concept from main_1 where chapter = ? and syllabus = ? and class = ? and subject = ? and topic = ?");
        $stmt -> execute([$_SESSION['chap'],$_SESSION['syl'],$_SESSION['cls'],$_SESSION['sub'],$_POST['topic']]);
        $lo4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo4);
    }
    if(isset($_POST['conc']))
    {
        $_SESSION['concept'] = $_POST['conc'];
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select DISTINCT concept_id from main_1 where chapter = ? and syllabus = ? and class = ? and subject = ? and topic = ? and concept = ?");
        $stmt -> execute([$_SESSION['chap'],$_SESSION['syl'],$_SESSION['cls'],$_SESSION['sub'],$_SESSION['topic'],$_POST['conc']]);
        $pr = $stmt->fetch();
        $_SESSION['conc'] = $pr['concept_id'];
        date_default_timezone_set('Asia/Kolkata');
        $date = date("j-m-Y + h:i:s A");
        $stmt = $conn ->prepare("update main_1 set last_accessed_by = ?,last_accessed_date = ? where concept_id = ?");
        $stmt -> execute([$_SESSION['username'],$date,$_SESSION['conc']]);
    }
?>