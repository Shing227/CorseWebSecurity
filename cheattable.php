<?php
session_start();
$loginuser=$_SESSION['username'];
if($loginuser==null){
    header("refresh:3;url=https://demo.shing227.works/");
    echo "請先登入!";
    exit();
}
require_once('config.php');
$stmt = $db -> prepare("SELECT * FROM Title WHERE '1'");
$stmt -> bind_result($title);
$stmt -> execute();
$stmt -> fetch();
echo "<title>$title</title><br>";

$db_table = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()){
    $db_table = null;
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
try {
    $stmt = $db_table -> prepare("SELECT headshotName FROM users WHERE username=?");
    $stmt -> bind_param("s", $loginuser);
    $stmt -> bind_result($userinfoHead);
    $stmt -> execute();
    $stmt->fetch();
    echo "<form>
            <fieldset>
                    <legend>$loginuser</legend>
                    <img src=\"./headshot/$userinfoHead\"; width=\"50\"; height=\"50\"></img>
                    <a href=\"./logout.php\" style=\"float:right\">登出</a>";
if($loginuser=='cwsAdmin') {
    echo "<br><a href=\"./YouCantAccess.php\" style=\"float:right\">修改標題</a>";
}
    echo "  </fieldset>        
        </form>";
}
catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
    exit();
}

$db_table = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()){
    $db_table = null;
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
try {
    $stmt = $db_table -> prepare("SELECT * FROM cheatTable WHERE '1'");
    $stmt -> bind_result($tableId,$userId,$username,$text,$doc);
    $stmt -> execute();
    while($stmt->fetch()){
        $dbu = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (mysqli_connect_errno()){
            $dbu = null;
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }
        $stmt2 = $dbu -> prepare("SELECT headshotName FROM users WHERE `id`='$userId'");
        $stmt2 -> bind_result($headshot);
        $stmt2 -> execute();
        $stmt2 -> fetch();
        //parse <b>
$tmp_text=$text;
$flag = true;
while($flag){
    $tmp_text=preg_replace ('/\[b\]/' , '<b>' , $tmp_text , 1, $count);
    //echo "$tmp_text<br>";
    if($count==1) $flag=false;
    else break;
    $tmp_text=preg_replace ('/\[\/b\]/' , '</b>' , $tmp_text , 1, $count);
    //echo "$tmp_text<br>";
    if($count==1) {
        $flag=true;
        $text=$tmp_text;
    }
    else break;
}
//parse <i>
$tmp_text=$text;
$flag = true;
while($flag){
    $tmp_text=preg_replace ('/\[i\]/' , '<i>' , $tmp_text , 1, $count);
    //echo "$tmp_text<br>";
    if($count==1) $flag=false;
    else break;
    $tmp_text=preg_replace ('/\[\/i\]/' , '</i>' , $tmp_text , 1, $count);
    //echo "$tmp_text<br>";
    if($count==1) {
        $flag=true;
        $text=$tmp_text;
    }
    else break;
}
//parse <u>
$tmp_text=$text;
$flag = true;
while($flag){
    $tmp_text=preg_replace ('/\[u\]/' , '<u>' , $tmp_text , 1, $count);
    //echo "$tmp_text<br>";
    if($count==1) $flag=false;
    else break;
    $tmp_text=preg_replace ('/\[\/u\]/' , '</u>' , $tmp_text , 1, $count);
    //echo "$tmp_text<br>";
    if($count==1) {
        $flag=true;
        $text=$tmp_text;
    }
    else break;
}
//echo "$text<br>"; 
//parse color
$tmp_text=$text;
$flag = true;
while($flag){
    $tmp_text= preg_replace ('/\[color=(.\w*)\](.*)\[\/color\]/' , '<span style="color:$1;">$2</span>' , $tmp_text , 1, $count);
    if($count==1) {
        $text = $tmp_text;
    }
    else break;
}
//echo "$text<br>"; 
//parse img
$tmp_text=$text;
$flag = true;
while($flag){
    $tmp_text= preg_replace ('/\[img\](.*)\[\/img\]/' , '<img src="$1"></img>' , $tmp_text , 1, $count);
    if($count==1) {
        $text = $tmp_text;
    }
    else break;
}
        echo"<form method=\"POST\" action=\"identify.php\">
                <fieldset>
                    <legend>Floor $tableId</legend>
                    <img src=\"headshot/$headshot\" style=\"float:right\"; width=\"60\"; height=\"60\"></img>
                    
                    <br>
                    <text style=\"float:right\"> from $username</text>
                    <input id=\"table\" name=\"table\" type=\"hidden\" value=\"$tableId\">";
        echo $text;
        echo "<br><br>
                    <a href=\"./cheatdoc/$doc\" download=\"$doc\">$doc</a>";

        if($loginuser==$username){
            echo    "<button id=\"delete\" type=\"submit\" style=\"float:right\">刪除留言</button>";
        }
        echo       "<a href=\"https://demo.shing227.works/view.php?table=$tableId\" style=\"float:right\" target=\"_blank\">單獨顯示</a>
                </fieldset>
        </form>
            <br>";
    }
}
catch (Exception $e) {
    echo 'Caught exception: ', $e->getMessage(), '<br>';
    echo 'Check credentials in config file at: ', $Mysql_config_location, '\n';
}
?>

<form method="POST" action="sendMsg.php" enctype="multipart/form-data">
    <input name="MAX_FILE_SIZE" type="hidden" value="2097152"> 
    <fieldset>
        <legend>留言</legend>
        <input id="Text" name="Text" placeholder="..." autofocus="" type="textarea" required>
        <input id="File" name="File" type="file">
    
    <button  type="submit">送出</button>
    </fieldset>
</form>