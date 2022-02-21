
<?php
if (isset($_POST['age'])) {
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
    $quote_results = '';
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
                if ($yrss == 1) {
                    $quote_results .=
                        '
    <div class= "wrapper">
        <h1 class= "plans"> We found ' .
                        $no_count_quotes .
                        ' term plans</h1><br>
            
        <div class="flex">
            <div class= "leftdiv">
                <div class= "info">          
                    <!--COVERAGE-->

                    <div>          
                        <h1 class= "coverage">Coverage $' .
                        number_format($coverage) .
                        '</h1><br>
                    </div>
                                                    
                    <div>               
                        <input type="button" class="btn plusminus" id="minus" value="-" >&nbsp;&nbsp; &nbsp; <input type="button" id="plus" class="btn plusminus" value="+">
                        <input type="hidden" id="v" value="' .
                        $v .
                        '">
                    </div><br> 
                                        
                    <div class="quote-info">
                        <h3> How much coverage do I need?</h3><br>    
                        <p class= "tip">Financial Planners use a rule of 10 times your annual income for coverage amount. Or you can use our Life Insurance Caculator.</p><br>
                        <p class="partners"> Our Insurance Partners</p><br> 
                        <img src="images/svg/companies.svg">
                    </div> 

                </div>         
            </div>    <!--end leftdiv-->';
                }
                if ($yrss == 1) {
                    $quote_results .=
                        '<div class="rightdiv">';
                }
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
                            '<img src="admin/images/company_dummy.png" >';
                    } else {
                        $logo =
                            '<img src="admin/images/' .
                            $img['company_logo'] .
                            '" >';
                    }

                    if ($count == 1) {
                        $ccls = '';
                        if ($no_of_quotes > 1) {
                            $ccls = 'bbt';
                        }

                        $quote_results .=
                            '<div class="card" style="border:1px solid #00aeff;z-index:1;">
                                <div class= "top-card">
                                    <div class= "insurance-logo">' .
                            $logo .
                            '</div>
                                    <div> Policy Term<br><br><span class= "price" style= "font-size: 36px;">' .
                            $row['year'] .
                            '</span> Yrs</div>
                                    <div> Monthly <br><br><span class= "price" style= "font-size: 36px;">$' .
                            $row['value'] .
                            '</span> </div>
                                    <div class= "cov"> Coverage<br><br><span class= "price" style= "font-size: 36px;"> $' .
                            number_format($coverage) .
                            '</span></div>
                                </div>
                                <div class= "bottom-card">
                                         
                                    <a class="dropbtn ' .
                            $ccls .
                            '" data-toggle="collapse" data-target="#rbyy' .
                            $row['year'] .
                            '">More Options <i class="fa fa-caret-down"></i></a><div><a class="con" href="plan-form.php?id=' .
                            $row['id'] .
                            '&coverage=' .
                            $coverage .
                            '&coveragevalue=' .
                            $row['value'] .
                            '&company_name=' .
                            $img['company_name'] .
                            '&company_logo=' .
                            $img['company_logo'] .
                            '&year=' .
                            $row['year'] .
                            '"><button class= "continue">CONTINUE</button></a></div>   
                                </div></div>';
                    }

                    if (
                        $count == 2 &&
                        $no_of_quotes > 1
                    ) {
                        $quote_results .=
                            '<div id="rbyy' .
                            $row['year'] .
                            '" class="collapse" >';
                    }
                    if (
                        $count > 1 &&
                        $no_of_quotes > 1
                    ) {
                        $bbr = '';
                        if ($count == $no_of_quotes) {
                            $bbr =
                                'border-bottom:1px solid #00aeff;';
                        }
                        $quote_results .=
                            '<div class="card" style="border-left:1px solid #00aeff;border-right:1px solid #00aeff;' .
                            $bbr .
                            '">
                                <div class= "top-card">
                                    <div class= "insurance-logo">' .
                            $logo .
                            '</div>
                                    <div> Policy Term<br><br><span class= "price" style= "font-size: 36px;">' .
                            $row['year'] .
                            '</span> Yrs</div>
                                    <div> Monthly <br><br><span class= "price" style= "font-size: 36px;">$' .
                            $row['value'] .
                            '</span> </div>
                                    <div class= "cov"> Coverage<br><br><span class= "price" style= "font-size: 36px;"> $' .
                            number_format($coverage) .
                            '</span></div>
                                </div>
                                <div class= "bottom-card">
                                         <a></a><div><a class="con" href="plan-form.php?id=' .
                            $row['id'] .
                            '&coverage=' .
                            $coverage .
                            '&coveragevalue=' .
                            $row['value'] .
                            '&company_name=' .
                            $img['company_name'] .
                            '&company_logo=' .
                            $img['company_logo'] .
                            '&year=' .
                            $row['year'] .
                            '"><button class= "continue">Continue</button></a></div>   
                                </div></div>';
                    }
                    if (
                        $count == $no_of_quotes &&
                        $no_of_quotes > 1
                    ) {
                        $quote_results .= '</div>';
                    }
                    /*if($count==$no_of_quotes){
                                                   $quote_results .='</div>';
                                               }*/
                    if ($yrss == $n_of_years) {
                        $quote_results .=
                            '
                         
                            
                            <!-- FAQ Accordion-->
                            <h1>FAQ</h1><br>
            <div class= "faq">
                           
                        <div class="accordion-tab">
                            <input id="toggle1" type="checkbox" class="accordion-toggle" name="toggle" />
                            <label for="toggle1">What is Term Life Insurance?</label>
                            <div class="accordion-content">
                                <p>Term Life Insurance is the most affordable way to protect your family’s financial security if something were to happen to you. 
                                As the name suggests, you have the option to choose your term length and only buy it for as long as you 
                                need it. The lengths typically available are 10, 15, 20, 25 and 30 years
                                </p>         
                            </div>
                        </div>

                        <div class="accordion-tab">
                            <input id="toggle2" type="checkbox" class="accordion-toggle" name="toggle" />
                            <label for="toggle2">Do I have to have a Medical Exam?</label>
                                <div class="accordion-content">
                                    <p>No medical exam term life insurance available through an accelerated underwriting 
                                    process. This process should not change the cost of monthly premiums, but it might lower the amount
                                     of coverage available.</p>
                                </div>
                        </div>
                               

                        <div class="accordion-tab">
                            <input id="toggle3" type="checkbox" class="accordion-toggle" name="toggle" />
                            <label for="toggle3">What if I have health conditions?</label>
                                <div class="accordion-content">
                                    <p>Great!</p>         
                                </div>
                        </div>
                           
                        <div class="accordion-tab">
                            <input id="toggle4" type="checkbox" class="accordion-toggle" name="toggle" />
                            <label for="toggle4">How much coverage do I need?</label>
                                <div class="accordion-content">
                                    <p>The amount of life insurance needed varies for everyone, but many people aim for 10-12
                                     times their income. You should not only take into account how much life insurance you can afford,
                                      but also who is dependent upon your financial support and what that looks like in both 
                                      the immediate future and down the road. You can use our insurance calculator to get a better 
                                      idea of how much insurance might be right for your situation. Then, we can help you figure out
                                    the amount of coverage you need at a price that fits your budget.</p>         
                                </div>
                            </div>
    </div>                        
                            
                            </div></div>
                            
                            <div class="quote-info-mobile">
                                <h3> How much coverage do I need?</h3><br>
                                <p class= "tip">Financial Planners use a rule of 10 times your annual income for coverage amount. Or you can use our Life Insurance Caculator.</p><br>
                                <p class="partners"> Our Insurance Partners</p><br>
                                <img src="images/svg/companies.svg">
                            </div>                                   
                         
                            
                            </div>';
                    }
                }
            }
        }
    }
}
echo $quote_results;

