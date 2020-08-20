<?php
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }

    if (isset($set) && $set == false) {
        define('TITLE', "No Exam Selected | UCCIA - Put tagline here");
    } else {
        define('TITLE', $exam_details->course_code . " (" . ucwords($exam_details->course_name) . ") | UCCIA - Put tagline here");
    }
    
    if (isset($set) && $set == false) {
        define('HEADER', "No Exam Selected");
    } else {
        define('HEADER', $exam_details->course_code . " (" . ucwords($exam_details->course_name) . ")");
    }

    define('EXTRAO', 'No');

    //Load the header and sidebar sections
    $this->load->view('generics/header-sidebar.php');
    //die(print_r($exam_details));
?>

        <aside class="col-lg-12 marg">
            <div class="single-pro-review-area mt-t-30 mg-b-15">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <?php
                            if(isset($set) && $set == false) {
                                echo "<div class='alert alert-warning'>
                                            <strong>You haven't selected an exam</strong> 
                                            <p>To edit the details of an exam, you must first select that exam. You can do so from the <a href=". base_url() . "exams/all>All Exams</a> page or use the search bar
                                                above to search for an exam.
                                            </p>
                                    </div>
                                ";
                            }
                        ?>

                        <div class="product-payment-inner-st">
                            <ul id="myTabedu1" class="tab-review-design">
                                <li class="active"><a href=""><?php print HEADER; ?></a></li>

                                <?php
                                    if(!isset($set)) {
                                        echo "<div class='add-product col-lg-2 paddoff' style='float: right;'>
                                                <a class='paddoff col-lg-12 paddoff' href='" . base_url() . "exams/edit/" . $exam_details->course_code . "'>Edit This Exam</a>
                                            </div>
                                        ";
                                    }
                                ?>
                            </ul>

                            <div id="myTabContent" class="tab-content custom-product-edit">
                                <div class="product-tab-list tab-pane fade active in" id="description">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="review-content-section">
                                                <div id="dropzone1" class="pro-ad addcoursepro">
                                                    <div duty="class-details" class="class-details marg-sub">
                                                        <div duty="class-basics" class="pull-left col-lg-12">
                                                            <ul class="list-group list-group-horizontal" style="font-size: 16px;">
                                                                <div class="top-info">
                                                                    <li class="list-group-item" style="width: 50% !important;">
                                                                        <span>DATE:</span> <?php if(!isset($exam_details->date)){ echo "";}else {print $exam_details->date;} ?>
                                                                    </li>
                                                                </div>

                                                                <div class="top-info">
                                                                    <li class="list-group-item" style="width: 50% !important; text-align:left !important">
                                                                        <span>COURSE CODE:</span> <?php if(!isset($exam_details->course_code)){ echo "";}else {print ucwords($exam_details->course_code);} ?>
                                                                    </li>

                                                                    <li class="list-group-item" style="width: 50% !important;text-align: left;">
                                                                        <span>EXAM VENUE:</span> <?php if(!isset($exam_details->venue)){ echo "";}else {print ucwords($exam_details->venue);} ?>
                                                                    </li>
                                                                </div>

                                                                <div class="mid-info">
                                                                    <li class="list-group-item" style="width: 50% !important;">
                                                                        <span>COURSE NAME:</span> <?php if(!isset($exam_details->course_name)){ echo "";}else {print $exam_details->course_name;} ?>
                                                                    </li>

                                                                    <li class="list-group-item" style="width: 50% !important;  text-align:left !important">
                                                                        <span>START TIME:</span> <?php if(!isset($exam_details->start_time)){ echo "";}else {print ucwords($exam_details->start_time);} ?>
                                                                    </li>
                                                                </div>

                                                                <div class="mid-info">
                                                                    <li class="list-group-item" style="width: 50% !important; text-align:left !important">
                                                                        <span>CLASS:</span> <?php if(!isset($exam_details->name)){ echo "";}else {print ucwords($exam_details->name);} ?>
                                                                    </li>

                                                                    <li class="list-group-item" style="width: 50% !important;  text-align:left !important">
                                                                        <span>END TIME:</span> <?php if(!isset($exam_details->close_time)){ echo "";}else {print ucwords($exam_details->close_time);} ?>
                                                                    </li>
                                                                </div>
                                                            </ul> 
                                                        </div>

                                                        <div duty="class-description" class="col-lg-12 description">
                                                            <span>DESCRIPTION</span>

                                                            <p>
                                                                <?php 
                                                                    if(empty($exam_details->description)) {
                                                                        echo "There's no description for this exam.";
                                                                    } else {
                                                                        echo $exam_details->description;
                                                                    }
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div duty="class-list" class="class-list product-status-wrap col-lg-12">
                                                        <div class="asset-inner marg-sub">
                                                            <h4>Exam Invigilators</h4>

                                                            <table class="table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 5%;">#</th>
                                                                        <th style="width: 30%;">Picture</th>
                                                                        <th style="width: 35%;">Invigilator's Name</th>
                                                                        <th style="width: 25%;">Department</th>
                                                                        <th style="width: 5%;">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                
                                                                <tbody>
                                                                    <?php
                                                                        //die(print_r($exam_invigilators));
                                                                        if(empty($exam_invigilators)) {
                                                                            echo "
                                                                                <tr>
                                                                                    <td colspan='4' style='text-align:center;'>There are no invigilator entries for this exam yet.</td>
                                                                                </tr>
                                                                            ";
                                                                        } else {
                                                                            //die(print_r($exam_invigilators));
                                                                            foreach ($exam_invigilators as $index => $invigilator) {
                                                                                $view = base_url() . 'invigilators/view/' . $invigilator->invigilatorID;
                                                                                $name = $invigilator->firstname . " " . $invigilator->lastname;

                                                                                if (isset($invigilator->other_names) && $invigilator->other_names != "") {
                                                                                    $name .= ", " . $invigilator->other_names;
                                                                                }

                                                                                //Check if there's a profile picture for the invig$invigilator
                                                                                if(isset($invigilator->picture)) {        //Show it if there is
                                                                                    if (file_exists("./assets/invigilator_pics/" . $invigilator->picture)) {
                                                                                        $picture = base_url() . "/assets/invigilator_pics/" . $invigilator->picture;
                                                                                    } else {                                    //Use default if there isnt
                                                                                        $picture = base_url() . "/assets/img/default.png"; 
                                                                                    }
                                                                                } else {                                    //Use default if there isnt
                                                                                    $picture = base_url() . "/assets/img/default.png"; 
                                                                                }
                                                                                
                                                                                echo "
                                                                                    <tr>
                                                                                        <td>$index</td>

                                                                                        <td>
                                                                                            <img class='col-lg-12'
                                                                                                src='$picture'
                                                                                            style='width: 25% !important;height: 100%;'>
                                                                                        </td>

                                                                                        <td>$name</td>
                                                                                        <td>$invigilator->department</td>
                                                                                        <td>
                                                                                            <a href='$view'>
                                                                                                <button data-toggle='tooltip' title='View' class='pd-setting-ed'>
                                                                                                    <i class='fa fa-pencil-square-o' aria-hidden='true'></i>
                                                                                                </button>
                                                                                            </a>
                                                                                        </td>
                                                                                    </tr>
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
                                                                        if(!empty($exam_invigilatorss)) {      //Only show results when there are exam_invigilators
                                                                            print "Showing 1 to 15 of " . $total_rows . " invigilators"; 
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

<?php
    //Load the footer
    $this->load->view('generics/footer.php');

    if ($this->session->flashdata('exam_update_success')) {
        echo "
            <script>
                $.notify('" . $this->session->flashdata('exam_update_success') . "', { position:'top center', className:'success'});
            </script>
        ";
    } else if($this->session->flashdata('exam_update_failure')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('exam_update_failure') . "', { position:'top center', className:'error'});
            </script>
        ";
    }
?>