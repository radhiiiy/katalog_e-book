<?php
$page = isset($_GET['page']) ? $_GET['page'] : 'home';

if ($page == 'home') {
    include 'page/home.php';
} elseif ($page == 'View_all') {
    include 'page/View_all.php';
} elseif ($page == 'detail') {
    include 'page/detail.php';
}
?>