<?php
    //Check if there's been a login else go back home
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }
    
    if (isset($set) && $set == false) {
        define('TITLE', "Edit Student's Details | UCCIA - Put tagline here");
    } else {
        define('TITLE', "Edit Student's Details: " . ucwords($content->firstname) . " " . ucwords($content->lastname) . " | UCCIA - Put tagline here");
    }
    
    if (isset($set) && $set == false) {
        define('HEADER', "Edit Student's Details");
    } else {
        define('HEADER', "Edit Student's Details: " . ucwords($content->firstname) . " " . ucwords($content->lastname));
    }

    define('EXTRAO', 'No');

    //Load the header and sidebar sections
    $this->load->view('generics/header-sidebar.php');

    //die("http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
?>

        <section class="col-lg-12 marg">
            <div class="single-pro-review-area mt-t-30 mg-b-15">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-payment-inner-st">
                        
                            <?php
                                if(isset($set) && $set == false) {
                                    echo "<div class='alert alert-warning'>
                                            <strong>You haven't selected a class</strong> 
                                            <p>To edit the details of a student, you must first select that student. You can either <a href=". base_url() . "students/add>add</a> a student or use the search bar
                                                above to search for a student.
                                            </p>
                                        </div>
                                    ";
                                }
                            ?>

                            <ul id="myTabedu1" class="tab-review-design">
                                <li class="active"><a href="#picture"><?php print HEADER; ?></a></li>
                            </ul>

                            <div id="myTabContent" class="tab-content custom-product-edit">
                                <div class="product-tab-list tab-pane fade active in" id="description">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <div id="dropzone1" class="pro-ad addcoursepro">
                                                        <?php 
                                                            $attributes = array('id' => 'add-new-student-form');     //Create main form attributes
                                                            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

                                                            if(isset($set) && $set == false) {
                                                                echo form_open("students/update_details", $attributes);    //Create form and set attributes
                                                            } else {
                                                                echo form_open("students/update_details/$content->studentID", $attributes);    //Create form and set attributes
                                                            }
                                                        ?>
                                                            <div class="marg">
                                                                <div duty="student-deatails" class="shade col-lg-12">
                                                                    <div class="fixed-table-toolbar marg-sub">
                                                                        <!-- Section Header -->
                                                                        <div class="pull-left" style="padding: 0.5%;">
                                                                            <h4 style="margin:0;">Student's Details</h4>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <div class="form-group">
                                                                                <input value="<?php if(!isset($content->firstname)){ echo "";}else {print $content->firstname;} ?>" name="firstname" type="text" class="form-control" placeholder="First Name" max-length="25">
                                                                                <?php echo form_error("firstname"); ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <input value="<?php if(!isset($content->lastname)){ echo "";}else {print ucwords($content->lastname);} ?>" name="lastname" type="text" class="form-control" placeholder="Last Name" max-length="25">
                                                                                <?php echo form_error("lastname"); ?>
                                                                            </div>
                                                                            
                                                                            <div class="form-group res-mg-t-15">
                                                                                <input value="<?php if(!isset($content->other_names)){ echo "";}else {print ucwords($content->other_names);}?>" name="other_names" type="text" class="form-control" placeholder="Other Names" max-length="25">
                                                                                <?php echo form_error("other_names"); ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <input value="<?php if(!isset($content->index_number)){ echo "";}else {print $content->index_number;}?>" name="index_number" type="text" class="form-control" placeholder="Student's Index Number" max-length="10">
                                                                                <?php echo form_error("index_number"); ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <select name="student_class" id="student_class" class="form-control">
                                                                                    <?php                                                                                    
                                                                                        if(!isset($content->class_short)) {
                                                                                            echo "<option value='select'>Student's Class</option>";
                                                                                        } else {
                                                                                            echo "<option value='$content->class_short'>$content->name ($content->level)</option>";

                                                                                            foreach ($classes as $class) {
                                                                                                echo "
                                                                                                    <option id='class' value='$class->class_short'>$class->name ($class->level)</option>
                                                                                                ";
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                </select>
                                                                                <?php echo form_error("student_class"); ?>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <div class="form-group">
                                                                                <select name="hall" id="halls" class="form-control">
                                                                                    <?php
                                                                                        if(!isset($content->hall)) {
                                                                                            echo "<option value='select'>Hall of Affiliation</option>";
                                                                                        } else {
                                                                                            echo "<option value='$content->hall'>$content->hall</option>";

                                                                                            foreach ($halls as $hall) {
                                                                                                echo "
                                                                                                    <option id='degree' value='$hall->name'>$hall->name</option>
                                                                                                ";
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                </select>
                                                                                <?php echo form_error("hall"); ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <input value="<?php if(!isset($content->nationality)){ echo "";}else {print ucwords($content->nationality);}?>" name="nationality" type="text" class="form-control" placeholder="Nationality" max-length="50">
                                                                                <?php echo form_error("nationality"); ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <textarea name="description" max-length="450" placeholder="Further Description (450 max)">
                                                                                    <?php if(!isset($content->description)){ echo "No description for this student";}else {print $content->description;}?>
                                                                                </textarea>
                                                                                <?php echo form_error("description"); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-12" style="margin-top: 2%;">
                                                                            <div class="payment-adress">
                                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Update Student's Details</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        <?php echo form_close(); ?>
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
        </section>
    </div>

<?php
    //Load the footer
    $this->load->view('generics/footer.php');

    if ($this->session->flashdata('details_update_success')) {
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
    } else if ($this->session->flashdata('password_change_success')) {
        echo "
            <script>
                $.notify('" . $this->session->flashdata('password_change_success') . "', { position:'top center', className:'success'});
            </script>
        ";
    } else if($this->session->flashdata('password_change_failure')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('password_change_failure') . "', { position:'top center', className:'error'});
            </script>
        ";
    } else if ($this->session->flashdata('update_picture_success')) {
        echo "
            <script>
                $.notify('" . $this->session->flashdata('update_picture_success') . "', { position:'top center', className:'success'});
            </script>
        ";
    } else if($this->session->flashdata('update_picture_failure')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('update_picture_failure') . "', { position:'top center', className:'error'});
            </script>
        ";
    }
?>