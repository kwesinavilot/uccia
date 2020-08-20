<?php
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }

    if (isset($set) && $set == false) {
        define('TITLE', "No Invigilator Selected | UCCIA - Put tagline here");
    } else {
        define('TITLE', "Invigilator: " . ucwords($content->firstname) . " " . ucwords($content->lastname) . " | UCCIA - Put tagline here");
    }
    
    if (isset($set) && $set == false) {
        define('HEADER', "No Invigilator Selected");
    } else {
        define('HEADER', "Invigilator: " . ucwords($content->firstname) . " " . ucwords($content->lastname));
    }

    define('EXTRAO', 'No');

    //Load the header and sidebar sections
    $this->load->view('generics/header-sidebar.php');
    //die(print_r($content));
?>

        <aside class="col-lg-12 marg">
            <div class="single-pro-review-area mt-t-30 mg-b-15">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <?php
                            if(isset($set) && $set == false) {
                                echo "<div class='alert alert-warning'>
                                        <strong>You haven't selected an invigilator</strong> 
                                        <p>To view the details of an invigilator, you must first select that invigilator. You can do so by <a href=". base_url() . "invigilators/add>adding the invigilator</a>, if not done already, or use the search bar
                                            above to search for the invigilator.
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
                                        echo "<div class='add-product col-lg-3 paddoff' style='float: right;'>
                                                <a class='paddoff col-lg-12 paddoff' href='" . base_url() . "invigilators/edit/" . $content->invigilatorID . "'>Edit Invigilator's Details</a>
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
                                                        <div class="row">
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <div class="pull-left col-lg-12" duty="exam-details">
                                                                    <ul class="list-group list-group-vertical" style="font-size: 16px;">
                                                                        <div class="top-info">
                                                                            <li class="list-group-item">
                                                                                <span>FIRST NAME:</span> <?php if(!isset($content->firstname)){ echo "";}else {print $content->firstname;} ?>
                                                                            </li>

                                                                            <li class="list-group-item">
                                                                                <span>LAST NAME:</span> <?php if(!isset($content->lastname)){ echo "";}else {print ucwords($content->lastname);} ?>
                                                                            </li>

                                                                            <li class="list-group-item">
                                                                                <span>OTHER NAMES:</span> <?php if(!isset($content->other_names)){ echo "";}else {print ucwords($content->other_names);} ?>
                                                                            </li>

                                                                            <li class="list-group-item">
                                                                                <span>INVIGILATOR'S NUMBER:</span> <?php if(!isset($content->invigilatorID)){ echo "";}else {print $content->invigilatorID;} ?>
                                                                            </li>
            
                                                                            <li class="list-group-item">
                                                                                <span>DEPARTMENT:</span> <?php if(!isset($content->department)){ echo "";}else {print ucwords($content->department);} ?>
                                                                            </li>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                             
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <img class="pull-right col-lg-12" src="<?php
                                                                    //Check if there's a profile picture for the user
                                                                    if(isset($content->picture)) {        //Show it if there is
                                                                        if (file_exists("./assets/invigilator_pics/" . $content->picture)) {
                                                                            echo base_url() . "/assets/invigilator_pics/" . $content->picture;
                                                                        } else {                                    //Use default if there isnt
                                                                            echo base_url() . "/assets/img/default.png"; 
                                                                        }
                                                                    } else {                                    //Use default if there isnt
                                                                        echo base_url() . "/assets/img/default.png"; 
                                                                    }
                                                                ?>" style="max-width: 40%;background: white;max-height: 100%;">
                                                            </div>
                                                        </div>

                                                        <div duty="invigilator-description" class="col-lg-12 description">
                                                            <span>DESCRIPTION</span>

                                                            <p>
                                                                <?php 
                                                                    if(empty($content->description)) {
                                                                        echo "There's no description for this invigilator.";
                                                                    } else {
                                                                        echo $content->description;
                                                                    }
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div duty="exam-list" class="class-list product-status-wrap col-lg-12">
                                                        <div class="asset-inner marg-sub">
                                                            <h4>Invigilator's Exams</h4>

                                                            <table class="table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Exam Name</th>
                                                                        <th>Exam Date</th>
                                                                        <th>Exam Venue</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                
                                                                <tbody>
                                                                    <?php
                                                                        //die(print_r($invigilators_exam));
                                                                        if(empty($invigilator_exams)) {
                                                                            echo "
                                                                                <tr>
                                                                                    <td colspan='5' style='text-align:center;'>There are no exam entries for this invigilator yet.</td>
                                                                                </tr>
                                                                            ";
                                                                        } else {
                                                                            //die(print_r($invigilators_exam));
                                                                            foreach ($invigilator_exams as $index => $exam) {
                                                                                $view = base_url() . 'exams/view/' . $exam->exam_short;
                                                                                
                                                                                echo "
                                                                                    <tr>
                                                                                        <td>$index</td>
                                                                                        <td>$exam->name</td>
                                                                                        <td>$exam->invigilatorID</td>
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
                                                                        if(!empty($invigilator_exams)) {      //Only show results when there are invigilator_exam
                                                                            print "Showing 1 to 15 of " . $total_rows . " exams"; 
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
?>