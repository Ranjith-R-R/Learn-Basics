<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/l2.png" id="dark-scheme-icon">
    <link rel="icon" href="images/ll3.png" id="light-scheme-icon">
    <script src="lib/jquery-3.6.0.js"></script>
    <title>Learn Basics - Login</title>
    <style>
        body {
            background-image: url('images/nigh.jpg');
        }
        
        label {
            font-size: 20px;
            margin-left: 15px;
            margin-top: 10px;
        }
        @media only screen and (min-width: 1040px)
        {
            #f1{
                background: white;
                border: 5px ridge;
                padding: 10px;
                width: 50%;
                margin-left: 25%;
                text-align: center;
            }
            #f1 input{
                width: 300px;
                font-family: Cambria;
                font-size: 16px;
                border: 0px;
                outline: none;
                font-variant: small-caps;
            }
            #t1{
                text-align: center;
                margin-left: 6%;
            }
        }
        @media only screen and (max-width: 1040px)
        {
            #f1{
                background: white;
                border: 5px ridge;
                padding: 10px;
                width: 93%;
                text-align: center;
            }
            #f1 input{
            width: 200px;
            font-family: Cambria;
            font-size: 16px;
            border: 0px;
            outline: none;
            font-variant: small-caps;
        }
        }
        fieldset{
            width: fit-content;           
        }
        @keyframes fade-in {
            from {
                opacity: 0.2;
            }
            to {
                opacity: 1;
            }
        }
        legend
        {
            color: blue;
            display: none;
            animation: fade-in 2s;
        }
        #but1{
            margin-bottom:10px;
            margin-left: 10%;
            font-size:20px;
            width: 200px;
            font-family: inherit;
            cursor: pointer;
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

        if(isset($_SESSION['username']))
        {
            header("Location:index");
        }
    
        if($_SERVER["REQUEST_METHOD"] == "POST")
        {
            $givv =  strtolower($_POST['uname']);
            $con = new PDO($str,$user,$pass);
            $sql = "SELECT * from user_ui where username=?";
        
            $res = $con->prepare($sql);
            $res->execute([$givv]);
            
            $pr = $res->fetch();
            $conti = true;
            if($pr == null)
            {
                echo "<script>alert('Entered Username Not Exist');</script>";
                $conti = false;
            }
            if($conti)
            {
                $dbpass = $pr["password"];
                $pass = $_POST['pass'];
                if($dbpass == $pass)
                {
                    $sql = "update user_ui set last_login= now() where user_id =?";
                    $res = $con->prepare($sql);
                    $res->execute([$pr['user_id']]);
                    $_SESSION['username'] = $givv;
                    header("Location: index");
                    exit();
                }else
                {
                    echo "<script>alert('Password Do Not Match');</script>";
                }
            }
        }
    ?>
    <div align="center"><img src="images/l2.png" height="250px" width="250px"></div>
    <br><br>
    <div id="f1">
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
        <table width="100%" height="130px" id="t1">
            <tr>    
                <td><label for="uname" >Username</label></td>
                <td><fieldset id="fs1">
                    <legend align="left" id="leg1">Username</legend>
                    <input type="text" name="uname" size=15 placeholder="username" maxlength=15 id="na" onfocus="legend(this,'leg1','fs1')" autocomplete="off" required>
                </fieldset></td>
            </tr>
            <tr>
                <td><label for="uname">Password</label></td>
                <td><fieldset id="fs2">
                    <legend align="left" id="leg2">Password</legend>
                    <input type="password" name="pass" placeholder="password" onfocus="legend(this,'leg2','fs2')"autocomplete="off" required>
                </fieldset></td>
            </tr>
        </table>
        <br>
        <button type="submit" name="login" id="but1" style="cursor: pointer;">Next</button>
        </form>
    </div>
    <script>
        function legend(i,ii,iii)
        {
            document.getElementById(ii).style.display='block';
            i.placeholder="";    
            document.getElementById(iii).style.borderColor="skyblue";
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
    </script>
</body>
</html>