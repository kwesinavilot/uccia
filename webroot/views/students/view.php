<?php
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }

    if (isset($set) && $set == false) {
        define('TITLE', "No Student Selected | UCCIA - Put tagline here");
    } else {
        define('TITLE', ucwords($content->firstname) . " " . ucwords($content->lastname) . " | UCCIA - Put tagline here");
    }
    
    if (isset($set) && $set == false) {
        define('HEADER', "No Student Selected");
    } else {
        define('HEADER', ucwords($content->firstname) . " " . ucwords($content->lastname));
    }

    define('EXTRAO', 'No');

    //Load the header and sidebar sections
    $this->load->view('generics/header-sidebar.php');
    //die(print_r($content));
    //die(print_r($_SESSION));
?>

        <aside class="col-lg-12 marg">
            <div class="single-pro-review-area mt-t-30 mg-b-15">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <?php
                            if(isset($set) && $set == false) {
                                echo "<div class='alert alert-warning'>
                                        <strong>You haven't selected a student</strong> 
                                        <p>To view the details of a student, you must first select that student. You can do so by <a href=". base_url() . "students/add>adding the student</a>, if not done already, or use the search bar
                                            above to search for the student.
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
                                                <a class='paddoff col-lg-12 paddoff' href='" . base_url() . "students/edit/" . $content->studentID . "'>Edit Student's Details</a>
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
                                                                <div class="pull-left col-lg-12" duty="student-details">
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
                                                                                <span>INDEX NUMBER:</span> <?php if(!isset($content->index_number)){ echo "";}else {print $content->index_number;} ?>
                                                                            </li>
            
                                                                            <li class="list-group-item">
                                                                                <span>HALL:</span> <?php if(!isset($content->hall)){ echo "";}else {print ucwords($content->hall);} ?>
                                                                            </li>

                                                                            <li class="list-group-item">
                                                                                <span>NATIONALITY:</span> <?php if(!isset($content->nationality)){ echo "";}else {print ucwords($content->nationality);} ?>
                                                                            </li>

                                                                            <li class="list-group-item">
                                                                                <span>PROGRAM:</span> <?php if(!isset($content->name)){ echo "";}else {print ucwords($content->name);} ?>
                                                                            </li>

                                                                            <li class="list-group-item">
                                                                                <span>LEVEL:</span> <?php if(!isset($content->level)){ echo "";}else {print $content->level;} ?>
                                                                            </li>
                                                                        </div>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                             
                                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                <img class="pull-right col-lg-12" src="<?php
                                                                    //Check if there's a profile picture for the user
                                                                    if(isset($content->picture)) {        //Show it if there is
                                                                        if (file_exists("./assets/student_pics/" . $content->picture)) {
                                                                            echo base_url() . "/assets/student_pics/" . $content->picture;
                                                                        } else {                                    //Use default if there isnt
                                                                            echo base_url() . "/assets/img/default.png"; 
                                                                        }
                                                                    } else {                                    //Use default if there isnt
                                                                        echo base_url() . "/assets/img/default.png"; 
                                                                    }
                                                                ?>" style="max-width: 50%;background: white;max-height: 100%;">

                                                                <img class="pull-right col-lg-12" src="<?php
                                                                    //Check if there's a profile picture for the user
                                                                    if(isset($content->picture)) {        //Show it if there is
                                                                        if (file_exists("./assets/qrs/" . $content->qrfile)) {
                                                                            echo base_url() . "/assets/qrs/" . $content->qrfile;
                                                                        } else {                                    //Use default if there isnt
                                                                            echo base_url() . "/assets/img/default.png"; 
                                                                        }
                                                                    } else {                                    //Use default if there isnt
                                                                        echo base_url() . "/assets/img/default.png"; 
                                                                    }
                                                                ?>" style="max-width: 50%;background: white;max-height: 100%;">
                                                            </div>
                                                        </div>

                                                        <div duty="class-description" class="col-lg-12 description">
                                                            <span>DESCRIPTION</span>

                                                            <p>
                                                                <?php 
                                                                    if(empty($content->description)) {
                                                                        echo "There's no description for this class.";
                                                                    } else {
                                                                        echo $content->description;
                                                                    }
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div duty="exam-list" class="class-list product-status-wrap col-lg-12">
                                                        <div class="asset-inner marg-sub">
                                                            <h4>Student's Exams</h4>

                                                            <table class="table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Course Name</th>
                                                                        <th>Course Code</th>
                                                                        <th>Date</th>
                                                                        <th>Venue</th>
                                                                        <th>Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                
                                                                <tbody>
                                                                    <?php
                                                                        //die(print_r($exams));
                                                                        if(empty($exams)) {
                                                                            echo "
                                                                                <tr>
                                                                                    <td colspan='4' style='text-align:center;'>There are no exam entries for this student yet.</td>
                                                                                </tr>
                                                                            ";
                                                                        } else {
                                                                            //die(print_r($exams));
                                                                            foreach ($exams as $index => $exam) {
                                                                                $view = base_url() . 'exams/view/' . $exam->course_code;
                                                                                
                                                                                echo "
                                                                                    <tr>
                                                                                        <td>$index</td>
                                                                                        <td>$exam->course_name</td>
                                                                                        <td>$exam->course_code</td>
                                                                                        <td>$exam->date</td>
                                                                                        <td>$exam->venue</td>
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
                                                                        if(!empty($exams)) {      //Only show results when there are class_students
                                                                            //print "Showing 1 to 15 of " . $total_rows . " students"; 
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

    if ($this->session->flashdata('students_entry_success')) {
        echo "
            <script>
                $.notify('" . $this->session->flashdata('student_entry_success') . "', { position:'top center', className:'success'});
            </script>
        ";
    } else if($this->session->flashdata('details_update_success')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('details_update_success') . "', { position:'top center', className:'success'});
            </script>
        ";
    } else if($this->session->flashdata('details_update_failure')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('details_update_failure') . "', { position:'top center', className:'error'});
            </script>
        ";
    }
?>