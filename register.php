<?php session_start();
if( !isset($_POST['username']) || !isset($_POST['password']) || 
    $_POST['username']=="" || $_POST['password']=="" /*|| 
    ($_POST['imageURL']=="" && $_POST['imageOption']=="radioURL")|| 
    ($_POST['imageUpload']=="" && $_POST['imageOption']=="radioUpload")|| 
    ($_POST['imageURL']=="" && $_POST['imageUpload']=="")*/){
        
    header("refresh:3;url=https://demo.shing227.works/");
    //<test area>
    //echo $_POST['imageOption'],$_POST['imageUpload'];
    //
    echo "註冊失敗! 請檢查帳號、密碼和大頭貼是否為空";
    exit(); 
}

$username = $_POST['username'];
$password = $_POST['password'];
require_once('config.php');

try {
    $stmt = $db -> prepare("SELECT id FROM users WHERE username=?");
    $stmt -> bind_param("s", $username);
    $stmt -> bind_result($Rid);
    $stmt -> execute();
    $stmt -> fetch();
    if($Rid > 0){
        echo "註冊失敗!<br> $username, 已存在";
    }
    else {
        try{
            $Logo = "Logo.png";
            $stmt = $db -> prepare("INSERT INTO `users` (`username`, `password`, `headshotName`) VALUES (?, ?, ?)");
            $stmt -> bind_param("sss", $username, $password, $Logo);
            $stmt -> execute();
            //upload headshot
            //require_once('config.php');
            $stmt = $db -> prepare("SELECT id FROM users WHERE username=? AND password=?");
            $stmt -> bind_param("ss", $username, $password);
            $stmt -> bind_result($sid);
            $stmt -> execute();
            $stmt->fetch();
            $imageOption = $_POST['imageOption'];
            if($imageOption == "radioURL") {
                $imageurl = $_POST['imageURL'];
                if(is_file($imageurl)){
                    $file=file_get_contents($imageurl);
                    $ext = pathinfo($imageurl, PATHINFO_EXTENSION);
                    $uniName = $sid . '.' . $ext;
                    $des=fopen("./headshot/$uniName","a");
                    if(file_exists("./headshot/$uniName")){
                        fwrite($des,$file);
                        require_once('config.php');
                        $sql = "UPDATE `users` SET `headshotName` = '$uniName' WHERE `id` = '$sid' ";
                        mysqli_query($link, $sql);
                    }
                }

            }
            else if($imageOption == "radioUpload"){
                header('content-type:text/html;charset=utf-8');
                include_once('imgCheck.php');
                $fileInfo = $_FILES['imageUpload'];
                $file = $fileInfo['tmp_name'];
                if(uploadCheck($fileInfo)){
                    $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
                    $uniName = $sid . '.' . $ext;
                    $des = 'headshot/';
                    move_uploaded_file($file, $des . $uniName); 
                    require_once('config.php');
                    $sql = "UPDATE `users` SET `headshotName` = '$uniName' WHERE `id` = '$sid' ";
                    mysqli_query($link, $sql);
                }
            }
        }
        catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), '<br>';
        }
        $_SESSION['username'] = $_POST['username'];
        header("refresh:3;url=https://demo.shing227.works/cheattable.php");
        echo "註冊成功!<br> 歡迎,$username";
    }
    
}
catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
}