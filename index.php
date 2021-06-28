<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/l2.png" id="dark-scheme-icon">
    <link rel="icon" href="images/ll3.png" id="light-scheme-icon">
    <script src="lib/jquery-3.6.0.js" type="text/javascript"></script>
    <title>Learn Basics - Home</title>
    <style>
        body{
            font-family: Cambria;
            font-size: 20px;
        }
        body a{
            text-decoration: none;
            color: blue;
        }
        #fii{
            position: fixed;
            top: -25px;
            left: 0;
            width: 100%;
        }
        h1{
            border:2px solid black;
            padding:10px;
        }

        #s1,#s2,#s3,#s4,#s5{
            font-size: 30px;
            border: 5px ridge blue;
            padding: 10px;
            width: 46%;
            height: 300px;
            transition: .7s;
            text-align: center;
            border-radius: 20px;
        }
        #s1{
            float: left;
        }
        #s2,#s4{
            margin-top: 10%;
            float: right;
        }
        #s3,#s5{
            margin-top: 10%;
            float: left;
        }
        #s1:hover,#s2:hover,#s3:hover,#s4:hover,#s5:hover{
            height: 305px;
            width: 48%;
            background-color: lightgoldenrodyellow;
        }
        h1 button{
            font-family: inherit;
            font-size: 18px;
            padding: 10px;
            width: 150px;
            cursor: pointer;
        }
        @media only screen and (min-width: 1040px)
        {
            #i1,#i2,#i3,#i4,#i5{
                height:70%; 
                width:50%;
            }
            #userr{
                margin-top:10px;
                float: left;
                font-weight:200;
                font-size:25px;
                font-variant:small-caps;
            }
        }
        @media only screen and (max-width: 1040px)
        {
            #i1,#i2,#i3,#i4,#i5{
                height: 60%;
                width:90%;
            }
            #hh{
                display: block;
            }
            #userr{
                font-weight:200;
                font-size:25px;
                font-variant:small-caps;
            }
        }
    </style>
</head>
<body>
    <?php
        session_start();
        $host = '127.0.0.1';
    $user = 'root';
    $pass = '';
    $db = 'ques_entry1';
    $str = "mysql:host=".$host.";dbname=".$db;
    $con = new PDO($str,$user,$pass);
    $sql = "select * from user_ui where user_type=?";
    $res = $con->prepare($sql);
    $res->execute(['admin']);
    $pr = $res->fetch();
    $admin = $pr['username'];
    if(isset($_SESSION['username']))
    {
        $uuu = $_SESSION['username'];
        if($uuu == $admin)
        {
            $uuu = $uuu ." (Admin)";
        }
    }else
    {
        header("Location: access_denied");
        exit();
    }
    $hr = "access_denied";
    $im = "Access_denied";
    $txt = "Access_denied";
    function chkuser($admin)
    {
        if($_SESSION['username'] == $admin)
        {
            global $hr,$im,$txt;
            $hr = "main_pages/admin";
            $im = "images/admin.png";
            $txt = "Control_Panel";
            return 1;
        }else
        {
            return 0;
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
        function ll()
        {
            require 'logout.php';
            logout1("logged_out",$user_browser);
            return 1;
        }
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $r = ll();
            if($r = true)
            {
                session_destroy();
                header("Location: login");
                exit();
            }
        }
    ?>
    <div  id="fii"><h1 align="center"><span id="hh">Learn Basics</span><span id="userr">Welcome <?php echo $uuu;?></span><span style="float: right;margin-top:-5px;"><form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
        <div><button type="submit" id="log">Log Out</button></div>
    </form></span></h1></div><br><br><br><br><br><br>
    <a href="main_pages/page_ques"><div id="s1"><img src="images/data_entry3.png" id="i1"><br>Question_Entry</div></a>
    <a href="main_pages/page_show_ques"><div id="s2"><img src="images/data_edit.png" id="i2" height="60%" width="50%"><br>Question_Edit</div></a>
    <a href="main_pages/print_page"><div id="s3"><img src="images/download.png" id="i3" height="60%" width="50%"><br>Question_Print</div></a>
    <a href="main_pages/help"><div id="s4"><img src="images/help.png" id="i4" height="60%" width="50%"><br>Help ?</div></a>
    <div id="aaa" style="display: none;"><a href="#" id="adhr"><div id="s5"><img src="" id="i5" height="60%" width="50%"><br><span id="aaan"></span></div></a></div>
    <script>
        lightSchemeIcon = document.querySelector('link#light-scheme-icon');
        darkSchemeIcon = document.querySelector('link#dark-scheme-icon');
        matcher = window.matchMedia('(prefers-color-scheme: dark)');
        matcher.addListener(onUpdate);
        onUpdate();

        function onUpdate() {
            if (matcher.matches) {
                lightSchemeIcon.remove();
                document.head.append(darkSchemeIcon);
            } else {
                document.head.append(lightSchemeIcon);
                darkSchemeIcon.remove();
            }
        }
        $(window).ready(function(){
            $.ajax({
                url: 'logout',
                method: 'post',
                data: 'logout=home_page'
            })
        })
        function aaa()
        {
            if(<?php echo chkuser($admin)?> == 1)
            {
                document.getElementById('aaa').style.display="block";
                document.getElementById('adhr').href = "<?php echo $hr ?>";
                document.getElementById('i5').src = "<?php echo $im ?>";
                document.getElementById('aaan').textContent = "<?php echo $txt ?>";
            }
        }
        aaa();
    </script>
</body>
</html>