<?php
if(isset($_POST['query_param'])) {
    $query_param = $_POST['query_param'];
    setcookie('candidature', $query_param, time() + (86400 * 30), "/"); // 86400 = 1 jour
    echo 'Cookie créé';
}
?>