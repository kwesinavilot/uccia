<?php
    //Check if there's been a login else go back home
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }
    
    define('TITLE', "Add A New Student | UCCIA - Put tagline here");
    define('HEADER', "Add New Student");
    define('EXTRAO', 'upload');

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

                            <div class="fixed-table-toolbar marg-sub">
                                <!-- Section Header -->
                                <div class="pull-left" style="padding: 2% 1%;">
                                    <h4 style="margin:0;">Student's Picture</h4>
                                </div>
                            </div>

                            <div id="myTabContent" class="tab-content custom-product-edit">
                                <div class="product-tab-list tab-pane fade active in" id="picture">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <div id="dropzone1" class="pro-ad addcoursepro">
                                                        <?php 
                                                            $attributes = array('id' => 'add-new-student-form');     //Create main form attributes
                                                            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
                                                            echo form_open_multipart("students/student_picture", $attributes);    //Create form and set attributes
                                                            if(isset($error)) {echo $error;}
                                                        ?>

                                                            <div class="marg">
                                                                <div duty="student-picture" class="shade col-lg-12">
                                                                    <div class="main-entry-form row">
                                                                                    <div class="top-entry col-lg-12 marg-sub">
                                                                                        <div class="pull-right col-lg-8" style="float:right;">
                                                                                            <label class="picture-label col-lg-12">Upload Student's Image</label>
                                                                                            <div class="col-lg-8">
                                                                                                <div class="fileupload fileupload-new" data-provides="fileupload">
                                                                                                    <input type="hidden" value="" name="hidden">

                                                                                                    <div class="fileupload-new thumbnail" style="width: 250px; height: 200px;">
                                                                                                        <img src="" alt="" />
                                                                                                    </div>

                                                                                                    <div class="fileupload-preview fileupload-exists thumbnail" style="max-height: 150px; line-height: 20px;">
                                                                                                    </div>

                                                                                                    <div>
                                                                                                        <span class="btn btn-theme02 btn-file">
                                                                                                            <span class="fileupload-new">
                                                                                                                <i class="fa fa-paperclip"></i> Select image
                                                                                                            </span>

                                                                                                            <span class="fileupload-exists">
                                                                                                                <i class="fa fa-undo"></i> Change
                                                                                                            </span>

                                                                                                            <input type="file" class="default" id="student_picture" name="student_picture"/>
                                                                                                        </span>

                                                                                                        <!-- <span class="btn btn-theme04 fileupload-exists" data-dismiss="fileupload">
                                                                                                            <i class="fa fa-trash-o"></i> Remove
                                                                                                        </span> -->
                                                                                                    </div>
                                                                                                </div>

                                                                                                <span class="p-label p-label-info">NOTE!</span>
                                                                                                <small>
                                                                                                    Image previews are supported by latest Firefox, Chrome, Opera,
                                                                                                    Safari and Internet Explorer 10 only
                                                                                                </small>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-lg-12" style="margin-top: 2%;">
                                                                            <div class="payment-adress">
                                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Upload & Continue</button>
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

    if($this->session->flashdata('students_entry_failure')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('students_entry_failure') . "', { position:'top center', className:'error'});
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