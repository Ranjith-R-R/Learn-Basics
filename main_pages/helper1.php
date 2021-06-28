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
        $_SESSION['qtype1'] = $_POST['mcq'];
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select * from questions_tb1 where concept_id = ? and ques_type = 'mcq' order by question_id");
        $stmt -> execute([$_SESSION['conc1']]);
        $lo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo);
    }
    if(isset($_POST['stat']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        date_default_timezone_set('Asia/Kolkata');
        $date = date("j-m-Y + h:i:s A");
        $stmt = $conn ->prepare("update questions_tb1 set ques_status = ?,updated_by = ?,updated_date = ? where question_id = ?");
        $stmt -> execute([$_POST['stat'],$_SESSION['username'],$date,$_POST['id']]);
    }
    if(isset($_POST['fib']))
    {
        $_SESSION['qtype1'] = $_POST['fib'];
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select * from questions_tb1 where concept_id = ? and ques_type = 'fib' order by question_id");
        $stmt -> execute([$_SESSION['conc1']]);
        $lo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo);
    }
    if(isset($_POST['del1']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("delete from questions_tb1 where question_id = ?");
        $stmt -> execute([$_POST['del1']]);
        $stmt = $conn ->prepare("delete from ans_options where question_id = ?");
        $stmt -> execute([$_POST['del1']]);
    }
    if(isset($_POST['fib1']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select * from questions_tb1 where question_id = ?");
        $stmt -> execute([$_POST['fib1']]);
        $lo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo);
    }
    if(isset($_POST['mcq1']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select * from questions_tb1 where question_id = ?");
        $stmt -> execute([$_POST['mcq1']]);
        $lo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo);
    }
    if(isset($_POST['q_id']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt2 = $conn ->prepare("select * from ans_options where question_id = ? order by option_id");
        $stmt2 -> execute([$_POST['q_id']]);
        $lo2 = $stmt2 ->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo2);
    }

    if(isset($_POST['q_id_try']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt2 = $conn ->prepare("select * from questions_tb1 q, ans_options o WHERE q.question_id = o.question_id and q.question_id = ?");
        $stmt2 -> execute([$_POST['q_id_try']]);
        $lo2 = $stmt2 ->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo2);
    }




    if(isset($_POST['syl']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $_SESSION['syl1'] = $_POST['syl'];
        $stmt = $conn ->prepare("select DISTINCT class from main_1 where syllabus = ?");
        $stmt -> execute([$_POST['syl']]);
        $lo = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo);
    }
    if(isset($_POST['cls']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $_SESSION['cls1'] = $_POST['cls'];
        $stmt = $conn ->prepare("select DISTINCT subject from main_1 where class = ? and syllabus = ?");
        $stmt -> execute([$_POST['cls'],$_SESSION['syl1']]);
        $lo1 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo1);
    }
    if(isset($_POST['sub']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $_SESSION['sub1'] = $_POST['sub'];
        $stmt = $conn ->prepare("select DISTINCT chapter from main_1 where subject = ? and syllabus = ? and class = ?");
        $stmt -> execute([$_POST['sub'],$_SESSION['syl1'],$_SESSION['cls1']]);
        $lo2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo2);
    }
    if(isset($_POST['chap']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $_SESSION['chap1'] = $_POST['chap'];
        $stmt = $conn ->prepare("select DISTINCT topic from main_1 where chapter = ? and syllabus = ? and class = ? and subject = ?");
        $stmt -> execute([$_POST['chap'],$_SESSION['syl1'],$_SESSION['cls1'],$_SESSION['sub1']]);
        $lo3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo3);
    }
    if(isset($_POST['topic']))
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $_SESSION['topic1'] = $_POST['topic'];
        $stmt = $conn ->prepare("select DISTINCT concept from main_1 where chapter = ? and syllabus = ? and class = ? and subject = ? and topic = ?");
        $stmt -> execute([$_SESSION['chap1'],$_SESSION['syl1'],$_SESSION['cls1'],$_SESSION['sub1'],$_POST['topic']]);
        $lo4 = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($lo4);
    }
    if(isset($_POST['conc']))
    {
        $_SESSION['concept1'] = $_POST['conc'];
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("select DISTINCT concept_id from main_1 where chapter = ? and syllabus = ? and class = ? and subject = ? and topic = ? and concept = ?");
        $stmt -> execute([$_SESSION['chap1'],$_SESSION['syl1'],$_SESSION['cls1'],$_SESSION['sub1'],$_SESSION['topic1'],$_POST['conc']]);
        $pr = $stmt->fetch();
        $_SESSION['conc1'] = $pr['concept_id'];
        date_default_timezone_set('Asia/Kolkata');
        $date = date("j-m-Y + h:i:s A");
        $stmt = $conn ->prepare("update main_1 set last_accessed_by = ?,last_accessed_date = ? where concept_id = ?");
        $stmt -> execute([$_SESSION['username'],$date,$_SESSION['conc1']]);
    }
?>