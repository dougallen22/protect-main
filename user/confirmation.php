<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Protect Mutual Confirmation</title>
</head>

<body>
    <?php include('../navconfirmation.php');
    ob_start();
    include('check_cookie.php');
    check_session();

    ?>
    <div class="container">
        <?php
        $email = $_SESSION['ruser']['email'];
        $nme = @$_SESSION['ruser']['fname'] . ' ' . @$_SESSION['ruser']['sname'];
        if (isset($_GET['productid']) and !empty($_GET['productid'])) {
            $productid = $_GET['productid'];
        } else {
            header('location:index.php');
        }
        $qry = "SELECT * FROM user_plan where id='$productid'";
        $ru = mysqli_query(con(), $qry);
        $result = mysqli_fetch_array($ru);
        if ($email != $result['email']) {
            header('location:index.php');
        } else {
            $price = $result['price'];
            $coverage = $result['coverage'];
            $company_name = $result['company_name'];
            $rats_id = $result['rates_id'];
            $qryy = "SELECT * FROM  company_rates where id='$rats_id'";
            $ruu = mysqli_query(con(), $qryy);
            $resultt = mysqli_fetch_array($ruu);
        }
        ?>

        <div id="quotes" class="confirmation">
           
            <div class="conf-box">
                <div class="dashboard-progress1">
                    <p>Quotes</p>
                    <p>Apply</p>
                    <p>Review</p>
                    <p>Decision</p>
                </div>

                <div class= "confirmation-next">
                    <h2> Now, connect with one of our Agents</h2><br>
                    <p>We do need to speak with you for a few minutes to confirm your identity</p>
                            
                    <ul>
                        <li><a class="confirmation-call" href="tel:123-456-7890">Call us @ 855-855-5555</a></li>
                        <li><a class="confirmation-schedule" href="tel:123-456-7890">Schedule a Call</a></li>
                    </ul>
                </div>

                <div class="confirmation-plan">

                    <div class="monthly">
                        <h4>Monthly</h4>
                        $<?php echo $price; ?>
                    </div>

                    <div class="cover">
                        <h4>Coverage</h4><br>
                        <h2>$<?php echo number_format($coverage); ?></h2>
                    </div>

                    <div class="term">
                        <h4>Term</h4><br>
                        <h2>$<?php echo number_format($resultt['year']); ?></h2>
                    </div>

                    <div class="company">
                        <h4>Company</h4><br>
                        <?php $filnam = dirname(__DIR__) . '/admin/images/' . $result['company_logo'];

                        if (!file_exists($filnam) || $result['company_logo'] == '') {
                            echo '<img src="../admin/images/company_dummy.png" width="60" height="25">';
                            } else {
                                 echo '<img src="../admin/images/' . $result['company_logo'] . '" width="60" height="25">';
                            }
                            ?>
                    </div>
                        
                </div>

                <div class="skip">
                    
                    <div>
                        <a href="tel:123-456-7890p123"><img src="images/wait.png">SKIP THE WAIT</a>
                        <a href ="tel:855-855-5555"><h3>855:289:6450</h3></a>
                    </div>
                        
                    <div>
                        <p>Ready to get covered now? If you call now, we can expedite your review.  
                            If your not ready now don't worry we'll call you later today to verify your identity.</p>
                    </div>
        
                </div>     
            </div>
        </div>
    </div>
        <?php include('../footer.php'); ?>
</body>

</html>