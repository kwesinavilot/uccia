<?php
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }

    define('TITLE', "All Students | UCCIA - Put tagline here");
    define('HEADER', "All Students");
    define('EXTRAO', 'No');

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
                                    <h4 class="col-lg-7 paddoff">All Classes</h4>

                                    <div class="add-product col-lg-2 paddoff" style="float: right;">
                                        <a class="paddoff col-lg-12 paddoff" href="<?php echo base_url();?>classes/add">Add A Class</a>
                                    </div>
                                </div>

                                <div class="content">
                                    <div class="asset-inner marg-sub">
                                        <table class="table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Name of Class</th>
                                                    <th>Level</th>
                                                    <th>Students</th>
                                                    <th>Department</th>
                                                    <th>Exams</th>
                                                    <th>Written</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                <?php
                                                    //die(print_r($classes));
                                                    if(empty($classes)) {
                                                        echo "
                                                            <tr>
                                                                <td colspan='6' style='text-align:center;'>You haven't made any classe entries yet.</td>
                                                            </tr>
                                                        ";
                                                    } else {
                                                        //die(print_r($classes));
                                                        foreach ($classes as $index => $class) {
                                                            $view = base_url() . 'classes/view/' . $class->class_short;
                                                            $edit = base_url() . 'classes/edit/' . $class->class_short;
                                                            
                                                            echo "
                                                                <tr>
                                                                    <td>$index</td>
                                                                    <td>$class->name</td>
                                                                    <td>$class->level</td>
                                                                    <td>$class->size</td>
                                                                    <td>$class->department</td>
                                                                    <td>0</td>
                                                                    <td>0</td>
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
                                                    if(!empty($classes)) {      //Only show results when there are classes
                                                        print "Showing 1 to 15 of " . $total_rows . " classes"; 
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

    if ($this->session->flashdata('classes_entry_success')) {
        echo "
            <script>
                $.notify('" . $this->session->flashdata('classes_entry_success') . "', { position:'top center', className:'success'});
            </script>
        ";
    } else if($this->session->flashdata('classes_entry_failure')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('classes_entry_failure') . "', { position:'top center', className:'error'});
            </script>
        ";
    }
?>