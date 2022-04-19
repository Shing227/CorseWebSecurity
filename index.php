<?php session_start();
//$loginuser=$_SESSION['username'];
if(isset($_SESSION['username']))
    header("Location: cheattable.php");
echo 'Hello, I don\'t what I am doing!';
//echo '<br> Hi B10815041<br>';

//echo htmlspecialchars(date('G:i'));
/*function regNewUser(){
    echo " Have a great day";
    <script type="text/javascript">
    document.getElementById('password').removeAttribute('required');
    </script>
}
regNewUser();*/

/*

    <select class="sendimg" name="sendImg"> 
        <option value="Upload">Upload One …</option>
        <option value="URL">use URL</option>
        <input id="imageUpload" placeholder="file..." type="file" name="imageUpload" required hided><br>
    </select>
    

<div class="result"></div>
const selectElement = document.querySelector('.sendImg');




selectElement.addEventListener('change', (event) => {
  const result = document.querySelector('.result');
  result.textContent = `You like ${event.target.value}`;
});
*/
    //var b = document.querySelector("password");
    //b.setAttribute('required', false);
    
?>
<p> Login </p>
<form method="POST" action="login.php">

    <input id="username" placeholder="Username" autofocus="" type="text" name="username" required>
    <input id="password" placeholder="Password" type="password" name="password" required>
    <button  type="submit">登入</button>
    
</form>
<br>
<br>
<br>
<p> Register </p>
<form method="POST" action="register.php" enctype="multipart/form-data">
    <input name="MAX_FILE_SIZE" type="hidden" value="2097152"> 
    <input id="username" placeholder="Username" autofocus="" type="text" name="username" required>
    <br>
    <input id="password" placeholder="Password" type="password" name="password" required>
    <br>
        <input id="radioURL" type="radio" value="radioURL" name="imageOption" checked required>
        <label for="radioURL">Image URL</label>
        <input id="imageURL" placeholder="url..." autofocus="" type="url" name="imageURL"><br>
    
        <input id="radioUpload" type="radio" value="radioUpload" name="imageOption" required>
        <label for="radioUpload">Image Upload</label>
        <input id="imageUpload" type="file" name="imageUpload" accept="image/jpeg,image/gif,image/png"><br>
    

    <button  type="submit">註冊</button>
</form>
