<?php
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }

    if (isset($set) && $set == false) {
        define('TITLE', "No Class Selected | UCCIA - Put tagline here");
    } else {
        define('TITLE', ucwords($class_details->name) . ", " . $class_details->degree . " (" . $class_details->level. ") | UCCIA - Put tagline here");
    }
    
    if (isset($set) && $set == false) {
        define('HEADER', "No Class Selected");
    } else {
        define('HEADER', $class_details->name . ", " . $class_details->degree . " (" . $class_details->level. ")");
    }

    define('EXTRAO', 'No');

    //Load the header and sidebar sections
    $this->load->view('generics/header-sidebar.php');
    //die(print_r($class_details));
?>

        <aside class="col-lg-12 marg">
            <div class="single-pro-review-area mt-t-30 mg-b-15">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

                        <?php
                            if(isset($set) && $set == false) {
                                echo "<div class='alert alert-warning'>
                                        <strong>You haven't selected a class</strong> 
                                        <p>To view the details of a class, you must first select that class. You can do so from the <a href=". base_url() . "classes/all>All Classes</a> page or use the search bar
                                            above to search for a class.
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
                                                <a class='paddoff col-lg-12 paddoff' href='" . base_url() . "classes/edit/" . $class_details->class_short . "'>Edit This Class</a>
                                            </div>
                                        ";
                                    }
                                ?>
                            </ul>

                            <div id="myTabstu$student" class="tab-stu$student custom-product-edit">
                                <div class="product-tab-list tab-pane fade active in" id="description">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="review-stu$student-section">
                                                <div id="dropzone1" class="pro-ad addcoursepro">
                                                    <div duty="class-details" class="class-details marg-sub">
                                                        <div duty="class-basics" class="pull-left col-lg-12">
                                                            <ul class="list-group list-group-horizontal" style="font-size: 16px;">
                                                                <div class="top-info">
                                                                    <li class="list-group-item">
                                                                        <span>LEVEL:</span> <?php if(!isset($class_details->level)){ echo "";}else {print $class_details->level;} ?>
                                                                    </li>

                                                                    <li class="list-group-item">
                                                                        <span>SIZE:</span> <?php if(!isset($class_details->size)){ echo "";}else {print ucwords($class_details->size);} ?>
                                                                    </li>

                                                                    <li class="list-group-item">
                                                                        <span>SCHOOL:</span> <?php if(!isset($class_details->school)){ echo "";}else {print ucwords($class_details->school);} ?>
                                                                    </li>
                                                                </div>

                                                                <div class="mid-info">
                                                                    <li class="list-group-item">
                                                                        <span>DEPARTMENT:</span> <?php if(!isset($class_details->department)){ echo "";}else {print ucwords($class_details->department);} ?>
                                                                    </li>

                                                                    <li class="list-group-item">
                                                                        <span>COLLEGE:</span> <?php if(!isset($class_details->college)){ echo "";}else {print ucwords($class_details->college);} ?>
                                                                    </li>
                                                                </div>
                                                            </ul> 
                                                        </div>

                                                        <div duty="class-description" class="col-lg-12 description">
                                                            <span>DESCRIPTION</span>

                                                            <p>
                                                                <?php 
                                                                    if(empty($class_details->description)) {
                                                                        echo "There's no description for this class.";
                                                                    } else {
                                                                        echo $class_details->description;
                                                                    }
                                                                ?>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div duty="class-list" class="class-list product-status-wrap col-lg-12">
                                                        <div class="asset-inner marg-sub">
                                                            <h4>Class Students</h4>

                                                            <table class="table-hover">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width: 5%;">#</th>
                                                                        <th style="width: 30%;">Picture</th>
                                                                        <th style="width: 35%;">Student's Name</th>
                                                                        <th style="width: 15%;">Index Number</th>
                                                                        <th style="width: 5%;">Actions</th>
                                                                    </tr>
                                                                </thead>
                                                                
                                                                <tbody>
                                                                    <?php
                                                                        //die(print_r($class_students));
                                                                        if(empty($class_students)) {
                                                                            echo "
                                                                                <tr>
                                                                                    <td colspan='5' style='text-align:center;'>There are no student entries for this class yet.</td>
                                                                                </tr>
                                                                            ";
                                                                        } else {
                                                                            //die(print_r($class_students));
                                                                            foreach ($class_students as $index => $student) {
                                                                                //die(print_r($student));
                                                                                $view = base_url() . 'students/view/' . $student->studentID;
                                                                                $name = $student->firstname . " " . $student->lastname;

                                                                                if (isset($student->other_names) && $student->other_names != "") {
                                                                                    $name .= ", " . $student->other_names;
                                                                                }

                                                                                //Check if there's a profile picture for the student
                                                                                if(isset($student->picture)) {        //Show it if there is
                                                                                    if (file_exists("./assets/student_pics/" . $student->picture)) {
                                                                                        $picture = base_url() . "/assets/student_pics/" . $student->picture;
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
                                                                                        <td>$student->index_number</td>
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
                                                                        if(!empty($class_students)) {      //Only show results when there are class_students
                                                                            print "Showing 1 to 15 of " . $total_rows . " students"; 
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

    if ($this->session->flashdata('class_update_success')) {
        echo "
            <script>
                $.notify('" . $this->session->flashdata('class_update_success') . "', { position:'top center', className:'success'});
            </script>
        ";
    } else if($this->session->flashdata('class_update_failure')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('class_update_failure') . "', { position:'top center', className:'error'});
            </script>
        ";
    }
?>