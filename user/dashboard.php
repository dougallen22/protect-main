<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
    <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

    <title>Protect Mutual</title>

</head>

<body>
    <?php include('../navigation.php');
    ob_start();
    include('check_cookie.php');
    check_session();

    ?><br><br>

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
     

        <div id="upload" class="choice" style="display:none">
            <h2 style="text-align: center">Upload Documents</h2><br>

            <form action="" method="POST" role="form" enctype="multipart/form-data">

                <div onclick="trigger2();" id="display2">
                    <img src="images/upload.png" id="img2" width="150px"><br><br>
                    <h1>Select File</h1><br>
                    <input type="file" name="upload" id="inputimg2" style="display: none" onchange="displayimg2(this);">

                </div>

                <div class="alert alert-info" role="alert" id="others" style="display:none;"></div>

                <p style="color: red; display:none; text-align: center; height: 100%;" id="p2">Only images,
                    word, excle or PDF files are accepted</p>
                <p style="color: red; display:none; text-align: center; height: 100%;" id="pp2">Please
                    Select a
                    File</p>

                <input type="submit" class="btn btn-primary" name="submit" value="SUBMIT" onclick="emptycheck();">
            </form>

            <div class="alert alert-info" role="alert" id="others" style="display: none;"></div>


            <?php

            if (isset($_POST['submit'])) {
                $id = $_GET['data'];
                $img2 = $_FILES['img2']['name'];
                $extension = pathinfo($_FILES["img2"]["name"], PATHINFO_EXTENSION);
                $newname = 'Document' . rand() . '.' . $extension;
                if (!empty($img2) and ($extension == 'pdf' || $extension == 'docx' || $extension == 'doc' || $extension == 'csv' || $extension == 'xlsx' || $extension == 'png' || $extension == 'jpg' || $extension == 'jpeg')) {
                    if (!empty($doc)) {
                        $nstr = $doc . ',' . $newname;
                        $qry = "UPDATE user_plan SET document='$nstr' where id='$id'";
                        if (mysqli_query(con(), $qry)) {
                            move_uploaded_file($_FILES['img2']['tmp_name'], "document/$newname");
                            echo "<script> alert('successfully uploaded')</script>";
                        }
                    } else {
                        $qry = "UPDATE user_plan SET document='$newname' where id='$id'";
                        if (mysqli_query(con(), $qry)) {
                            move_uploaded_file($_FILES['img2']['tmp_name'], "document/$newname");
                            echo "<script> alert('Successfully Uploaded')</script>";
                        }
                    }
                } else {
                    echo "<script> alert('Please Select a file')</script>";
                }
            }

            ?>

        </div>

        <div id="billing" class="choice" style="display:none">
            <h2>Billing</h2>
            <p>Billing</p>
        </div>

        <div id="wills" class="choice" style="display:none">
            <h2>Wills & Trusts</h2>
            <p>Wills & Trusts</p>
        </div>



    </div>


    </div>
    </div>

    <?php include('../footer.php'); ?>


    <script>
    /*///////////////////////////////////////////////////////////////////////////////////////////////////////
                                  Tabs
    ///////////////////////////////////////////////////////////////////////////////////////////////////////*/

    function openChoice(evt, choiceName) {
        var i, x, tablinks;
        x = document.getElementsByClassName("choice");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < x.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" color:#FF0000", "");
        }

        document.getElementById(choiceName).style.display = "block";
        evt.currentTarget.className += " color:#FF0000";
    }
    </script>



    <script>
    /*///////////////////////////////////////////////////////////////////////////////////////////////////////
                                    Document upload
            ///////////////////////////////////////////////////////////////////////////////////////////////////////*/

    function emptycheck() {
        var filenname = document.getElementById('inputimg2').value;
        if (filenname = '') {
            document.getElementById('pp2').style.display = 'inherit';

        }
    }

    function trigger2() {
        document.querySelector('#inputimg2').click();
    }

    function displayimg2(e) {
        var filename = document.querySelector('#inputimg2').value;
        var fileExtention = filename.substr(filename.lastIndexOf('.') + 1);
        if (fileExtention === 'png' || fileExtention === 'jpg' || fileExtention === 'jpeg') {
            document.querySelector('#p2').style.display = 'none';
            if (e.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('#img2').setAttribute('src', e.target.result);
                    document.querySelector('#img2').style.width = '25%';

                }
                reader.readAsDataURL(e.files[0]);
            }

        } else if (fileExtention === 'pdf' || fileExtention === 'docx' || fileExtention === 'doc' || fileExtention ===
            'csv' || fileExtention === 'xlsx') {
            $("#img2").removeAttr("src");
            document.querySelector('#others').style.display = 'block';
            document.getElementById('others').innerHTML = filename;
        } else {
            document.querySelector('#p2').style.display = 'inherit';
            document.querySelector('#display2').style.background = 'none';
        }
    }


    /* $(document).ready(function() {
         hrf = $(".pull-left a").attr('href');
         $(".pull-left a").attr('href', '../' + hrf);
         hrf = $(".pull-right a").attr('href');
         $(".pull-right a").attr('href', '../' + hrf);
         img = $(".uimg").attr('src');
         $(".uimg").attr('src', '../' + img);
     }); */
    /*///////////////////////////////////////////////////////////////////////////////////////////////////////
                        Document upload finished
    ///////////////////////////////////////////////////////////////////////////////////////////////////////*/
    </script>

    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>













</body>

</html>