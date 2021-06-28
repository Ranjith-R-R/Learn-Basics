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
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if( $_POST['submit_2'] >= 2) 
        {
            try
            {
                $con = new PDO($str,$user,$pass);
                $date = date("j-m-Y + h:i:s A");
                $cid = $_SESSION['conc'];
                $sql = "select * from questions_tb1 ORDER BY question_id DESC LIMIT 1";
                $res = $con->prepare($sql);
                $res->execute();
                $pr = $res->fetch();
                if($pr)
                {
                    $qid = $pr["question_id"];
                    $qid+=1;
                }else
                {
                    $qid = 1;
                }
                $qtype = $_SESSION['qtype'];
                if($qtype == "mcq")
                {
                    if(isset($_POST['ques']))
                    {
                        $ques = $_POST['ques'];
                        if(isset($_POST['iseqn']))
                        {
                            $uplo_ty = "eqn";
                        }else
                        {
                            $uplo_ty = "txt";
                        }
                    }else
                    {
                        $filename = $_FILES['file']['name'];
                        $ff = pathinfo($_FILES['file']['name']);
                        $ext = $ff['extension'];
                        $newname = 'mcq_ques_id'.$qid.'.'.$ext; 
                        $location = "../user_question_img/".$newname;
                        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
                        $imageFileType = strtolower($imageFileType);
                        $valid_extensions = array("jpg","jpeg","png");
                        $response = 0;
                        if(in_array(strtolower($imageFileType), $valid_extensions)) {
                            if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
                                $response = $location;
                            }
                        }
                        $ques = $response;
                        $uplo_ty = "img";
                    }
                    $expla = $_POST['expla'];
                    $opt_id = 1;
                    $cho_default = ['c1','c2','c3','c4','c5','c6','c7','c8','c9','c10']; 
                    for($i=0; $i < $_POST['submit_2']; $i++)
                    {
                        if(isset($_POST[$cho_default[$i]]))
                        {
                            if('crt' == $_POST[$cho_default[$i]])
                            {
                                $cho = "crt";
                            }
                        }else
                        {
                            $cho = '-';
                        }
                        $sql = "insert into ans_options (question_id,option_id,options,correct_flag) values (?,?,?,?)";
                        $res = $con->prepare($sql);
                        $res->execute([$qid,$opt_id,$_POST['opt'.$opt_id],$cho]);
                        $opt_id+=1;
                    }
                }else
                {
                    if(isset($_POST['fques']))
                    {
                        $ques = $_POST['fques'];
                        if(isset($_POST['iseqn']))
                        {
                            $uplo_ty = "eqn";
                        }else
                        {
                            $uplo_ty = "txt";
                        }
                    }else
                    {
                        $filename = $_FILES['fib_ques']['name'];
                        $ff = pathinfo($_FILES['fib_ques']['name']);
                        $ext = $ff['extension'];
                        $newname = 'fib_ques_id'.$qid.'.'.$ext; 
                        $location = "../user_question_img/".$newname;
                        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
                        $imageFileType = strtolower($imageFileType);
                        $valid_extensions = array("jpg","jpeg","png");
                        $response = 0;
                        if(in_array(strtolower($imageFileType), $valid_extensions)) {
                            if(move_uploaded_file($_FILES['fib_ques']['tmp_name'],$location)){
                                $response = $location;
                            }
                        }
                        $ques = $response;
                        $uplo_ty = "img";
                    }
                    $opt_id = 1;
                    $cho = "crt";
                    $expla = $_POST['fexpla'];
                    $sql = "insert into ans_options (question_id,option_id,options,correct_flag) values (?,?,?,?)";
                    $res = $con->prepare($sql);
                    $res->execute([$qid,$opt_id,$_POST['fibans'],$cho]);
                }
                $status = "pending";
                $sql = "insert into questions_tb1 (question_id,concept_id,ques_type,question,explanation,ques_status,uplo_ques_type,created_by,created_date,updated_by,updated_date) values (?,?,?,?,?,?,?,?,?,?,?)";
                $res = $con->prepare($sql);
                $res->execute([$qid,$cid,$qtype,$ques,$expla,$status,$uplo_ty,$_SESSION['username'],$date,$_SESSION['username'],$date]);
                if($res){
                    echo "<script>alert('Data Added SuccessFully');</script>";
                }else
                {
                    echo "<script>alert('Data Error')</script>";
                }
                header("Refresh:0");
            }
            catch(PDOException $er)
            {
                echo "Error : ".$er->getMessage();
            }
        }
        else
        {
            echo "<script>alert('Error - Not Accessible , Please Contact Developer - rj - 9791658092')</script>";   
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylesheets/page_ques.css" type="text/css">
    <script src="../lib/jquery-3.6.0.js"></script>
    <link rel="icon" href="../images/l2.png" id="dark-scheme-icon">
    <link rel="icon" href="../images/ll3.png" id="light-scheme-icon">
    <script src="../scripts/page_ques.js" type="text/javascript"></script>
    <link href="../stylesheets/tryslide.css" type="text/css" rel="stylesheet">
    <script type="module" src="eqn_helper.js"></script>
    <style>
        #fileuplo1,#ques_img_but,#ques_uplo_fib_but,#del_uplo_fib,.sizereducer,#ins,#eqbut1,#eqbut2,#view1,#view2,#renopt,#renopt2{
            font-family: inherit;
            font-size: 18px;
            padding: 10px;
            width: 190px;
            cursor: pointer;
        }
        #img_path,#path_img_fib{
            padding: 11px;
            font-size:18px;
            border:1px solid black;
            width: 50%;
            font-family:inherit;
            border-right:0px;
        }
        #equ{
            display: none;
            border: 2px solid black;
            width: 70%;
            font-size: 20px;
            position: absolute;
            background-color: white;
            top:200px;
            margin-left: 200px;
            margin-right: 100px;
            text-align: center;
        }
        .stop-scrolling {
            height: 100%;
            overflow: hidden;
        }
        #eqs1,#eqs2{
            border:2px double black;
            width: 100%;
            padding: 30px 0px;
            display: none;
        }
    </style>
    <title>Question Entry - 1</title>
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
            <div class="d2"><a href="page_ques" class="l2 active">QUES-ENTRY</a></div>
            <div class="d3"><a href="page_show_ques" class="l3">QUES-EDIT</a></div>
            <div class="d4"><a href="print_page" class="l4">QUES-PRINT</a></div>
            <div class="d5" id="aaa" style="display: none;"><a href="" class="l5"></a></div>
            <div class="d6"><a href="img_helper" class="l6" target="_blank">RESIZER</a></div>
            <div class="d7"><a href="help" class="l6" style="cursor:help;">HELP </a></div>
        </div>
    </div><br><br><br>
    <div id="full">
    <header>
        <h1 align="center">Question Entry Form</h1>
    </header><br>
    <div id="getdata1">
        <form>
        <table align="center">
            <tr>
                <td><label for="syl">Syllabus</label></td><td><select name="syl" id="loadsyl" title="Select Syllabus" onchange="opendis1(this,'loadcls',0);">
                    <option disabled selected>--- Select Syllabus ---</option>
                    <option value="samacheer">Samacheer</option>
                    <option value="CBSE">CBSE</option>
                    <?php 
                        /*require 'helper';
                        $ll = load1();
                        foreach($ll as $l)
                        {
                            echo "<option value='".$l['subject']."'>".$l['subject']."</option>";
                        }*/
                    ?>
                </select></td>
                <td><label for="cls">Class</label></td><td><select name="cls" id="loadcls" title="Select Class" onchange="opendis1(this,'loadsub',1);" disabled>
                    <option disabled selected>--- Select Class ---</option>
                    
                </select></td>
                <td><label for="sub">Subject</label></td>
                <td><select name="sub" id="loadsub" title="Select Subject" onchange="opendis1(this,'loadchap',2)" disabled>
                    <option disabled selected>--- Select Subject ---</option>
                </select></td>
            </tr>
            <tr>
                <td><label for="chap">Chapter</label></td><td><select name="chap" id="loadchap" title="Select Chapter" onchange="opendis1(this,'loadtopic',3)" disabled>
                    <option disabled selected>--- Select Chapter ---</option>
                </select></td>
                <td><label for="topic">Topic</label></td><td><select name="topic" id="loadtopic" title="Select Topic" onchange="opendis1(this,'loadconc',4)" disabled>
                    <option disabled selected>--- Select Topic ---</option>
                </select></td>
                <td><label for="conc" onclick="sub1()">Concept</label></td><td><select name="conc" id="loadconc" title="Select Concept" onchange="opendis1(this,'mcq',5)" disabled>
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
                <td><input type="radio" id="mcq" value="mcq" name="qtype" title="Insert MCQ Questions.." onclick="showfill(0)" disabled> MCQ's</td>
                <td><input type="radio" id="fib" value="fib" name="qtype" title="Insert Fill int the Questions.." onclick="showfill(1)" disabled> Fill in the blanks</td>
            </tr>
        </table>
    </div><br>
    <form id="f1" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
        <div id="nothing" style="text-align: center;">
            <img src="../images/nothing.png" height="200px" width="200px" alt="Please Select Required Options" title="Please Select Above options to view in Details" style="pointer-events: none;margin-top: -5px;">
        </div>
        <div id="openmcq">
            <h1 align="center">MCQ Type Questions</h1><a href="img_helper" target="_blank"><button class="sizereducer" style="margin-top:-100px;float: right;" type="button">Reduce Dimensions <br>[&lt; 500 x 500]</button></a>
                <label for="ques">Question : </label><br>
                <textarea name="ques" id="taa" placeholder="Enter MCQ's Questions...." autocomplete="off" required></textarea>
                <div align="center"><span>Equation Question</span><br><input type="checkbox" name="iseqn" title="Select ,If Equation Question is Entered.." id="isequation1" onclick="openeqbut('eqbut1','view1','taa','eqs1','mcq')">
                <button type="button" onclick="openequ('taa')" id="eqbut1" disabled>Insert Equation</button>
                    <button id="view1" type="button" disabled>Mathify Question</button></div><br>
                <div id="eqs1"><span id="equation_show1"></span></div>

                <div  align="center"><img src="../images/immg.png" height="200px" width="200px" title="Select Image to Load Preview" alt="Preview Image" id="img"></div>
                <div  align="center"><img src="../images/immg.png" height="200px" width="200px" title="Select Image to Load Preview" alt="Preview Image" style="display: none;" id="errim"></div>
                
                <br><input id="img_path" disabled placeholder="Select File !!!!"><input type="button" value="upload file" id="fileuplo1" onclick="document.querySelector('.ques_img').click();">
                <input type="file" title="File MCQ" class="ques_img" id="file" name="file" accept="image/*" style="display: none;"><button type="button" onclick="delimg()" id="ques_img_but">Delete</button>
                <table id="choice">
                    <tr>
                        <td>option (a)</td>
                        <td><input type="text" title="Option-1" name="opt1" autocomplete="off" required id="opt1"></td>
                        <td><input type="checkbox" title="Select if entered option is correct" value="crt" name="c1"></td>
                        <td><span id="eopt1"></span></td>
                    </tr>
                    <tr>
                        <td>option (b)</td>
                        <td><input type="text" title="Option-2" name="opt2" autocomplete="off" required id="opt2"></td>
                        <td><input type="checkbox" title="Select if entered option is correct" value="crt" name="c2"></td>
                        <td><span id="eopt2"></span></td>
                    </tr>
                    <tr>
                        <td>option (c)</td>
                        <td><input type="text" title="Option-3" name="opt3" autocomplete="off" required id="opt3"></td>
                        <td><input type="checkbox" title="Select if entered option is correct" value="crt" name="c3"></td>
                        <td><span id="eopt3"></span></td>
                    </tr>
                    <tr>
                        <td>option (d)</td>
                        <td><input type="text" title="Option-4" name="opt4" autocomplete="off" required id="opt4"></td>
                        <td><input type="checkbox" title="Select if entered option is correct" value="crt" name="c4"></td>
                        <td><span id="eopt4"></span></td>
                    </tr>
                </table>
                <span onclick="addopt()" style="color: blue;cursor: pointer;">+ Add Choice</span>&emsp;
                <span onclick="remopt()" style="color: Red;cursor: pointer;">- Remove Choice</span>
                <button type="button" id="renopt" style="display: none;">Mathify Options</button>
                <br><label for="expla">Explanation : </label><br>
                <textarea name="expla"  placeholder="Enter Explanation for this question....." required autocomplete="off"></textarea>
                <br><br><div align="right" id="lasbut"><button type="submit" name="submit_2" id="submcq" value=4>Save &amp; Next</button>&emsp;<button type="button"  name="rr" onclick="resetform()">Clear</button>&emsp;<button type="button" onclick="home()">Cancel</button></div>
        </div>
    </form>
    <form id="f2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
        <div id="openfillups">
            <h1 align="center">Fill In the Blanks Type Questions</h1><a href="img_helper" target="_blank"><button class="sizereducer" style="margin-top:-100px;float: right;" type="button">Reduce Dimensions <br>[&lt; 500 x 500]</button></a>
                <label for="fques">Question : </label><br>
                <textarea name="fques"  placeholder="Enter Questions...." autocomplete="off" required id="taa2"></textarea>
                <div align="center"><span>Equation Question</span><br><input type="checkbox" title="Select ,If Equation Question is Entered.." name="iseqn" id="isequation2" onclick="openeqbut('eqbut2','view2','taa2','eqs2','fib')">
                <button type="button" onclick="openequ('taa2')" id="eqbut2" disabled>Insert Equation</button>
                <button id="view2" type="button" disabled>Mathify Question</button></div><br><br>
                <div id="eqs2"><span id="equation_show2"></span></div>

                <div  align="center"><img src="../images/immg.png" height="200px" title="Select Image to Load Preview" alt="Preview Image" width="200px" id="img2"></div>
                <div  align="center"><img src="../images/immg.png" height="200px" title="Select Image to Load Preview" alt="Preview Image" width="200px" style="display: none;" id="errim2"></div><br>
                
                <input type="file" title="File" name="fib_ques" id="ques_img_fib" accept="image/*" style="display: none;"><input placeholder="Select File !!!!" disabled id="path_img_fib" style="width: 50%;"><input type="button" value="Upload File" id="ques_uplo_fib_but" onclick="document.getElementById('ques_img_fib').click()">
                &emsp;<input type="button" value="Delete" id="del_uplo_fib" onclick="delimg2();">
                

                <br><label for="fibans">Answer : </label><br>
                <input type="text" title="Enter Only Correct Answer.." name="fibans" placeholder="Enter Correct Answer" autocomplete="off" required id="fibans">&nbsp;<span id="efibans"></span><br><br><button type="button" id="renopt2" style="display: none;">Mathify Answer</button>
                <br><label for="fexpla">Explanation : </label><br>
                <textarea name="fexpla" placeholder="Enter Explanation for this question....." required autocomplete="off"></textarea>
                <br><br><div align="right" id="lasbut2"><button type="submit" name="submit_2" value='2'>Save &amp; Next</button>&emsp;<button type="button" name="rr" onclick="resetform()">Clear</button>&emsp;<button type="button" onclick="home()">Cancel</button></div>
        </div>
    </form></div>
    <div id="equ">
    <span onclick="cloequ()" style="float: right;font-size:30px;cursor:pointer">✖</span>
    <br><br>Enter Equation : <div id="mf" style="width: 50%;border : 2px solid black;font-size:18px;display:inline-block;"></div>
    <br><br><div align="center"><button type="button" id="ins" onclick="ins(this)">Insert</button></div>
    <br><input type="text" title="Sample None" id="out" style="display: none;">
    </div>
    <script type="module">
        
        import makeMathField from "../lib/mathlive-master/mathlive.min.js";
        makeMathField.makeMathField(document.getElementById('mf'),  {
        virtualKeyboardMode: "onfocus",
        virtualKeyboards: 'numeric symbols functions roman greek',
        onContentDidChange: (mf) => {
                const latex = mf.$text();
                document.getElementById('out').value = latex;
            }
        });
    </script>
    <script>
        function ins(i)
        {
            $('body').removeClass('stop-scrolling');
            document.getElementById('full').style.pointerEvents="all";
            var lval = document.getElementById('out').value;
            var bval = document.getElementById(i.value).value;
            document.getElementById(i.value).value = bval + "$"+lval+"$";
            document.getElementById('out').value="";
            document.getElementById('equ').style.display="none";
        }
        function cloequ()
        {
            $('body').removeClass ('stop-scrolling');
            document.getElementById('full').style.pointerEvents="all";
            document.getElementById('equ').style.display="none";
        }
        var change = 0;
        <?php
            function varr($i)
            {
                $vv = ['syl','cls','sub','chap','topic','concept','qtype'];
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
                data: 'logout=page_entry'
            })
        })
        /*$(document).ready(function()
        {
            $(window).on("beforeunload",function(){
                return confirm('Do You really want to close?');
            });
        });
        window.onbeforeunload = function(event)
        {
            return "please";
        };*/
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


