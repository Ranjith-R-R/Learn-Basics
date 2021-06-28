<?php 
    session_start();
    $host = '127.0.0.1';
    $user = 'root';
    $pass = '';
    $db = 'ques_entry1';
    $str = "mysql:host=".$host.";dbname=".$db;
    date_default_timezone_set('Asia/Kolkata'); 
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
        header("Location: ../access_denied");
        exit();
    }
    $hr = "access_denied";
    $na = "Access_denied";
    function chkuser($admin)
    {
        if($_SESSION['username'] == $admin)
        {
            global $hr,$na;
            $hr = "admin";
            $na = "CONTROL_PANEL";
            return 1;
        }else
        {
            return 0;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../stylesheets/tryslide.css">
    <script src="../lib/jquery-3.6.0.js"></script>
    <link rel="icon" href="../images/l2.png" id="dark-scheme-icon">
    <link rel="icon" href="../images/ll3.png" id="light-scheme-icon">
    <title>Learn Basics Help!!!</title>
    <style>
        body{
            font-family: Cambria;
        }
    </style>
</head>
<body>
    <span  id="mob-view"><span onclick="slide()" id="tick">&#x2630;</span>&emsp;<span>USER : <?php echo strtoupper($uuu); ?></span></span>
    <div id="main">
        <span id="tick1">
            <span id="cross" onclick="clo1()">
                ✖
            </span>
        </span>
        <span id="uuuuu" style="float: left;">USER : <?php echo strtoupper($uuu); ?></span>
        <div id="link">
            <div class="d1"><a href="../index" class="l1" id="homy">HOME</a></div>
            <div class="d2"><a href="page_ques" class="l2">QUES-ENTRY</a></div>
            <div class="d3"><a href="page_show_ques" class="l3">QUES-EDIT</a></div>
            <div class="d4"><a href="print_page" class="l4">QUES-PRINT</a></div>
            <div class="d5" id="aaa" style="display: none;"><a href="" class="l5"></a></div>
            <div class="d6"><a href="img_helper" class="l6" id="homy" target="_blank">RESIZER</a></div>
            <div class="d7"><a href="help" class="l7 active" style="cursor:help;">HELP </a></div>
        </div>
    </div><br><br><br>
        <div>
            <h1 align="center">Learn Basics Help</h1>
            <a href="https://mathlive.io/reference.html" target="_blank">Equation Help [MathLive]</a>
        </div>
    <script>
        function slide(){
            document.getElementById("main").style.display="block";
            document.getElementById("mob-view").style.display="none";
            document.getElementById('full').style.display="none";
        }
        function clo1(){
            document.getElementById("main").style.display="none";
            document.getElementById("mob-view").style.display="block";
            document.getElementById('full').style.display="block";
        }
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
                url: '../logout',
                method: 'post',
                data: 'logout=page_help'
            })
        })
        function aaa()
        {
            if(<?php echo chkuser($admin)?> == 1)
            {
                document.getElementById('aaa').style.display="inline-block";
                document.querySelector(".l5").href = "<?php echo $hr ?>";
                document.querySelector(".l5").textContent = "<?php echo $na ?>";
            }
        }
        aaa();
    </script>
</body>
</html>