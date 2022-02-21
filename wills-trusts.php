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
    <title>Dashboard</title>
    <?php include('maincss.php'); ?>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <?php include('navigation.php'); ?>
    <div class="container">
        <div class="wrapper">
            <div class="wrap">
                <h1>Wills & Trusts</h1><br>
                <h3>What is a will?</h3><br>
                <p>A will or testament is a legal document that expresses your wishes as how
                    to distribute your property after death to named beneficiaries. Everyone shold have a will to secure
                    that your assest to your loved ones. Without a will the courts will determine your heirs</p>
            </div>
        </div>
    </div>



    <?php include('footer.php'); ?>
    <?php include('mainjs.php'); ?>
</body>

</html>