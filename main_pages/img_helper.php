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
?>
<!DOCTYPE html>
<html>
<head>
  <meta content="text/html; charset=UTF-8" http-equiv="Content-Type" />
  <link rel="icon" href="../images/l2.png" id="dark-scheme-icon">
    <link rel="icon" href="../images/ll3.png" id="light-scheme-icon">
  <title>LB - Image Dimension Resizer</title>
  <style>
      body{
        font-family: Cambria;
        font-size: 20px;
      }
      .fakebut{
        font-family: inherit;
        font-size: 18px;
        padding: 5px;
        height: 45px;
        width: 150px;
        cursor: pointer;
      }
      .butts{
        font-family: inherit;
        font-size: 18px;
        padding: 5px;
        width: 150px;
        cursor: pointer;
      }
      #path_img{
        width: 300px;
        padding: 5px;
        font-family: inherit;
        font-size: 18px;
        height: 31px;
        border-radius: 5px;
      }
      #tab1 input{
        font-size: 18px;
        font-family: Cambria;
        width: 200px;
        padding: 5px;
      }
  </style>
</head>
<body onload="loadImageFile();">
  <div style="border: 2px ridge black;padding:6px;font-variant:small-caps;">
    <img src="../images/resize.png" height="100px" width="100px" style="float: left;">
    <span style="float: right;margin-top: 25px;">User : <?php echo $uuu; ?></span>
    <h2 align="center">Image Dimension Resizer</h2>
  </div><br>
  <form name="uploadForm">
      <table id="tab1">     
        <tr>
          <td>Width</td><td> : <input type="number" id="wi" placeholder="in Pixels(px)" value=100></td>
        </tr>
        <tr>
          <td>Height</td><td> : <input type="number" id="hi" placeholder="in Pixels(px)" value=100></td>
        </tr>
      </table><br>
        <button type="button" class="butts" onclick="chkdimen()">Check Dimension</button>
        <span id="expimg">Dimensions : 0 X 0</span><br>
        <br>Select Image - <br><input id="upload-Image" type="file" onchange="loadImageFile();" style="display: none;" />
        <div align="center"><input id="path_img" placeholder="No Image Selected" disabled><button type="button" disabled onclick="document.getElementById('upload-Image').click()" class="fakebut">Choose File</button>
        <button type="button" class="fakebut" onclick="delimg()">Delete Selection</button><br></div>
        Original Img - <br><div align="center"><img id="original-Img" /></div><br>
        Compressed Img - <br><div align="center"><img id="upload-Preview" /></div><br>
        <a href="" id="upload-Preview2" download="" style="display: none;"><button type="button" class="butts">Download Compressed Image</button></a>
  </form>
  <script type="text/javascript">
    var givenwidth,givenheight,filename;
    var fileReader = new FileReader();
    var filterType = /^(?:image\/bmp|image\/cis\-cod|image\/gif|image\/ief|image\/jpeg|image\/jpeg|image\/jpeg|image\/pipeg|image\/png|image\/svg\+xml|image\/tiff|image\/x\-cmu\-raster|image\/x\-cmx|image\/x\-icon|image\/x\-portable\-anymap|image\/x\-portable\-bitmap|image\/x\-portable\-graymap|image\/x\-portable\-pixmap|image\/x\-rgb|image\/x\-xbitmap|image\/x\-xpixmap|image\/x\-xwindowdump)$/i;
    fileReader.onload = function(event) {
      var image = new Image();
      image.onload = function() {
        document.getElementById("original-Img").src = image.src;
        var canvas = document.createElement("canvas");
        var context = canvas.getContext("2d");
        canvas.width = givenwidth;
        canvas.height = givenheight;
        context.drawImage(image,0,0,image.width,image.height,0,0,canvas.width,canvas.height);
        document.getElementById("upload-Preview").src = canvas.toDataURL();
        document.getElementById("upload-Preview2").style.display="block";
        document.getElementById("upload-Preview2").href = canvas.toDataURL();
        document.getElementById("upload-Preview2").download = "Compressed(" + givenwidth + "x"+givenheight+")_" + filename;
      }
      image.src = event.target.result;
    };
    function ntcompat()
    {
          alert("Dimensions are not Compatibe");
          document.querySelector(".fakebut").disabled = true;
          document.getElementById('expimg').textContent ="Dimensions : "+ givenwidth + " x " + givenheight + "(Not Compatible)";
          givenheight = 100;
          givenwidth = 100;
    }
    function chkdimen()
    {
      givenwidth = document.getElementById('wi').value;
      givenheight = document.getElementById('hi').value;
      if(givenheight != "" && givenwidth != "")
      {
        if(givenheight <= 800 && givenheight >= 100)
        {
          if(givenwidth <= 800 && givenwidth >= 100)
          {
            document.querySelector(".fakebut").disabled = false;
            document.getElementById('expimg').textContent ="Dimensions : "+ givenwidth + " x " + givenheight;
          }else
          {
            ntcompat();
          }
        }else  
        {
          ntcompat();
        }
      }else
      {
        alert("Please Enter Dimensions");
      }
    }
    function delimg()
    {
      document.getElementById('upload-Image').value = "";
      document.getElementById("path_img").placeholder = "No Image Selected !!!";
     document.getElementById('original-Img').removeAttribute('src');
     document.getElementById('upload-Preview').removeAttribute('src');
     document.getElementById('upload-Preview2').style.display="none";
    }
    var loadImageFile = function() {
      var uploadImage = document.getElementById("upload-Image");
      if (uploadImage.files.length === 0) {
        return;
      }
      var uploadFile = document.getElementById("upload-Image").files[0];
      if (!filterType.test(uploadFile.type)) {
        alert("Please select a valid image.");
        return;
      }
      var fullPath = document.querySelector('#upload-Image').value;
      if (fullPath) {
          var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
          filename = fullPath.substring(startIndex);
          if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
              filename = filename.substring(1);
          }
          document.getElementById('path_img').placeholder = filename;
      }

      fileReader.readAsDataURL(uploadFile);
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