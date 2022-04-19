<?php session_start();
$loginuser=$_SESSION['username'];
if($loginuser==null){
    header("refresh:3;url=https://demo.shing227.works/");
    echo "請先登入!";
    exit();
}
else if($_POST['File']=="" && $_POST['Text']==""){
    header("refresh:3;url=https://demo.shing227.works/cheattable.php");
    echo "請輸入內容!";
    exit();
}

$text=$_POST['Text'];


$text=preg_replace ('/\<script([.>]*)/' , '< script$1' , $text, -1);

//echo preg_replace ('/\[color=(.*)\](.*)\[\/color\]/' , '<span style="color:$1;">$2</span>' , $tmp_text , 1, $count);
//[color=red][b]The[/b][i] [img]https://demo.shing227.works/headshow/Logo.png[/img]first [/i][u]one.[/u][/color]

//echo preg_replace ('/\[img\](.*)\[\/img\]/' , '<img src="$1"></img>' , $tmp_text , 1, $count);
//echo "$text"; 
//exit();
require_once('config.php');
$db_user = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()){
    $db_user = null;
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
try {
    $stmt = $db_user -> prepare("SELECT id FROM users WHERE username=?");
    $stmt -> bind_param("s", $loginuser);
    $stmt -> bind_result($userinfoId);
    $stmt -> execute();
    $stmt->fetch();
    //echo "$userinfoId, $loginuser, $text";
    $db_table = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (mysqli_connect_errno()){
        $db_table = null;
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $filename="";
    if(is_file($_FILES['File']['name'])){
        //
        //$filename = $_FILES['file']['name'];
        
        $filetype = $_FILES['File']['type'];
        $ext = pathinfo($_FILES['File']['name'], PATHINFO_EXTENSION);
        $filesize = $_FILES['File']['size'];
        $filetmp  = $_FILES['File']['tmp_name'];
        $filename = md5(uniqid(microtime(true), true)) . '.' . $ext;
        //echo $filename;
        $des = "./cheatdoc/" . $filename;
        move_uploaded_file($filetmp, $des);
    }
        /*header('content-type:text/html;charset=utf-8');
        include_once('imgCheck.php');
            $fileInfo=$_File['File'];
            $file = $fileInfo['tmp_name'];
            if(uploadCheck($fileInfo)){
            $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
            $uniName = $userinfoId . '.' . $ext;
            $des = 'cheatdoc/';
            move_uploaded_file($file, $des . $uniName);
            echo $des . $uniName;
        
        //*/
        //echo "$text, $loginuser, $userinfoId";
        $stmt = $db_table -> prepare("INSERT INTO `cheatTable` (`userId`,`username`,`text`, `doc`) VALUES (?, ?, ?, ?)");
        $stmt -> bind_param("isss", $userinfoId, $loginuser, $text, $filename);
        $stmt -> execute();
        //echo json_encode($stmt);
    /*}
    else {
        header('content-type:text/html;charset=utf-8');
        $file = $fileInfo['tmp_name'];
        $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
        $uniName = $userinfoId . '.' . $ext;
        $des = './cheatdoc/';
        move_uploaded_file($file, $des . $uniName);
        echo "$ext";
        $stmt = $db_table -> prepare("INSERT INTO `cheatTable` (`userId`,`username`, `text`, `doc`) VALUES (?, ?, ?, ?)");
        $stmt -> bind_param("isss", $userinfoId, $loginuser, $text, $uniName);
        $stmt -> execute();
    }*/
    header("refresh:3;url=https://demo.shing227.works/cheattable.php");
    echo "留言成功!";
}
catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
    exit();
}
?>