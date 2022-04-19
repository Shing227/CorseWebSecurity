<?php
    session_start();
    unset($_SESSION['username']);
    header("refresh:3;url=https://demo.shing227.works/");
    echo "已登出!";
?>