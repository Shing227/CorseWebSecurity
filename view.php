<?php session_start();
require_once('config.php');
$view_tableId=$_GET['table'];
$loginuser=$_SESSION['username'];
$db_view = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()){
    $db_view = null;
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
try{
    $stmt = $db_view -> prepare("SELECT * FROM cheatTable WHERE tableId=?");
    $stmt -> bind_param("i", $view_tableId);
    $stmt -> bind_result($tableId,$userId,$username,$text,$doc);
    $stmt -> execute();
    while($stmt->fetch()){
        echo"<form method=\"POST\" action=\"identify.php\">
                <fieldset>
                    <legend>Floor $tableId</legend>
                    <text style=\"float:right\"> from $username</text>
                    <input id=\"table$tableId\" type=\"hidden\" value=\"$tableId\">";
        echo $text;
        echo "<br><br>
                    <a href=\"./cheatdoc/$doc\" download=\"$doc\">$doc</a>";

        if($loginuser==$username){
            echo    "<button id=\"delete\" type=\"submit\" style=\"float:right\">刪除留言</button>";
        }
        echo       "</fieldset>
        </form>
            <br>";
    }
    
    //exec($file);
    //echo $file;
}
catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
}





?>