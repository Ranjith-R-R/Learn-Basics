<?php
session_start();
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['chpass'])) {
        $givv =  strtolower($_POST['uname']);
        $olp = $_POST['olpass'];
        $npas = $_POST['npass'];
        $k = $_POST['key'];
        if ($k == "0101") {
            $sql = "SELECT * from user_ui where username=?";
            $res = $con->prepare($sql);
            $res->execute([$givv]);
            $pr = $res->fetch();
            $conti = true;
            if ($pr == null) {
                echo "<script>alert('Entered Username Not Exist');</script>";
                $conti = false;
            }
            if ($conti) {
                $dbpass = $pr["password"];
                if ($dbpass == $olp || $olp == "0101") {
                    if ($olp != $npas) {
                        $sql = "update user_ui set password = ? where user_id =?";
                        $res = $con->prepare($sql);
                        $res->execute([$npas, $pr['user_id']]);
                        echo "<script>alert('Your Password has been changed Successfully!!!');</script>";
                    } else {
                        echo "<script>alert('Your current Password and new password are same!!!!!');</script>";
                        header("Refresh:0");
                    }
                } else {
                    echo "<script>alert('Incorrect Old Password');</script>";
                    header("Refresh:0");
                }
            }
        } else {
            echo "<script>alert('Invalid Admin Key');</script>";
            header("Refresh:0");
        }
    }
    if (isset($_POST['nuname'])) {
        $uname = strtolower($_POST['nuname']);
        $password = $_POST['npass'];
        $repass = $_POST['repass'];
        $sql = "select * from user_ui where username = ?";
        $res = $con->prepare($sql);
        $res->execute([$uname]);
        $pr = $res->fetch();
        if ($res->rowCount() > 0) {
            echo "<script>alert('Username already exists');</script>";
            header("Refresh:0");
        } else {
            if ($password == $repass) {
                $sql = "select * from user_ui ORDER BY user_id DESC LIMIT 1";
                $res = $con->prepare($sql);
                $res->execute();
                $pr = $res->fetch();
                if ($pr) {
                    $uid = $pr["user_id"];
                    $uid += 1;
                } else {
                    $uid = 1;
                }
                $sql = "insert into user_ui(user_id,username,password,last_login,last_logout,last_accessed_page,user_type,user_browser) VALUES (?,?,?,now(),now(),?,?,?);";
                $res = $con->prepare($sql);
                $res->execute([$uid, $uname, $password, "logged_out","user",$user_browser]);
                echo "<script>alert('New User $uname created');</script>";
                header("Refresh:0");
            } else {
                echo "<script>alert('Password Mismatch');</script>";   
                header("Refresh:0");   
            }
        }
    }
    if (isset($_POST['duname']))
    {
        $uname = strtolower($_POST['duname']);
        $password = $_POST['dnpass'];
        $sql = "select * from user_ui where username = ?";
        $res = $con->prepare($sql);
        $res->execute([$uname]);
        $pr = $res->fetch();
        if($res->rowCount() > 0)
        {
            if($pr['user_type'] != "admin")
            {
                if ($pr['password'] == $password || $password == "0101") {
                    $sql = "delete from user_ui where username = ?";
                    $res = $con->prepare($sql);
                    $res->execute([$uname]);
                    echo "<script>alert('Username $uname deleted');</script>";
                }else
                {
                    echo "<script>alert('Incorrect Password !!!');</script>";
                    header("Refresh:0");
                }
            }else{
                echo "<script>alert('Admin Cannot be deleted !!!');</script>"; 
                header("Refresh:0");
            }
        }else
        {
            echo "<script>alert('Username $uname Not Exixts');</script>";
            header("Refresh:0");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../lib/jquery-3.6.0.js"></script>
    <link rel="icon" href="../images/l2.png" id="dark-scheme-icon">
    <link rel="icon" href="../images/ll3.png" id="light-scheme-icon">
    <link href="../stylesheets/tryslide.css" type="text/css" rel="stylesheet">
    <link href="../stylesheets/admin.css" type="text/css" rel="stylesheet">
    <script src="../scripts/admin.js"></script>
    <title>Admin - Control_Panel</title>
    <style>

    </style>
</head>

<body>
    <span id="mob-view"><span onclick="slide()" id="tick">&#x2630;</span>&emsp;<span>USER : <?php echo strtoupper($uuu); ?></span></span>
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
            <div class="d5" id="aaa" style="display: none;"><a href="" class="l5 active"></a></div>
            <div class="d6"><a href="img_helper" class="l6" target="_blank">RESIZER</a></div>
            <div class="d7"><a href="help" class="l7" style="cursor:help;">HELP </a></div>
        </div>
    </div><br><br><br>
    <div id="full">
        <div id="header">
            <span>Admin - Learn Basics</span>
            <span style="float: right;font-size:20px;margin-right:10px;">Admin : <?php echo strtoupper($_SESSION['username']); ?></span>
            <img src="../images/admin.png" height="100px" width="100px" style="float: left;margin-top:-30px;pointer-events:none;">
        </div><br>
        <div align="center">
            <button class="chbut" type="button" onclick="get_user_info()">Refresh Table User's</button>
        </div><br>
        <div>
            <table border="2px" width="100%" id="users_det" cellpadding="5" cellspacing="5">
            </table>
        </div><br>
        <div align='center'>
            <button class="chbut" type="button" onclick="getall()">Refresh Table Count</button>
        </div>
        <br>
        <table border="2px" width="100%" id="det" cellpadding="5" cellspacing="5">
        </table><br>
        <div align="center" id="butall">
            <button type="button" onclick="show_chg_pass()">Change Password</button>
            <button type="button" onclick="show_cre_user()">Create New User</button>
            <button type="button" onclick="show_del_user()">Delete User</button>
        </div>
    </div>
    <div class="show_dia" id="pass1">
        <span class="cross1" onclick="clo2()" style="float: right;font-size:30px;cursor:pointer;margin-right:2px;">✖</span>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" id="chg_form">
            <h1 style="font-variant: small-caps;text-align:center;">Change Password</h1>
            <table id="chpass">
                <tr>
                    <td><label for="uname">User Name</label></td>
                    <td><input type="text" name="uname" autocomplete="off" required></td>
                </tr>
                <tr>
                    <td><label for="olpass">Old Password</label></td>
                    <td><input type="password" name="olpass" autocomplete="off" required></td>
                </tr>
                <tr>
                    <td><label for="npass">New Password</label></td>
                    <td><input type="password" name="npass" autocomplete="off" required></td>
                </tr>
                <tr>
                    <td><label for="key">Enter Admin Key</label></td>
                    <td><input type="password" name="key" autocomplete="off" required></td>
                </tr>
            </table><br>
            <button type="submit" class="chbut" name="chpass" value="0">Change</button>
        </form><br>
        <form action="for_user" method="POST">
            <button type="submit" class="chbut" name="forpass" value="1">Forget Password</button>
        </form>
    </div>
    <div style="display: none;" class="show_dia" id="pass2">
        <span class="cross1" onclick="clo2()" style="float: right;font-size:30px;cursor:pointer;margin-right:2px;">✖</span>
        <h2 align="center">Create User's</h2>
        <form id="cre_form" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <table style="width: 100%;">
                <tr>
                    <td><label for="adm_key">Admin-Key</label></td>
                    <td><input type="password" name="adm_key" id="ad_kk" required>&emsp;<button type="button" onclick="verify('ad_kk');">Verify</button></td>
                </tr>
                <tr>
                    <td><label for="nuname">New UserName</label></td>
                    <td><input type="text" name="nuname" class="dis_all" autocomplete="off" disabled required></td>
                </tr>
                <tr>
                    <td><label for="npass">Password</label></td>
                    <td><input type="password" name="npass" class="dis_all" autocomplete="off" disabled required></td>
                </tr>
                <tr>
                    <td><label for="repass">Confirm Password</label></td>
                    <td><input type="password" name="repass" class="dis_all" autocomplete="off" disabled required></td>
                </tr>
            </table><br>
            <div align="center"><button type="submit" class="dis_all" disabled>Create</button></div>
        </form>
    </div>
    <div style="display: none;" class="show_dia" id="pass3">
        <span class="cross1" onclick="clo2()" style="float: right;font-size:30px;cursor:pointer;margin-right:2px;">✖</span>
        <h2 align="center">Delete User's</h2>
        <form id="del_form" action="<?php htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
            <table style="width: 100%;">
                <tr>
                    <td><label for="adm_key1">Admin-Key</label></td>
                    <td><input type="password" name="adm_key1" id="ad_kk1" required>&emsp;<button type="button" onclick="verify('ad_kk1');">Verify</button></td>
                </tr>
                <tr>
                    <td><label for="duname">New UserName</label></td>
                    <td><input type="text" name="duname" class="dis_all" autocomplete="off" disabled required></td>
                </tr>
                <tr>
                    <td><label for="dnpass">Password</label></td>
                    <td><input type="password" name="dnpass" class="dis_all" autocomplete="off" disabled required></td>
                </tr>
            </table><br>
            <div align="center"><button type="button" class="dis_all" onclick="confirmclick('del_users_butt');" disabled>Delete</button><button type="submit" id="del_users_butt" style="display: none;"></button></div>
        </form>
    </div>
    <script>
        function confirmclick(i)
        {
            var con = confirm("Are you Sure You want to delete this user !!!!!");
            if(con == 1)
            {
                document.getElementById(i).click();
            }else
            {
                alert("Deletion Aborted");
            }
        }
        function aaa() {
            if (<?php echo chkuser($admin) ?> == 1) {
                document.getElementById('aaa').style.display = "inline-block";
                document.querySelector(".l5").href = "<?php echo $hr ?>";
                document.querySelector(".l5").textContent = "<?php echo $na ?>";
            }
        }
        aaa();
    </script>
</body>

</html>