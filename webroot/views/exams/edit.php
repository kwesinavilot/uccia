<?php
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }

    if (isset($set) && $set == false) {
        define('TITLE', "Edit Exam Details | UCCIA - Put tagline here");
    } else {
        define('TITLE', "Edit Exam: " . $content->course_code . " (" . ucwords($content->course_name) . ") | UCCIA - Put tagline here");
    }
    
    if (isset($set) && $set == false) {
        define('HEADER', "Edit Exam Details");
    } else {
        define('HEADER', "Edit Exam: " . $content->course_code . " (" . ucwords($content->course_name) . ")");
    }

    define('EXTRAO', 'duallist');

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
                                    <li class="active"><a href=""><?php echo HEADER; ?></a></li>

                                    <div class="add-product col-lg-2 paddoff" style="float: right;">
                                        <a class="paddoff col-lg-12 paddoff" href="<?php echo base_url();?>exams/add">Add An Exam</a>
                                    </div>
                                </ul>

                                <div id="myTabContent" class="tab-content custom-product-edit">
                                    <div class="product-tab-list tab-pane fade active in" id="description">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <div id="dropzone1" class="pro-ad addcoursepro">
                                                        <?php 
                                                            $attributes = array('class' => 'wizard-big', 'id' => 'form');     //Create main form attributes
                                                            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
                                                            echo form_open("exams/edit_exam", $attributes);    //Create form and set attributes
                                                        ?>
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="form-group">
                                                                        <input name="exam_date" type="date" class="form-control" value="<?php if(!isset($content->date)){ echo "";}else{echo $content->date;} ?>" placeholder="Exam Date">
                                                                        <?php echo form_error("exam_date"); ?>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input name="course_name" type="text" class="form-control" value="<?php if(!isset($content->course_name)){ echo "";}else{echo $content->course_name;} ?>" placeholder="Course or Exam Name" max-length="100">
                                                                        <?php echo form_error("course_name"); ?>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input name="course_code" type="text" class="form-control" value="<?php if(!isset($content->course_code)){ echo "";}else{echo $content->course_code;} ?>" placeholder="Course Code" min-length="7">
                                                                        <?php echo form_error("course_code"); ?>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input name="start_time" type="time" class="form-control" value="<?php if(!isset($content->start_time)){ echo "";}else{echo $content->start_time;} ?>" placeholder="Start Time">                                                                        
                                                                        <?php echo form_error("start_time"); ?>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="form-group">
                                                                        <select name="program" id="program" class="form-control" value="<?php echo set_value('program'); ?>">
                                                                            <?php
                                                                                echo "<option value='$content->class_short'>$content->name</option>";

                                                                                foreach ($classes as $class) {
                                                                                    echo "
                                                                                        <option id='class' value='$class->class_short'>$class->name ($class->level)</option>
                                                                                    ";
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        <?php echo form_error("program"); ?>
                                                                    </div>

                                                                    <div class="form-group res-mg-t-15">
                                                                        <input name="venue" type="text" class="form-control" value="<?php if(!isset($content->venue)){ echo "";}else{echo $content->venue;} ?>" placeholder="Exam Venue" max-length="100">
                                                                        <?php echo form_error("venue"); ?>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input name="end_time" type="time" class="form-control" value="<?php if(!isset($content->close_time)){ echo "";}else{echo $content->close_time;} ?>" placeholder="End Time">
                                                                        <?php echo form_error("end_time"); ?>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <textarea name="description" max-length="450" value="<?php if(!isset($content->description)){ echo "";}else{echo $content->description;} ?>" placeholder="Further Description (450 max)"></textarea>
                                                                        <?php echo form_error("description"); ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="paddoff col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                    <div class="sparkline10-list">
                                                                        <div class="sparkline10-hd">
                                                                            <div class="main-sparkline10-hd" style="padding: 2% 0%;">
                                                                                <h4 style="margin:0;">Exam Invigilators</h4>
                                                                                <?php echo form_error("invigilators[]"); ?>
                                                                            </div>
                                                                        </div>
                                                                        
                                                                        <div class="sparkline10-graph">
                                                                            <div class="basic-login-form-ad">
                                                                                <div class="row">
                                                                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                                                        <div class="dual-list-box-inner">
                                                                                            <select name="invigilators[]" id="invigilators" class="form-control dual_select" multiple="multiple">
                                                                                                <?php
                                                                                                    foreach ($invigilators as $invigilator) {
                                                                                                        $invigilator->name = $invigilator->firstname . " " . $invigilator->lastname;
                                                                                                        echo "
                                                                                                            <option id='class' value='$invigilator->invigilatorID'>$invigilator->name</option>
                                                                                                        ";
                                                                                                    }
                                                                                                ?>
                                                                                            </select>
                                                                                            <?php echo form_error("invigilators"); ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-12" style="margin-top: 2%;">
                                                                    <div class="payment-adress">
                                                                        <button type="submit" id="submit" class="btn btn-primary waves-effect waves-light">Update Exam</button>
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
        </aside>
    </div>

<?php
    $this->load->view('generics/footer.php');
?>