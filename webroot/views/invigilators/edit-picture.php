<?php
    //Check if there's been a login else go back home
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }
    
    if (isset($set) && $set == false) {
        define('TITLE', "No Invigilator Selected | UCCIA - Put tagline here");
    } else {
        define('TITLE', "Edit Invigilator Details: " . ucwords($content->firstname) . " " . ucwords($content->lastname) . " | UCCIA - Put tagline here");
    }
    
    if (isset($set) && $set == false) {
        define('HEADER', "No Invigilator Selected");
    } else {
        define('HEADER', ucwords($content->firstname) . " " . ucwords($content->lastname));
    }

    define('EXTRAO', 'upload');

    //Load the header and sidebar sections
    $this->load->view('generics/header-sidebar.php');
    //die(print_r($error));
?>

        <section class="col-lg-12 marg">
            <div class="single-pro-review-area mt-t-30 mg-b-15">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            
                            <?php
                                if(isset($set) && $set == false) {
                                    echo "<div class='alert alert-warning'>
                                            <strong>You haven't selected an invigilator</strong> 
                                            <p>To edit the details of an invigilator, you must first select that invigilator. You can either <a href=". base_url() . "invigilators/add>add</a> an invigilator or use the search bar
                                                above to search for an invigilator.
                                            </p>
                                        </div>
                                    ";
                                }
                            ?>

                        <div class="product-payment-inner-st">
                            <ul id="myTabedu1" class="tab-review-design">
                                <li class="active"><a href="#picture">Edit Invigilator: <?php print HEADER; ?></a></li>
                            </ul>

                            <div class="fixed-table-toolbar marg-sub">
                                <!-- Section Header -->
                                <div class="pull-left" style="padding: 2% 1%;">
                                    <h4 style="margin:0;">Invigilator's Picture</h4>
                                </div>
                            </div>

                            <div id="myTabContent" class="tab-content custom-product-edit">
                                <div class="product-tab-list tab-pane fade active in" id="picture">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="review-content-section">
                                                    <div id="dropzone1" class="pro-ad addcoursepro">
                                                        <?php 
                                                            $attributes = array('id' => 'add-new-invigilator-form');     //Create main form attributes
                                                            $this->form_validation->set_error_delimiters('<p class="error">', '</p>');

                                                            if(isset($set) && $set == false) {
                                                                echo form_open_multipart("invigilators/update_picture", $attributes);    //Create form and set attributes
                                                            } else {
                                                                echo form_open_multipart("invigilators/update_picture/$content->invigilatorID", $attributes);    //Create form and set attributes
                                                            }

                                                            if(isset($error)) {print_r($error);}
                                                        ?>

                                                            <div class="marg">
                                                                <div duty="invigilator-picture" class="shade col-lg-12">
                                                                    <div class="main-entry-form row">
                                                                                    <div class="top-entry col-lg-12 marg-sub">
                                                                                        <div class="pull-left col-lg-5" style="float:left;">
                                                                                            <img class="pull-right col-lg-12" src="<?php
                                                                                                                                    //Check if there's a profile picture for the invigilator
                                                                                                                                    if(isset($content->picture)) {        //Show it if there is
                                                                                                                                        if (file_exists("./assets/invigilator_pics/" . $content->picture)) {
                                                                                                                                            echo base_url() . "/assets/invigilator_pics/" . $content->picture;
                                                                                                                                        } else {                                    //Use default if there isnt
                                                                                                                                            echo base_url() . "/assets/img/default.png"; 
                                                                                                                                        }
                                                                                                                                    } else {                                    //Use default if there isnt
                                                                                                                                        echo base_url() . "/assets/img/default.png"; 
                                                                                                                                    }
                                                                                                                                ?>" style="max-width: 65%;background: white;max-height: 100%;padding-top: 5%;">
                                                                                        </div>

                                                                                        <div class="pull-right col-lg-7" style="float:right;">
                                                                                            <label class="picture-label col-lg-12">Upload Invigilator's Image</label>
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

                                                                                                            <input type="file" class="default" id="new_invigilator_picsture" name="new_invigilator_picsture"/>
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
                                                                                <button type="submit" class="btn btn-primary waves-effect waves-light">Update & Continue</button>
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
    echo "<script src='" . base_url() . "assets/js/bootstrap-fileupload.js'></script>";
    echo "<script src='" . base_url() . "assets/js/tab.js'></script>";

    $this->load->view('generics/footer.php');

    if($this->session->flashdata('invigilators_entry_failure')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('invigilators_entry_failure') . "', { position:'top center', className:'error'});
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