<?php
    //Check if there's been a login else go back home
    if(!isset($this->session->ucciaId)) {
        redirect("home");
    }
    
    define('TITLE', "Search | UCCIA - Put tagline here");
    define('HEADER', "Search");
    define('EXTRAO', 'No');

    //die(print_r($this->session));

    //Load the header and sidebar sections
    $this->load->view('generics/header-sidebar.php');

    //die("http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
?>

        <aside class="col-lg-12">
            <div class="product-status mg-b-15">
                <div class="">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="product-status-wrap">
                                <div class="top marg-sub" >
                                    <h4 class="col-lg-7 paddoff" style="margin-bottom: 0;">Search Results</h4>
                                </div>

                                <div class="content">
                                    <?php 
                                        if(isset($set) && $set == false) {
                                            echo "Your search did not match any records.
                                                    Please make sure that all words are spelled correctly and that you've selected enough categories.";
                                        } else {
                                            print "Hello";
                                        }
                                                            
                                    ?>
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
?>