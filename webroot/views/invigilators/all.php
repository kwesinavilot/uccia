<?php
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }

    define('TITLE', "All Invigilators | UCCIA - Put tagline here");
    define('HEADER', "All Invigilators");
    define('EXTRAO', 'No');

    //die(print_r($invigilators));

    //Load the header and sidebar sections
    $this->load->view('generics/header-sidebar.php');
?>

        <aside class="col-lg-12">
            <div class="product-status mg-b-15">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-status-wrap">
                                <div class="top marg-sub">
                                    <h4 class="col-lg-7 paddoff"><?php print HEADER;?></h4>

                                    <div class="add-product col-lg-2 paddoff" style="float: right;">
                                        <a class="paddoff col-lg-12 paddoff" href="<?php echo base_url();?>invigilators/add">Add An Invigilator</a>
                                    </div>
                                </div>

                                <div class="content">
                                    <div class="asset-inner marg-sub">
                                        <table class="table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5%">#</th>
                                                    <th style="width: 15%;">Picture</th>
                                                    <th style="width: 20%">First Name</th>
                                                    <th style="width: 20%">Last Name</th>
                                                    <th style="width: 15%">Other Names</th>
                                                    <th style="width: 20%">Department</th>
                                                    <th style="width: 5%">Actions</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <?php
                                                    //die(print_r($invigilators));
                                                    if(empty($invigilators)) {
                                                        echo "
                                                            <tr>
                                                                <td colspan='7' style='text-align:center;'>You haven't made any invigilator entries yet.</td>
                                                            </tr>
                                                        ";
                                                    } else {
                                                        //die(print_r($invigilators));
                                                        foreach ($invigilators as $index => $invigilator) {
                                                            $view = base_url() . 'invigilators/view/' . $invigilator->invigilatorID;
                                                            $edit = base_url() . 'invigilators/edit/' . $invigilator->invigilatorID;

                                                            //Check if there's a profile picture for the invigilator
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
                                                                            style='width: 50% !important;'>
                                                                    </td>

                                                                    <td>$invigilator->firstname</td>
                                                                    <td>$invigilator->lastname</td>
                                                                    <td>$invigilator->other_names</td>
                                                                    <td>$invigilator->department</td>
                                                                    <td>
                                                                        <a href='$view'>
                                                                            <button data-toggle='tooltip' title='View' class='pd-setting-ed'>
                                                                                <i class='fa fa-pencil-square-o' aria-hidden='true'></i>
                                                                            </button>
                                                                        </a>

                                                                        <a href='$edit'>
                                                                            <button data-toggle='tooltip' title='Edit' class='pd-setting-ed'>
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
                                                    if(!empty($invigilators)) {      //Only show results when there are invigilators
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
        </aside>
    </div>

<?php
    //Load the footer
    $this->load->view('generics/footer.php');

    if ($this->session->flashdata('invigilators_entry_success')) {
        echo "
            <script>
                $.notify('" . $this->session->flashdata('invigilator_entry_success') . "', { position:'top center', className:'success'});
            </script>
        ";
    } else if($this->session->flashdata('invigilator_entry_failure')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('invigilator_entry_failure') . "', { position:'top center', className:'error'});
            </script>
        ";
    }
?>