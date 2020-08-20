<?php
    //Check if there's been a login else go back home
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }
    
    define('TITLE', "Dashboard | UCCIA - Put tagline here");
    define('HEADER', "Dashboard");
    define('EXTRAO', 'dash');

    //die(print_r($this->session));
    //die(print_r($dashes));

    //Load the header and sidebar sections
    $this->load->view('generics/header-sidebar.php');

    //die("http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
?>

        <div class="analytics-sparkle-area marg">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line reso-mg-b-30">
                            <div class="analytics-content">
                                <h5>Examinations In Session</h5>
                                <h2 class="tuition-fees">00</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line reso-mg-b-30">
                            <div class="analytics-content">
                                <h5>Total Examinations Written</h5>
                                <h2 class="tuition-fees">500</h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line reso-mg-b-30 table-mg-t-pro dk-res-t-pro-30">
                            <div class="analytics-content">
                                <h5>Total Examinations</h5>
                                <h2 class="tuition-fees"><?php print $dashes['exams']; ?></span></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="analytics-sparkle-line table-mg-t-pro dk-res-t-pro-30">
                            <div class="analytics-content">
                                <h5>Total Invigilators</h5>
                                <h2 class="tuition-fees"><?php print $dashes['invigilators']; ?></span></h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="product-sales-area mg-tb-30" style="margin: 15px 0px;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-9 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-sales-chart">
                            <div class="portlet-title">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                        <div class="caption pro-sl-hd">
                                            <span class="caption-subject"><b>Examinations Currently In Progress</b></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="product-status-wrap" id ="dash-table" style="height: 400px;">
                                <div class="">
                                    <div class="asset-inner marg-sub">
                                        <table class="table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50%;">Course</th>
                                                    <th style="width: 15%;">Venue</th>
                                                    <th style="width: 15%;">Start</th>
                                                    <th style="width: 15%;">Stop</th>
                                                    <th style="width: 20%;">Countdown</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <?php
                                                    //die(print_r($exams));
                                                    if(empty($exams)) {
                                                        // echo "
                                                        //     <tr>
                                                        //         <td colspan='4' style='text-align:center;'>There are no exams in progress.</td>
                                                        //     </tr>
                                                        // ";

                                                        echo "
                                                            <a href=''>
                                                            <tr>
                                                                <td>INF 608</td>
                                                                <td>CELT 5</td>
                                                                <td>11:30pm</td>
                                                                <td>1:30pm</td>
                                                                <td>1:58:45</td>
                                                            </tr>
                                                            </a>

                                                            <a href=''>
                                                            <tr>
                                                                <td>INF 405</td>
                                                                <td>LT 20</td>
                                                                <td>11:30pm</td>
                                                                <td>1:30pm</td>
                                                                <td>1:58:45</td>
                                                            </tr>
                                                            </a>

                                                            <a href=''>
                                                            <tr>
                                                                <td>INF 608</td>
                                                                <td>CELT 5</td>
                                                                <td>11:30pm</td>
                                                                <td>1:30pm</td>
                                                                <td>1:58:45</td>
                                                            </tr>
                                                            </a>

                                                            <a href=''>
                                                            <tr>
                                                                <td>INF 405</td>
                                                                <td>LT 20</td>
                                                                <td>11:30pm</td>
                                                                <td>1:30pm</td>
                                                                <td>1:58:45</td>
                                                            </tr>
                                                            </a>

                                                            <a href=''>
                                                            <tr>
                                                           <td>INF 608</td>
                                                                <td>CELT 5</td>
                                                                <td>11:30pm</td>
                                                                <td>1:30pm</td>
                                                                <td>1:58:45</td>
                                                            </tr>
                                                            </a>
                                                        ";
                                                    } else {
                                                        //die(print_r($exams));
                                                        foreach ($exams as $index => $exam) {
                                                            $view = base_url() . 'exams/view/' . $exam->exam_short;
                                                            
                                                            echo "
                                                                <a href='$view'>
                                                                    <tr>
                                                                        <td>$index</td>
                                                                        <td>$exam->name</td>
                                                                        <td>$exam->level</td>
                                                                        <td>$exam->size</td>
                                                                    </tr>
                                                                </a>
                                                            ";
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row paginate">
                                        <div class="pagination-exp col-lg-5 col-sm-12 col-md-5">
                                            <div style="padding: 7px 0px;">
                                                <?php 
                                                    if(!empty($exams)) {      //Only show results when there are classes
                                                        print "Showing 1 to 15 of " . $total_rows . " classes"; 
                                                    }
                                                ?>
                                            </div>
                                        </div>

                                        <div class="custom-pagination">
                                            <div class="pull-right col-lg-5 col-sm-12 col-md-5">
                                                <?php 
                                                    if(isset($links)) {     //Check if the links are set
                                                        echo $links;        //Print out the links
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 res-mg-t-30 table-mg-t-pro-n tb-sm-res-d-n dk-res-t-d-n">
                            <h3 class="box-title">Total Students</h3>
                            <h2 class="tuition-fees"><?php print $dashes['students']; ?></span></h2>
                        </div>

                        <div class="white-box analytics-info-cs mg-b-10 res-mg-b-30 tb-sm-res-d-n dk-res-t-d-n">
                            <h3 class="box-title">Examination Proportions</h3>
                            <div id="exam-props-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- <div class="calender-area mg-b-15">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="calender-inner">
                            <div id='calendar'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
    </div>
<?php
    //Load the footer
    $this->load->view('generics/footer.php');
?>