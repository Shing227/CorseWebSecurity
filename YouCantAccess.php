<?php session_start();
require_once('config.php');
$newTitle=$_GET['title'];
$loginuser=$_SESSION['username'];

try{
    if($loginuser=='cwsAdmin'){
        require_once('config.php');
        $sql = "UPDATE `Title` SET `title` = '$newTitle' WHERE '1' ";
        mysqli_query($link, $sql);
        echo "诶嘿~用GET修改title吧!";
        echo "<a href=\"https://demo.shing227.works/cheattable.php\">return</a>";
    }
    else
        header("Location: cheattable.php");
}
catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
}