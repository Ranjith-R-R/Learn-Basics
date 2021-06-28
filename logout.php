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
    $arr_browsers = ["Opera", "Edg", "Chrome", "Safari", "Firefox", "MSIE", "Trident"];
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $user_browser = '';
    foreach ($arr_browsers as $browser) {
        if (strpos($agent, $browser) !== false) {
            $user_browser = $browser;
            break;
        }   
    }
    switch ($user_browser) {
        case 'MSIE':
            $user_browser = 'Internet Explorer';
            break;
    
        case 'Trident':
            $user_browser = 'Internet Explorer';
            break;
    
        case 'Edg':
            $user_browser = 'Microsoft Edge';
            break;
    }
    function logout1($i,$ub)
    {
        $db = new DbConnect;
        $conn = $db->connect();
        $stmt = $conn ->prepare("update user_ui set last_logout = now(),last_accessed_page = ?,user_browser=? where username = ?");
        $stmt -> execute([$i,$ub,$_SESSION['username']]);
    }
    if(isset($_POST['logout']))
    {
        logout1($_POST['logout'],$user_browser);
    }
?>