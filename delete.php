<?php 
session_start();
//$flag = "CTF{Meowmeow}";
if( !isset($_POST['username']) || !isset($_POST['password']) || $_POST['username']=="" || $_POST['password']=="" ){
    header("Location: index.php");
}
$del_tableId=$_POST['table'];
$loginuser=$_SESSION['username'];
$username = $_POST['username'];
$password = $_POST['password'];

require_once('config.php');

try {
    //get user id by password
    $stmt = $db -> prepare("SELECT id,username FROM users WHERE username=? AND password=?");
    $stmt -> bind_param("ss", $username, $password);
    $stmt -> bind_result($Rid,$Ruser);
    $stmt -> execute();
    $stmt->fetch();

    //echo "$Rid,$Ruser";
    //get user id by tavleId
    $db_table = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (mysqli_connect_errno()){
        $db_table = null;
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    $stmt = $db_table -> prepare("SELECT userid,doc FROM cheatTable WHERE tableId=?");
    $stmt -> bind_param("i", $del_tableId);
    $stmt -> bind_result($userId, $doc_name);
    $stmt -> execute(); 
    $stmt->fetch();

    //echo ",$userId";
    //check two userid is equal
    if($Rid==$userId && $loginuser==$username && $loginuser==$Ruser){
        $sql_del = "delete from cheatTable where tableId='$del_tableId'";
        mysqli_query($link, $sql_del);
        //echo $doc_name;
        if(file_exists('./cheatdoc/'.$doc_name))
            unlink('./cheatdoc/'.$doc_name);
        //exec('sudo wget https://login.ntust.edu.tw/frontRef/images/Logo.png -d', $out);
        header("refresh:3;url=https://demo.shing227.works/cheattable.php");
        echo "刪除成功!";
        //$_SESSION['username'] = $_POST['username'];
    }
    else{
        header("refresh:3;url=https://demo.shing227.works/cheattable.php");
        echo '驗證失敗';
    }
    
}
catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
}
?>