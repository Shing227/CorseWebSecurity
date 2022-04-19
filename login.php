<?php 
session_start();
//$flag = "CTF{Meowmeow}";
if( !isset($_POST['username']) || !isset($_POST['password']) || $_POST['username']=="" || $_POST['password']=="" ){
    header("Location: index.php");
}

$username = $_POST['username'];
$password = $_POST['password'];

require_once('config.php');

try {
    $stmt = $db -> prepare("SELECT id,username FROM users WHERE username=? AND password=?");
    $stmt -> bind_param("ss", $username, $password);
    $stmt -> bind_result($Rid,$Ruser);
    $stmt -> execute();
    $stmt->fetch();
    
    if($Rid > 0){
        //echo $flag, '<br>';
        header("refresh:3;url=https://demo.shing227.works/cheattable.php");
        echo "登入成功! <br> 歡迎回來, $Ruser";
        $_SESSION['username'] = $_POST['username'];
    }
    else{
        header("refresh:3;url=https://demo.shing227.works/");
        echo '登入失敗';
    }
    
}
catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
}
?>