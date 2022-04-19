<?php session_start();
require_once('config.php');
$view_tableId=$_POST['table'];
$loginuser=$_SESSION['username'];
echo "
    <form method=\"POST\" action=\"delete.php\">
    <fieldset>
    <legend>身分驗證</legend>
    <input id=\"table\" name=\"table\" type=\"hidden\" value=\"$view_tableId\">
    <input id=\"username\" placeholder=\"Username\" type=\"text\" name=\"username\" value=\"$loginuser\" readonly required>
    <input id=\"password\" placeholder=\"Password\" type=\"password\" name=\"password\" required>
    <button  type=\"submit\">確定刪除</button>
    </fieldset>
    </form>";
?>
