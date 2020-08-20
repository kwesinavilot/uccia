<?php
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }

    define('TITLE', "All Exams | UCCIA - Put tagline here");
    define('HEADER', "All Exams");
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
                                    <h4 class="col-lg-7 paddoff">All Exams</h4>

                                    <div class="add-product col-lg-2 paddoff" style="float: right;">
                                        <a class="paddoff col-lg-12 paddoff" href="<?php echo base_url();?>exams/add">Add An Exam</a>
                                    </div>
                                </div>

                                <div class="content">
                                    <div class="asset-inner marg-sub">
                                        <table class="table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Course Name</th>
                                                    <th>Course Code</th>
                                                    <th>Date</th>
                                                    <th>Start Time</th>
                                                    <th>End Time</th>
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
                                                                <td colspan='6' style='text-align:center;'>You haven't made any classe entries yet.</td>
                                                            </tr>
                                                        ";
                                                    } else {
                                                        //die(print_r($exams));
                                                        foreach ($exams as $index => $exam) {
                                                            $view = base_url() . 'exams/view/' . $exam->course_code;
                                                            $edit = base_url() . 'exams/edit/' . $exam->course_code;
                                                            
                                                            echo "
                                                                <tr>
                                                                    <td>$index</td>
                                                                    <td>$exam->course_name</td>
                                                                    <td>$exam->course_code</td>
                                                                    <td>$exam->date</td>
                                                                    <td>$exam->start_time</td>
                                                                    <td>$exam->close_time</td>
                                                                    <td>$exam->venue</td>
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
                                                    if(!empty($exams)) {      //Only show results when there are exams
                                                        print "Showing 1 to 15 of " . $total_rows . " exams"; 
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

    if ($this->session->flashdata('exam_entry_success')) {
        echo "
            <script>
                $.notify('" . $this->session->flashdata('exam_entry_success') . "', { position:'top center', className:'success'});
            </script>
        ";
    } else if($this->session->flashdata('exam_entry_failure')) {
        echo "
            <script>
            $.notify('" . $this->session->flashdata('exam_entry_failure') . "', { position:'top center', className:'error'});
            </script>
        ";
    }
?>