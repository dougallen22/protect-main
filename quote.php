<?php
session_start();
include('user/check_cookie.php');

if (isset($_POST['smoker']) and isset($_POST['age']) and isset($_POST['gender'])) {
    setcookie("age", "", time() - 3600);
    setcookie("gender", "", time() - 3600);
    setcookie("smoker", "", time() - 3600);
    setcookie("age", $_POST['age'], time() + 3600 * 24 * 365);
    setcookie("gender", $_POST['gender'], time() + 3600 * 24 * 365);
    setcookie("smoker", $_POST['smoker'], time() + 3600 * 24 * 365);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('maincss.php'); ?>
    <link rel="stylesheet" href="css/style.css">
    <title>Protect Mutual</title>

</head>

<body>
    <?php include('nav.php'); ?>
    <div class="quote-results" id="quote" style="display:none; margin: 2%; padding: 1%;"></div>
    <div class="loader" style="display:none;text-align:center;">
        <h1> Finding your low rates....</h1>
    </div>

<!-- Modal -->

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <a href="Javascript:void(0)" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></a>
        <span class="modal-title" id="exampleModalLabel">Get Qoutes on Email</span>
      </div>
      <div class="modal-body">
          <div class="form-group">
            <label for="message-text" class="control-label">Email:</label>
            <input class="form-control" id="quote-email" placeholder="Add Email Address"></input>
          </div>
      </div>
      <div class="modal-footer">
        <a href="Javascript:void(0)" id="send-email" class="btn btn-primary">Send</a>
      </div>
    </div>
  </div>
</div>
<!-- End Modal -->


    <?php
    include('footer.php');

    ?>

    <input type="hidden" id="smoker" value="<?php echo $_POST['smoker'] ?>">
    <input type="hidden" id="age" value="<?php echo $_POST['age'] ?>">
    <input type="hidden" id="gender" value="<?php echo $_POST['gender'] ?>">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <?php

    $qry = "SELECT rates From new_rates";
    $qry_run = mysqli_query(con(), $qry);
    while ($row = mysqli_fetch_array($qry_run)) {
        $array[] = $row['rates'];
    }
    $count = count($array);
    ?>

    <script>
    
    $(window).on('load', function () {
         $(".loader").show();
     });



    var height = 823;
    if (/windows/i.test(navigator.userAgent)) {
        height = 823;
    }
    if (/iphone/i.test(navigator.userAgent)) {
        height = 793;
    }
    if (/android/i.test(navigator.userAgent)) {
        height = 860;
    }

    var smoker = $('#smoker').val();
    var age = $('#age').val();
    var gender = $('#gender').val();



/*////////////////////////////////////////////////////////////////////////////////////////////////////////
                                Get Qoutes on Ready Function Starts
///////////////////////////////////////////////////////////////////////////////////////////////////////*/
function GetQoutes() {
        var cover = <?php echo '["' . implode('", "', $array) . '"]' ?>;
        var coverge = cover[3];
        var ele = $("#quote");
        var scroll = $("#scrollshow");
        var price;
        //var ss=$("#ss").val();
        $.ajax({
            type: "POST",
            url: "get_quote.php",
            data: {
                age: age,
                gender: gender,
                smoker: smoker,
                coverge: coverge
            },
            beforeSend: function() {
                // Show image container
                $(".loader").show();
            },
            success: function(result) {
                console.log(result);
                $(".loader").hide();
                ele.show();
                ele.html('');
                $('.container2').hide();
                $('.flex-container1').show();
                ele.append(result);
            
            }
        });
}
/*////////////////////////////////////////////////////////////////////////////////////////////////////////
                                Get Qoutes on Ready Function Ends
///////////////////////////////////////////////////////////////////////////////////////////////////////*/







    $(document).ready(function() {
var cover = <?php echo '["' . implode('", "', $array) . '"]' ?>;
        var coverge = cover[3];
        var ele = $("#quote");
        var scroll = $("#scrollshow");
        var price;
        //var ss=$("#ss").val();
        $.ajax({
            type: "POST",
            url: "get_quote.php",
            data: {
                age: age,
                gender: gender,
                smoker: smoker,
                coverge: coverge
            },
            beforeSend: function() {
                // Show image container
                $(".loader").show();
            },
            success: function(result) {
                console.log(result);
                $(".loader").hide();
                ele.show();
                ele.html('');
                $('.container2').hide();
                $('.flex-container1').show();
                ele.append(result);
                $("#exampleModal").modal('show');
            }
        });    });

    $(document).on('click', '.plusminus', function() {
        var cover = <?php echo '["' . implode('", "', $array) . '"]' ?>;
        var ele = $("#quote");
        var scroll = $("#scrollshow");
        var price;
        var count = <?php echo $count ?>;

        var v = parseInt($("#v").val());
        if ($(this).attr('id') == 'plus' && v < count) {
            v++;
        } else if ($(this).attr('id') == 'minus' && v > 0) {
            v--;
        }
        if (v == 0 || v == count) {
            $(this).prop('disabled', true);
        } else {
            $(this).prop('disabled', false);
        }
        //$('#demo').val(cover[v]);

        var coverage = cover[v];

        //var ss=$("#ss").val();
        $.ajax({
            type: "POST",
            url: "get_quote.php",
            data: {
                age: age,
                gender: gender,
                smoker: smoker,
                coverage,
                v
            },
            success: function(result) {

                ele.show();
                ele.html('');

                ele.append(result);
            }
        });
        /*Display data*/


        /*end display data*/


        /*validation end*/

    });
    </script>
    <script>
    $(document).ready(function() {
        var y = 0;
        $(document).on('click', '.dropbtn', function() {

            $('.' + $(this).data('year')).css("display", "block");
        });
        $(document).on("click", ".bbt", function() {
            if (y == 0) {
                $(this).parent().parent().css("border-bottom", "none");
                y++;
            } else if (y == 1) {

                $(this).parent().parent().css("border-bottom", "1px solid #00aeff");
                y = 0;
            }
        });
    });
    </script>
    <?php include('mainjs.php'); ?>


<script type="text/javascript">
$(document).ready(function() {
$(document).on("click", '#send-email', function() {
    var emailaddress=$("#quote-email").val();
/*////////////////////////////////////////////////////////////////////////////////////////////////////////
                                    Email Validation Starts
///////////////////////////////////////////////////////////////////////////////////////////////////////*/
var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
if(!emailaddress.match(mailformat))
{
alert("You have entered an invalid email address!");
$("#quote-email").focus();
return false;
}
/*////////////////////////////////////////////////////////////////////////////////////////////////////////
                                    Email Validation Ends
///////////////////////////////////////////////////////////////////////////////////////////////////////*/

/*////////////////////////////////////////////////////////////////////////////////////////////////////////
                                    Ajax Call to send Email starts
///////////////////////////////////////////////////////////////////////////////////////////////////////*/
        var cover = <?php echo '["' . implode('", "', $array) . '"]' ?>;
        var coverge = cover[3];
        var ele = $("#quote");
        var scroll = $("#scrollshow");
        var price;
        //var ss=$("#ss").val();
        $.ajax({
            type: "POST",
            url: "send-email.php",
            data: {
                emailaddress:emailaddress,
                age: age,
                gender: gender,
                smoker: smoker,
                coverge: coverge
            },
            beforeSend: function() {
                //showModal();
            },
            success: function(result) {
                console.log(result);
                GetQoutes();
               $("#exampleModal").modal('hide');
            }
        });
/*////////////////////////////////////////////////////////////////////////////////////////////////////////
                                    Ajax Call to send Email Ends
///////////////////////////////////////////////////////////////////////////////////////////////////////*/
});
    });
</script>



</body>

</html>