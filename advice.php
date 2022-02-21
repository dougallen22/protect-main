<?php
session_start();
include('user/check_cookie.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <title>About Protect Mutual</title>
    <?php include('maincss.php'); ?>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include('navigation.php'); ?>
    <div class="container">
        <div class="wrapper">
            <div class="wrap">
                <h1>Advice</h1><br>
                <p>Financial Experts recommend at least 10 times your annual salary in life insurance</p>
            </div>
        </div>
    </div>



    <?php include('footer.php'); ?>
    <?php include('mainjs.php'); ?>
</body>

</html>