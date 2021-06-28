<?php
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LB Forget Password</title>
</head>
<body>
    <form>
    <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
    <h1 style="font-variant: small-caps;text-align:center;">Change Password</h1>
    <table id="chpass">
        <tr>
            <td><label for="uname">User Name</label></td>
            <td><input type="text" name="uname" autocomplete="off" required></td>
        </tr>
        <tr>
            <td><label for="key">Enter Admin Key</label></td>
            <td><input type="password" name="key" autocomplete="off" required></td>
        </tr>
        <tr>
            <td><label for="npass">New Password</label></td>
            <td><input type="password" name="npass" autocomplete="off" required></td>
        </tr>
    </table><br>
    <button type="submit" class="chbut" name="chpass" value="0">Change</button>
    </form>
</body>
</html>