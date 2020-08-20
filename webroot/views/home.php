<?php
    //die(print_r($_SERVER));

    // $new_password = password_hash('Martini1', PASSWORD_DEFAULT);
    // die($new_password);

    //die("http://" . $_SERVER['SERVER_NAME'] . "/UCCIA/");
    define('TITLE', "Home | UCCIA - Put tagline here");
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/home.css" type="text/css">

        <title>
            <?php
                if(defined('TITLE')){       //Check if the title is set
                    print TITLE;            //If it is, then set it as the page title
                } else  {
                    print "UCCIA - Put tagline here!";      //If it's not then set a default title
                }
            ?>
        </title>
    </head>

    <body>
        <div id="anchor">
            <header class="row">
                <aside class="left-header col-lg-12 col-md-12 col-sm-12">
                    <h4>UCCIA</h4>
                </aside>
            </header>

            <section duty="content" class="content container">
                <div class="center-text col-lg-6 paddoff col" style="background: violet;">
                    <h5>Welcome</h5>
                    <p style="padding: 55px 24px;">This is the University of Cape Coast Invigilation Assistant.<br>
                        It is a tool aimed at enhancing exam invigilation by using Quick Response (QR) codes to authenticate students during examinations</p>
                </div>

                <div class="center-text col-lg-6 paddoff col">
                    <div class="col-lg-9 form-content">
                        <div class="content-header">
                            <h4>Enter credentials to log in</h4>
                        </div>

                        <div class="content-form">
                            <?php
                                // Check if we have a return message and show it
                                if ($this->session->flashdata('failed_login')) {
                                    echo "<p class='error'>" . $this->session->flashdata('failed_login') . "</p>";
                                } else if ($this->session->flashdata('signup_success')) {
                                    echo "<p class='success'>" . $this->session->flashdata('signup_success') . "</p>";
                                }

                                //Load the login form
                                $this->load->view('users/login'); 
                            ?>
                        </div>

                        <div class="content-footer">
                            <p>If you don't have an account or have forgotten your password, kindly contact the Student's Records Unit for assistance</p>
                        </div>
                    </div>
                </div>
            </section>

            <footer>
                <p>© 2020 UCCIA | <a href="">UNIVERSITY OF CAPE COAST</a></p>
            </footer>
        </div>

        <script src="<?php echo base_url();?>assets/js/jquery-3.3.1.js"></script>
        <script src="<?php echo base_url();?>assets/js/home.js"></script>
    </body>
</html>

<?php
    if ($this->session->flashdata('failed_login')) {
        echo "
            <script>
                $('#login-content').css('left', '270px');
                $('#login-content').css('visibility', 'visible');
            </script>
        ";
    } else if ($this->session->flashdata('failed_signup')) {
        echo "
            <script>
                $('#signup-content').css('left', '270px');
                $('#signup-content').css('visibility', 'visible');
            </script>
        ";
    } else if ($this->session->flashdata('signup_success')) {
        echo "
            <script>
                $('#login-content').css('left', '270px');
                $('#login-content').css('visibility', 'visible');
            </script>
        ";
    } else if ($this->session->flashdata('reset_success')) {
        echo "
            <script>
                $('#reset-content').css('left', '270px');
                $('#reset-content').css('visibility', 'visible');
            </script>
        ";
    } else if ($this->session->flashdata('erros') == "signup") {
        echo "
            <script>
                $('#signup-content').css('left', '270px');
                $('#signup-content').css('visibility', 'visible');
            </script>
        ";
    } else if ($this->session->flashdata('erros') == "login") {
        echo "
            <script>
                $('#login-content').css('left', '270px');
                $('#login-content').css('visibility', 'visible');
            </script>
        ";
    }

    //die(print_r($this->session->platform));
?>