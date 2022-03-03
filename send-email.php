<?php
if (isset($_POST['age'])) {
/*/////////////////////////////////////////////////////////////////////////////////
                            Mail
///////////////////////////////////////////////////////////////////////////////////*/

            $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= 'From: info@protectmutual.com' . "\r\n";
            $headers .= 'Reply-To: noreply@protectmutual.com' . "\r\n";
            $headers .= "Return-Path: info@protectmutual.com\r\n";
            $headers .= "X-Mailer: PHP" . phpversion() . "\r\n";

            $email=$_POST['emailaddress'];
            session_start();
            $_SESSION['emailaddress']=$email;
            $msg1 = '<center>
    <div style="width:100%;">
        <div style="background: white; padding: 15px; border: 1px solid #e3e3e3; border-top: 5px solid orange; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05); box-shadow: inset 0 1px 1px rgba(0,0,0,.05);">
            <h3 style="text-align: center;">Protect  Mutual</h3>
        <a href="#"><img src="http://protectmutual.com/emailimages/pic.jpg" alt="" style="margin-right: -19px; margin-left: -19px; width: 100%;"> </a>               
                <p style="text-align: left;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ab magnam qui animi minima eveniet explicabo sint saepe maxime minus expedita magni dolore dignissimos, quae neque! Tempora dolorem eum, doloribus qui.</p>
            <h1 class="text-center"><span style="font-family: Segoe UI Symbol;">&#128222;</span>
            <span style="color: orange"><b>855-996-0304</b></span></h1>
               <p class="text-center">Call us <span style="color: orange">before October is over</span> to cross this off your list.</p>
                <div style="margin-left: -19px; margin-right: -19px; padding: 5px; background-color: #f5f5f5; border: 1px solid #e3e3e3; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05); box-shadow: inset 0 1px 1px rgba(0,0,0,.05);">
                <h3 style="text-align:left;"><b>You applied with Protective Life:</b></h3>
                <div style="background: white; padding: 5px; border: 1px solid #e3e3e3; border-radius: 4px; -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.05); box-shadow: inset 0 1px 1px rgba(0,0,0,.05); display: flex; flex-wrap: wrap;">
               <table width="100%" style="text-align: center; font-size: small;">
                    <tr>
                        <th style="font-size:12px; width:33%;">COMPANY</th>
                        <th style="font-size:12px; width:33%;">POLICY TERM</th>
                        <th style="font-size:12px; width:33%;">MONTHLY</th>
                        <th style="font-size:12px; width:33%;">COVERAGE</th>
                    </tr>';













    include 'admin/includes/functions.php';
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $smoker = $_POST['smoker'];
    if (isset($_POST['coverage'])) {
        $coverage = $_POST['coverage'];
    } else {
        $coverage = $_POST['coverge'];
    }

    if (isset($_POST['v'])) {
        $v = $_POST['v'];
    } else {
        $v = 3;
    }

    $get_rate_query = "SELECT * FROM new_rates where rates='$coverage'";
    $run_query_get = mysqli_query(
        con(),
        $get_rate_query
    );
    $quote_results = [];
    while (
        $fetch_data = mysqli_fetch_array($run_query_get)
    ) {
        $fetch_id = $fetch_data['id'];
        $select_years = "SELECT DISTINCT year from company_rates where gender='$gender' AND smoker='$smoker' AND age='$age' AND rates_id='$fetch_id' AND value!='' ORDER BY year ASC";
        $run_years = mysqli_query(con(), $select_years);
        $n_of_years = mysqli_num_rows($run_years);
        $yrss = 0;
        $n_of_quotes = 0;
        while (
            $fetch_year = mysqli_fetch_array($run_years)
        ) {
            $count = 0;
            $yrss++;
            $yer = $fetch_year['year'];
            $count_quotes = "SELECT * from company_rates where gender='$gender' AND smoker='$smoker' AND age='$age' AND rates_id='$fetch_id' AND value!='' ";
            $run_count_quotes = mysqli_query(
                con(),
                $count_quotes
            );
            $no_count_quotes = mysqli_num_rows(
                $run_count_quotes
            );
            $select_quotes = "SELECT * from company_rates where gender='$gender' AND smoker='$smoker' AND age='$age' AND rates_id='$fetch_id' AND value!='' AND year='$yer' ORDER BY value ASC";
            $run_quotes = mysqli_query(
                con(),
                $select_quotes
            );
            $no_of_quotes = mysqli_num_rows(
                $run_quotes
            );
            $n_of_quotes =
                $n_of_quotes +
                mysqli_num_rows($run_quotes);

            if ($n_of_quotes > 0) {

                while (
                    $row = mysqli_fetch_array(
                        $run_quotes
                    )
                ) {

                    $count++;

                    $company_id = $row['company_id'];
                    $img_query = "SELECT * FROM company where id='$company_id'";
                    $run_query = mysqli_query(
                        con(),
                        $img_query
                    );
                    $img = mysqli_fetch_array(
                        $run_query
                    );

                    $filnam =
                        getcwd() .
                        '/admin/images/' .
                        $img['company_logo'];

                    if (
                        !file_exists($filnam) ||
                        $img['company_logo'] == ''
                    ) {
                        $logo =
                            '<img src="'.$actual_link.'/admin/images/company_dummy.png" width="50%" height="50%">';
                    } else {
                        $logo =
                            '<img src="'.$actual_link.'/admin/images/' .
                            $img['company_logo'] .
                            '" width="50%" height="50%">';
                    }

                    $msg1.='<tr>
                            <td>'.$logo.'</td>
                            <td>'.$row['year'].'</td>
                            <td>$'.$row['value'] .'</td>
                            <td style="padding-bottom:2%; padding-top:2%;"> $'.number_format($coverage) .'<br><br>
                            <a style="text-decoration: none;color: #fff;margin: 0;padding: 0.50rem 1rem;background-color: #ff700a;border: 2px solid #ff700a;border-radius: 0;transition: all 0.1s;outline: none;white-space: normal;" href="'.$actual_link.'/plan-form.php?id='.$row['id'].'&coverage='.$coverage.'&coveragevalue='.$row['value'].'&company_name='.$img['company_name'].'&company_logo='.$img['company_logo'].'&year='.$row['year'].'&email='.$email.'">Continue</a>
                            </td>
                            </tr>';


                }
            }
        }
    }


$msg1.=' </table>
                 </div>
              <p>P.S. We can adjust these numbers with us over the phone!</p>
               </div>
      <section style="margin-top: 50px; text-align: left;">
            <a href="#"><img src="http://protectmutual.com/emailimages/facebook.png" alt="" width="30px"></a>
            <a href="#"><img src="http://protectmutual.com/emailimages/twitter.png" alt=""width="30px"></a>
            <a href="#"><img src="http://protectmutual.com/emailimages/insta.png" alt=""width="30px"> 
            <a href="#"><img src="http://protectmutual.com/emailimages/linked.png" alt=""width="30px"></a>
            <h5 style="color: orange;"><b>Protect Mutual</b></h5>
                <p>Life. Home. Auto. We can help with all your insurnace needs.</p>
                <p>Springfield, IL </p>
                <p>Manage preferences | Unsubscribe</p>
        </section> 

        </div>
    </div>
</center>';

/*///////////////////////////////////////////////////////////////////////////////////
                          Mail Finished
////////////////////////////////////////////////////////////////////////////////////*/


mail($email, "Your Plan is Submitted successfully", $msg1, $headers);

echo $msg1;


}