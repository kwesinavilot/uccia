<?php
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }

    if (isset($set) && $set == false) {
        define('TITLE', "Edit Class Details | UCCIA - Put tagline here");
    } else {
        define('TITLE', "Edit Class: " . ucwords($content->name) . ", " . $content->degree . " (" . $content->level. ") | UCCIA - Put tagline here");
    }
    
    if (isset($set) && $set == false) {
        define('HEADER', "Edit Class Details");
    } else {
        define('HEADER', "Edit Class: " . $content->name . ", " . $content->degree . " (" . $content->level. ")");
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
                                            <strong>You haven't selected a class</strong> 
                                            <p>To edit the details of a class, you must first select that class. You can do so from the <a href=". base_url() . "classes/all>All Classes</a> page or use the search bar
                                                above to search for a class.
                                            </p>
                                        </div>
                                    ";
                                }
                            ?>

                            <div class="product-payment-inner-st">
                                <ul id="myTabedu1" class="tab-review-design">
                                    <li class="active"><a href=""><?php echo HEADER; ?></a></li>

                                    <div class="add-product col-lg-2 paddoff" style="float: right;">
                                        <a class="paddoff col-lg-12 paddoff" href="<?php echo base_url();?>classes/add">Add A Class</a>
                                    </div>
                                </ul>

                                <div id="myTabContent" class="tab-content custom-product-edit">
                                    <div class="product-tab-list tab-pane fade active in" id="description">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <div id="dropzone1" class="pro-ad addcoursepro">
                                                        <?php 
                                                            $attributes = array('id' => 'edit-class-form');     //Create main form attributes
                                                            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

                                                            if(!isset($content)) {
                                                                echo form_open("classes/update/unclassed", $attributes);    //Create form and set attributes that shows no class is chosen
                                                            } else {
                                                                echo form_open("classes/update/" . $content->class_short, $attributes);    //Create form and set attributes
                                                            }
                                                        ?>
                                                            <div class="row">
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="form-group">
                                                                        <select name="degree" id="degree" class="form-control">
                                                                            <?php
                                                                                $degrees = array("BA" => 'Bachelor of Arts (B.A)', "BSc" => 'Bachelor of Science (B.Sc)', "BEd" => 'Bachelor of Education (B.Ed)', "BCom" => 'Bachelor of Commerce (B.Com)');

                                                                                if(!isset($content->degree)) {
                                                                                    echo "<option value='select'>Select degree</option>";
                                                                                } else {
                                                                                    foreach ($degrees as $index => $degree) {
                                                                                        echo "
                                                                                            <option id='degree' value='$index'>$degree</option>
                                                                                        ";
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        <?php echo form_error("degree"); ?>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input name="class_name" type="text" class="form-control" placeholder="Class Name" max-length="100" value="<?php if(!isset($content->name)){ echo "";}else {echo $content->name;} ?>">
                                                                        <?php echo form_error("class_name"); ?>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input name="class_number" type="number" class="form-control" placeholder="Class Size or Number" min-length="1" value="<?php if(!isset($content->size)){ echo "";}else {echo $content->size;} ?>">
                                                                        <?php echo form_error("class_number"); ?>
                                                                    </div>
                                                                    
                                                                    <div class="form-group">
                                                                        <select id="level" name="level" class="form-control">
                                                                            <?php
                                                                                if(!isset($content->size)) {
                                                                                    echo "<option value='select'>Select level</option>";
                                                                                } else {
                                                                                    echo "<option value='$content->level'>$content->level</option>";

                                                                                    for ($i=1; $i < 5; $i++) {
                                                                                        $idd = $i * 100;            //Multiply whatever value $i is by 100

                                                                                        echo "
                                                                                            <option id='level' value='$idd'>$idd</option>
                                                                                        ";          //Use that number as the level
                                                                                    }
                                                                                }
                                                                            ?>
                                                                        </select>
                                                                        <?php echo form_error("level"); ?>
                                                                    </div>

                                                                    <div class="form-group res-mg-t-15">
                                                                        <input name="department" type="text" class="form-control" placeholder="Department" max-length="100" value="<?php if(!isset($content->department)){ echo "";}else{echo $content->department;} ?>">
                                                                        <?php echo form_error("department"); ?>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                                    <div class="form-group">
                                                                        <input name="school" type="text" class="form-control" placeholder="School" max-length="100" value="<?php if(!isset($content->school)){ echo "";}else {echo $content->school;} ?>">
                                                                        <?php echo form_error("school"); ?>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <input name="college" type="text" class="form-control" placeholder="College or Faculty" max-length="100" value="<?php if(!isset($content->college)){ echo "";}else {echo $content->college;} ?>">
                                                                        <?php echo form_error("college"); ?>
                                                                    </div>

                                                                    <div class="form-group">
                                                                        <textarea name="description" max-length="450" placeholder="Further Description (450 max)">
                                                                            <?php if(!isset($content->description)){ echo "";}else {print $content->description;} ?>
                                                                        </textarea>
                                                                        <?php echo form_error("description"); ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-lg-12" style="margin-top: 2%;">
                                                                    <div class="payment-adress">
                                                                        <button type="submit" class="btn btn-primary waves-effect waves-light">Update Class Details</button>
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