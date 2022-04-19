<?php
//use to debug, reference from https://www.footmark.com.tw/news/programming-language/php/php-uploads/
function uploadCheck($fileInfo, $allowExt = array('jpeg', 'jpg', 'gif', 'png'), $maxSize = 2097152, $flag = true) {
    $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION);
    $mes = '';
    if ($fileInfo['error'] > 0) {
        switch ($fileInfo['error']) {
            case 1:
                $mes = '上傳的檔案超過了 php.ini 中 upload_max_filesize 允許上傳檔案容量的最大值';
                break;
            case 2:
                $mes = '上傳檔案的大小超過了 HTML 表單中 MAX_FILE_SIZE 選項指定的值';
                break;
            case 3:
                $mes = '檔案只有部分被上傳';
                break;
            case 4:
                $mes = '沒有檔案被上傳（沒有選擇上傳檔案就送出表單）';
                break;
            case 6:
                $mes = '找不到臨時目錄';
                break;
            case 7:
                $mes = '檔案寫入失敗';
                break;
            case 8:
                $mes = '上傳的文件被 PHP 擴展程式中斷';
                break;
        }
        exit($mes);
    }
    if (!is_uploaded_file($fileInfo['tmp_name']))
        exit('檔案不是通過 HTTP POST 方式上傳的');
    if (!is_array($allowExt))
        exit('檔案類型型態必須為 array');
    else {
        if (!in_array($ext, $allowExt))
            exit('非法檔案類型');
    }
    if ($fileInfo['size'] > $maxSize)
        exit('上傳檔案容量超過限制');
    if ($flag && !@getimagesize($fileInfo['tmp_name']))
        exit('不是真正的圖片類型');
    return true;
}
?>