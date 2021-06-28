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
                $qid = $_POST['qqqid'];
                $qtype = $_SESSION['qtype1'];
                if($qtype == "mcq")
                {
                    if(isset($_POST['ques']))
                    {
                        $ques = $_POST['ques'];
                        $uplo_ty = "txt";
                    }else
                    {
                        if(isset($_POST['file']))
                        {
                            $sql = "select * from questions_tb1 where question_id = ?";
                            $res = $con->prepare($sql);
                            $res->execute([$qid]);
                            $pr = $res ->fetch();
                            if($pr['uplo_ques_type'] == "img")
                            {
                                unlink($pr['question']);
                            }
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
                        }else
                        {
                            $ques = $_POST['default_img1'];
                        }
                        $uplo_ty = "img";
                    }
                    $expla = $_POST['expla'];
                    $opt_id = 1;
                    $cho_default = ['c1','c2','c3','c4','c5','c6','c7','c8','c9','c10']; 
                    $sql = "delete from ans_options where question_id = ?";
                    $res = $con->prepare($sql);
                    $res->execute([$qid]);
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
                        $sql = "insert into ans_options (question_id,option_id,options,correct_flag) values(?,?,?,?)";
                        $res = $con->prepare($sql);
                        $res->execute([$qid,$opt_id,$_POST['opt'.$opt_id],$cho]);
                        $opt_id+=1;
                    }
                }else
                {
                    if(isset($_POST['fques']))
                    {
                        $ques = $_POST['fques'];
                        $uplo_ty = "txt";
                    }else
                    {
                        if(isset($_POST['fib_ques']))
                        {
                            $sql = "select * from questions_tb1 where question_id = ?";
                            $res = $con->prepare($sql);
                            $res->execute([$qid]);
                            $pr = $res ->fetch();
                            if($pr['uplo_ques_type'] == "img")
                            {
                                unlink($pr['question']);
                            }
                            $filename = $_FILES['fib_ques']['name'];
                            $ff = pathinfo($_FILES['fib_ques']['name']);
                            $ext = $ff['extension'];
                            $newname = 'mcq_ques_id'.$qid.'.'.$ext; 
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
                        }else
                        {
                            $ques = $_POST['default_img2'];
                        }
                        $uplo_ty = "img";
                    }
                    $opt_id = 1;
                    $cho = "crt";
                    $expla = $_POST['fexpla'];
                    $sql = "update ans_options set option_id = ?,options = ?,correct_flag = ? where question_id= ?";
                    $res = $con->prepare($sql);
                    $res->execute([$opt_id,$_POST['fibans'],$cho,$qid]);
                }
                $sql = "update questions_tb1 set question = ?,explanation = ?,uplo_ques_type = ?,updated_by = ?,updated_date = ? where question_id = ?";
                $res = $con->prepare($sql);
                $res->execute([$ques,$expla,$uplo_ty,$_SESSION['username'],$date,$qid]);
                if($res){
                    echo "<script>alert('Data Updated SuccessFully');</script>";
                }else
                {
                    echo "<script>alert('Data Error')</script>";
                }
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
    <link rel="stylesheet" href="../stylesheets/page_show_ques.css" type="text/css">
    <link rel="icon" href="../images/l2.png" id="dark-scheme-icon">
    <link rel="icon" href="../images/ll3.png" id="light-scheme-icon">
    <script src="../lib/jquery-3.6.0.js"></script>
    <script src="../scripts/page_show_ques.js" type="text/javascript"></script>
    <link href="../stylesheets/tryslide.css" type="text/css" rel="stylesheet">
    <title>Question Edit</title>
    <style>
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
            <div class="d3"><a href="page_show_ques" class="l3 active">QUES-EDIT</a></div>
            <div class="d4"><a href="print_page" class="l4">QUES-PRINT</a></div>
            <div class="d5" id="aaa" style="display: none;"><a href="" class="l5"></a></div>
            <div class="d6"><a href="img_helper" class="l6" target="_blank">RESIZER</a></div>
            <div class="d7"><a href="help" class="l7" style="cursor:help;">HELP </a></div>
        </div>
    </div><br><br><br>
    <div id="full">
    <header>
        <h1 align="center">Question Edit Form</h1>
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
    <form id="f1" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
        <div id="nothing" style="text-align: center;">
            <img src="../images/edit1.png" title="" alt="Please Select Options" title="Please Select Above options to view in Details" height="200px" width="200px" style="pointer-events: none;margin-top: -5px;">
        </div>
        <div id="openmcq" style="position:static;overflow:scroll;height:500px;">
        <span style="float: right;cursor:pointer;" onclick="clo()">✖</span>
            <h1 align="center">MCQ Type Questions</h1><a href="img_helper" target="_blank"><button class="sizereducer" style="margin-top:-100px;float: right;" type="button">Reduce Dimensions <br>[&lt; 500 x 500]</button></a>
                <label for="ques">Question : </label><br>
                <textarea name="ques" id="taa" placeholder="Enter MCQ's Questions...." autocomplete="off" required></textarea>
                <div align="center"><span>Equation Question</span><br><input type="checkbox" title="Select ,If Equation Question is Entered.." name="iseqn" id="isequation1" onclick="openeqbut('eqbut1','view1','taa','eqs1','mcq',1)">
                <button type="button" onclick="openequ('taa')" id="eqbut1" disabled>Insert Equation</button>
                    <button id="view1" type="button" disabled>Mathify Question</button></div><br>
                <div id="eqs1"><span id="equation_show1"></span></div>

                <div  align="center"><img src="../images/immg.png" alt="Preview Image" title="Select Image to Load Preview" style='pointer-events:none' height="200px" width="200px" id="img"></div>
                
                <br><input id="img_path" disabled placeholder="Select File !!!!"><input type="button" value="upload file" id="fileuplo1" onclick="document.querySelector('.ques_img').click();">
                <input type="file" title="File" class="ques_img" id="file" name="file" style="display: none;"><button type="button" onclick="delimg()" id="ques_img_but">Delete</button>

                <input name="default_img1" id="defa1" title="User_unreg" style="display: none;">
                
                
                <input type="text" title="User_unreg" name="qqqid" id="mquestion_id" value="0" style="display: none;">
                <table id="choice">
                    <tr>
                        <td>option (a)</td>
                        <td><input type="text" title="Option-1" id="option1" name="opt1" autocomplete="off" required></td>
                        <td><input type="checkbox" title="Select if entered option is correct" id="choice1" value="crt" name="c1"></td>
                        <td><span id="eopt1"></span></td>
                    </tr>
                    <tr>
                        <td>option (b)</td>
                        <td><input type="text" title="Option-2" id="option2" name="opt2" autocomplete="off" required></td>
                        <td><input type="checkbox" title="Select if entered option is correct" id="choice2" value="crt" name="c2"></td>
                        <td><span id="eopt2"></span></td>
                    </tr>
                </table>
                <div style="text-align:right" id="stt">
                    <label for="statt">Status : </label>
                    <select name="statt" title="Select Question Status" id="mstatus" onchange="chcolo(this,1)">
                        <option value="approved" style="color: green;">Approved</option>
                        <option value="pending" style="color: red;">Pending</option>
                        <option value="rework" style="color: blue;">Rework</option>
                    </select>
                </div>
                <span onclick="addopt()" style="color: blue;cursor: pointer;">+ Add Choice</span>&emsp;
                <span onclick="remopt()" style="color: Red;cursor: pointer;">- Remove Choice</span>
                <button type="button" id="renopt" style="display: none;">Mathify Options</button>
                <br><label for="expla">Explanation : </label><br>
                <textarea name="expla" id="mexplanation"  placeholder="Enter Explanation for this question....." required autocomplete="off"></textarea>
                <br><br><div align="right" id="lasbut"><button type="submit" name="submit_2" id="submcq" value=2>Save</button>&emsp;<button type="button"  name="rr" onclick="resetform()">Clear</button>&emsp;<button type="button" onclick="clo()">Cancel Edit</button></div>
        </div>
    </form>
    <form id="f2" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
        <div id="openfillups" style="position:static;overflow:scroll;height:500px;">
            <span style="float: right;cursor:pointer" onclick="clo()">✖</span>
            <h1 align="center">Fill In the Blanks Type Questions</h1><a href="img_helper" target="_blank"><button class="sizereducer" style="margin-top:-100px;float: right;" type="button">Reduce Dimensions <br>[&lt; 500 x 500]</button></a>
                <label for="fques">Question : </label><br>
                <input type="text" name="qqqid" id="fquestion_id" title="User_unreg" value="0" style="display: none;">
                <textarea name="fques" id="taa2"  placeholder="Enter Questions...." autocomplete="off" required></textarea><br>
                <div align="center"><span>Equation Question</span><br><input type="checkbox" title="Select ,If Equation Question is Entered.." name="iseqn" id="isequation2" onclick="openeqbut('eqbut2','view2','taa2','eqs2','fib',1)">
                <button type="button" onclick="openequ('taa2')" id="eqbut2" disabled>Insert Equation</button>
                <button id="view2" type="button" disabled>Mathify Question</button></div><br><br>
                <div id="eqs2"><span id="equation_show2"></span></div>

                <div  align="center"><img src="../images/immg.png" style='pointer-events:none'title="Select Image to Load Preview" alt="Preview Image" height="200px" width="200px" id="img2"></div>
                <input name="default_img2" title="User_unreg" id="defa2" style="display: none;">
                <input type="file" title="File" name="fib_ques" id="ques_img_fib" style="display: none;"><input placeholder="Select File !!!!" disabled id="path_img_fib" style="width: 50%;"><input type="button" value="Upload File" id="ques_uplo_fib_but" onclick="document.getElementById('ques_img_fib').click()">
                &emsp;<input type="button" value="Delete" id="del_uplo_fib" onclick="delimg2();">

                
                <label for="fibans">Answer : </label><br>
                <input type="text" title="Enter Only Correct Answer.." id="fanswer" name="fibans" placeholder="Enter Correct Answer" autocomplete="off" required><span id="fib_show_eqn_ans"></span><br>
                <br><br><button type="button" id="renopt2" style="display: none;">Mathify Answer</button>
                <div style="float:right" id="fstt">
                    <label for="fstatt">Status : </label>
                    <select name="fstatt"title="Select Question Status" id="fstatus" onchange="chcolo(this,2)">
                        <option value="approved" style="color: green;">Approved</option>
                        <option value="pending" style="color: red;">Pending</option>
                        <option value="rework" style="color: blue;">Rework</option>
                    </select>
                </div>
                <br><label for="fexpla">Explanation : </label><br>
                <textarea name="fexpla" id="fexplanation"  placeholder="Enter Explanation for this question....." required autocomplete="off"></textarea>
                <br><br><div align="right" id="lasbut2"><button type="submit" name="submit_2" value='2'>Save</button>&emsp;<button type="button" name="rr" onclick="resetform()">Clear</button>&emsp;<button type="button" onclick="clo()">Cancel Edit</button></div>
        </div>
    </form>
    <div id="openshowall">
        <table id='show_all' style="border-collapse:collapse;font-family:inherit;font-size: 25px;" width="100%">
            
        </table>
    </div>
    <div style="display: none;">
        <textarea id="only_print" title="sample"></textarea>
        <button type="button" id="only_p_but">Sample</button>
        <textarea id="eqn_print_opt" title="sample"></textarea>
        <button type="button" id="opt_p_but">Sample option</button>
        <textarea id="eqn_print_exp" title="sample"></textarea>
        <button type="button" id="exp_p_but">Sample Exp</button>
        <math-field id='mff' title="sample"></math-field>
    </div>
