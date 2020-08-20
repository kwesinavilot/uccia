<?php
    //Check if there's been a login else go back home
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }
    
    define('TITLE', "Add A New Student | UCCIA - Put tagline here");
    define('HEADER', "Add New Student");
    define('EXTRAO', 'No');

    //die(print_r($this->session));

    //Load the header and sidebar sections
    $this->load->view('generics/header-sidebar.php');

    //die("http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
?>

        <section class="col-lg-12 marg">
            <div class="single-pro-review-area mt-t-30 mg-b-15">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="product-payment-inner-st">
                            <ul id="myTabedu1" class="tab-review-design">
                                <li class="active"><a href="#picture">Add A New Student</a></li>
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
                                                            echo form_open("students/student_details", $attributes);    //Create form and set attributes
                                                            if(isset($error)) {echo $error;}
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
                                                                                <input value="<?php echo set_value('firstname');?>" name="firstname" type="text" class="form-control" placeholder="First Name" max-length="25">
                                                                                <?php echo form_error("firstname"); ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <input value="<?php echo set_value('lastname');?>" name="lastname" type="text" class="form-control" placeholder="Last Name" max-length="25">
                                                                                <?php echo form_error("lastname"); ?>
                                                                            </div>
                                                                            
                                                                            <div class="form-group res-mg-t-15">
                                                                                <input value="<?php echo set_value('other_names');?>" name="other_names" type="text" class="form-control" placeholder="Other Names" max-length="25">
                                                                                <?php echo form_error("other_names"); ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <input value="<?php echo set_value('index_number');?>" name="index_number" type="text" class="form-control" placeholder="Student's Index Number" max-length="10">
                                                                                <?php echo form_error("index_number"); ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <select name="student_class" id="student_class" class="form-control">
                                                                                    <?php
                                                                                        echo "<option value='select'>Program or Class</option>";

                                                                                        foreach ($classes as $class) {
                                                                                            echo "
                                                                                                <option id='class' value='$class->class_short'>$class->name ($class->level)</option>
                                                                                            ";
                                                                                        }
                                                                                    ?>
                                                                                </select>
                                                                                <?php echo form_error("hall"); ?>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                            <div class="form-group">
                                                                                <select name="hall" id="halls" class="form-control">
                                                                                    <?php
                                                                                        echo "<option value='select'>Hall of Affiliation</option>";

                                                                                        foreach ($halls as $hall) {
                                                                                            echo "
                                                                                                <option id='degree' value='$hall->name'>$hall->name</option>
                                                                                            ";
                                                                                        }
                                                                                    ?>
                                                                                </select>
                                                                                <?php echo form_error("hall"); ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <input value="<?php echo set_value('nationality');?>" name="nationality" type="text" class="form-control" placeholder="Nationality" max-length="50">
                                                                                <?php echo form_error("nationality"); ?>
                                                                            </div>

                                                                            <div class="form-group">
                                                                                <textarea name="description" max-length="450" placeholder="Further Description (450 max)"></textarea>
                                                                                <?php echo form_error("description"); ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-12" style="margin-top: 2%;">
                                                                            <div class="payment-adress">
                                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Add Student</button>
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