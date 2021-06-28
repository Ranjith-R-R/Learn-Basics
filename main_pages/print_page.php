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
    $_SESSION['username2'] = $_SESSION['username'];
    $ser = $_SERVER['SERVER_ADDR'];
?>
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylesheets/page_ques.css" type="text/css">
    <link rel="icon" href="../images/l2.png" id="dark-scheme-icon">
    <link rel="icon" href="../images/ll3.png" id="light-scheme-icon">
    <script src="../lib/jquery-3.6.0.js"></script>
    <script src="../scripts/print_page.js" type="text/javascript"></script>
    <link href="../stylesheets/tryslide.css" type="text/css" rel="stylesheet">
    <title>Question Print</title>
    <style>
        #openshowall{
            border : 2px solid black;
            padding: 20px 20px;
            display: none;
        }
        #openshowall button{
            width: 180px;
            font-family: inherit;
            font-size: 18px;
            padding: 10px 10px;
            cursor:pointer;
        }
        #imado{
            height: 50px;
            width: 50px;
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
            <div class="d4"><a href="print_page" class="l4 active">QUES-PRINT</a></div>
            <div class="d5" id="aaa" style="display: none;"><a href="" class="l5"></a></div>
            <div class="d6"><a href="img_helper" class="l6" target="_blank">RESIZER</a></div>
            <div class="d7"><a href="help" class="l7" style="cursor:help;">HELP </a></div>
        </div>
    </div><br><br><br>
    <div id="full">
    <header>
        <h1 align="center">Question Print Form</h1>
    </header><br>
    <div id="getdata1">
        <form>
        <table>
            <tr>
                <td><label for="syl">Syllabus</label></td><td><select name="syl" title="Select Syllabus" id="loadsyl" onchange="opendis1(this,'loadcls',0);">
                    <option disabled selected>--- Select Syllabus ---</option>
                    <option value="samacheer">Samacheer</option>
                    <option value="CBSE">CBSE</option>
                </select></td>
                <td><label for="cls">Class</label></td><td><select name="cls" title="Select Class" id="loadcls" onchange="opendis1(this,'loadsub',1);" disabled>
                    <option disabled selected>--- Select Class ---</option>
                    
                </select></td>
                <td><label for="sub">Subject</label></td>
                <td><select name="sub" title="Select Subject" id="loadsub"  onchange="opendis1(this,'loadchap',2)" disabled>
                    <option disabled selected>--- Select Subject ---</option>
                </select></td>
            </tr>
            <tr>
                <td><label for="chap">Chapter</label></td><td><select name="chap" title="Select Chapter" id="loadchap" onchange="opendis1(this,'loadtopic',3)" disabled>
                    <option disabled selected>--- Select Chapter ---</option>
                </select></td>
                <td><label for="topic">Topic</label></td><td><select name="topic" title="Select Topic" id="loadtopic" onchange="opendis1(this,'loadconc',4)" disabled>
                    <option disabled selected>--- Select Topic ---</option>
                </select></td>
                <td><label for="conc">Concept</label></td><td><select name="conc" title="Select Concept" id="loadconc" onchange="opendis1(this,'mcq',5)" disabled>
                    <option disabled selected>--- Select Concept ---</option>
                </select></td>
            </tr>
        </table>
        </form>
    </div><br>
    <div id="getdata2">  
        <table align="center">
            <tr>
                <td>Question Type : </td>
                <td><input type="radio" id="mcq" value="mcq" title="Insert MCQ Questions.." name="qtype" disabled> MCQ's</td>
                <td><input type="radio" id="fib" value="fib" title="Insert Fill int the Questions.." name="qtype" disabled> Fill in the blanks</td>
            </tr>
        </table>
    </div><br>
    <div id="nothing" style="text-align: center;">
        <img src="../images/download.png" title="Please Select Above options to view in Details" height="200px" width="200px" style="pointer-events: none;margin-top: -5px;">
    </div>
    <div id="openshowall">
        <table id='show_all' style="border-collapse:collapse;font-family:inherit;font-size: 25px;" width="100%">
            
        </table>
    </div>
</div>
    <script>
        var change = 0;
        <?php
            function varr($i)
            {
                $vv = ['syl2','cls2','sub2','chap2','topic2','concept2','qtype2'];
                if(isset($_SESSION[$vv[$i]]))
                {
                    return $_SESSION[$vv[$i]];
                }else
                {
                    return '0';
                }
            }
        ?>
        var variables = ["<?php echo varr(0)?>","<?php echo varr(1)?>","<?php echo varr(2)?>","<?php echo varr(3)?>","<?php echo varr(4)?>","<?php echo varr(5)?>","<?php echo varr(6)?>"];
        function sess() 
        {
            <?php 
                if(isset($_SESSION['username']))
                {
                    $samp = "1";
                }else
                {
                    $samp = "0";
                }
            ?>
            if(<?php echo $samp ?> == 1)
            {
                if(variables[0] != '0' && variables[1] != '0' && variables[2] != '0' && variables[3] != '0' && variables[4] != '0' && variables[5] != '0' && variables[6] != '0')
                {
                    $('#loadsyl option[value="'+variables[0]+'"]').attr('selected','selected').change();
                    change = 1;
                }else
                {
                    change = 0;
                }
            }
        }
        sess();
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
        $(window).ready(function(){
            $.ajax({
                url: '../logout',
                method: 'post',
                data: 'logout=page_print'
            })
        })
        function printpdf()
        {
            alert("DOC is generating");
            var filename = "<?php date_default_timezone_set('Asia/Kolkata');$date = date("j-m-Y + h-i-s A"); echo $date;?>" + ".doc";
            exportHTML(filename);
        }
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
        var ser = "<?php echo $ser ?>";
    </script>
</body>
</html>