</div>
<div id="equ">
    <span onclick="cloequ()" style="float: right;font-size:30px;cursor:pointer">✖</span>
    <br><br>Enter Equation : <div id="mf" style="width: 50%;border : 2px solid black;font-size:18px;display:inline-block;"></div>
    <br><br><div align="center"><button type="button" id="ins" onclick="ins(this)">Insert</button></div>
    <br><input type="text" title="User_unreg" id="out" style="display: none;">
    </div> 
    <script type="module" src="eqn_helper_show_ques.js"></script>   
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
                $vv = ['syl1','cls1','sub1','chap1','topic1','concept1','qtype1'];
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
                data: 'logout=page_edit'
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

        import {convertLatexToMarkup} from "../lib/mathlive-master/mathlive.min.js";
        document.querySelector('#only_p_but').addEventListener('click', (ev) => {
            var ran = document.getElementById('only_print').value;
            var iid = document.getElementById('only_p_but').value;
            document.getElementById(iid).innerHTML = "";
            var ada=0,sda;
            var mk =0;
            while(mk < ran.length)
            {
                var rjr = "";
                if(ran[mk] == "$")
                {
                    if(ada == 0)
                    {
                        ada = 1;
                    }
                }
                if(ada == 0)
                {
                    if(ran[mk] == "\n")
                    {
                        sda = "<br>";
                    }else
                    {
                        sda="";
                    }
                    var tex = document.getElementById(iid).innerHTML;
                    document.getElementById(iid).innerHTML = tex + ran[mk] + sda; 
                    mk+=1;
                }else
                {
                    var tex = document.getElementById(iid).innerHTML;
                    var mj=mk+1;
                    while(1)
                    {
                        if(ran[mj] == "$")
                        {
                            break;
                        }
                        rjr = rjr + ran[mj];
                        mj+=1;
                    }
                    document.getElementById(iid).innerHTML = tex + convertLatexToMarkup(rjr);
                    mk=(mj+1);
                    ada=0;
                }
            }
        });
        document.querySelector('#opt_p_but').addEventListener('click', (ev) => {
            var ran = document.getElementById('eqn_print_opt').value;
            var iid = document.getElementById('opt_p_but').value;
            document.getElementById(iid).innerHTML = "";
            var ada=0,sda;
            var mk =0;
            while(mk < ran.length)
            {
                var rjr = "";
                if(ran[mk] == "$")
                {
                    if(ada == 0)
                    {
                        ada = 1;
                    }
                }
                if(ada == 0)
                {
                    if(ran[mk] == "\n")
                    {
                        sda = "<br>";
                    }else
                    {
                        sda="";
                    }
                    var tex = document.getElementById(iid).innerHTML;
                    document.getElementById(iid).innerHTML = tex + ran[mk] + sda; 
                    mk+=1;
                }else
                {
                    var tex = document.getElementById(iid).innerHTML;
                    var mj=mk+1;
                    while(1)
                    {
                        if(ran[mj] == "$")
                        {
                            break;
                        }
                        rjr = rjr + ran[mj];
                        mj+=1;
                    }
                    document.getElementById(iid).innerHTML = tex + convertLatexToMarkup(rjr);
                    mk=(mj+1);
                    ada=0;
                }
            }
        });
        document.querySelector('#exp_p_but').addEventListener('click', (ev) => {
            var ran = document.getElementById('eqn_print_exp').value;
            var iid = document.getElementById('exp_p_but').value;
            document.getElementById(iid).innerHTML = "";
            var ada=0,sda;
            var mk =0;
            while(mk < ran.length)
            {
                var rjr = "";
                if(ran[mk] == "$")
                {
                    if(ada == 0)
                    {
                        ada = 1;
                    }
                }
                if(ada == 0)
                {
                    if(ran[mk] == "\n")
                    {
                        sda = "<br>";
                    }else
                    {
                        sda="";
                    }
                    var tex = document.getElementById(iid).innerHTML;
                    document.getElementById(iid).innerHTML = tex + ran[mk] + sda; 
                    mk+=1;
                }else
                {
                    var tex = document.getElementById(iid).innerHTML;
                    var mj=mk+1;
                    while(1)
                    {
                        if(ran[mj] == "$")
                        {
                            break;
                        }
                        rjr = rjr + ran[mj];
                        mj+=1;
                    }
                    document.getElementById(iid).innerHTML = tex + convertLatexToMarkup(rjr);
                    mk=(mj+1);
                    ada=0;
                }
            }
        });
    </script>
</body>
</html>


