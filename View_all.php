<!DOCTYPE html>
<html lang="en">
<?php include "component/header.php" ?>

<body>
    <?php include "component/navbar.php" ?>
    <?php
    $page = isset($_GET["page"]) ? $_GET["page"] : 'View_all';

    if ($page == 'View_all') {
        include "page/View_all.php";
    } elseif ($page == 'home') {
        include "page/home.php";
    } elseif ($page == 'detail') {
        include "page/Detail.php";
    } else {
        echo "<h1>404 Not Found</h1>";
    }
    ?>
    <?php //include "page/home.php" ?>

    <?php include "component/footer.php" ?>
</body>

</html>