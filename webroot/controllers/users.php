<!-- This is the users controller. for login and signup -->
<?php
    class Users extends CI_Controller {
        public $available;
        public $name;
        public $email;
        public $password;

        // THis is the login function
        public function login() {
            //set rules for email
            $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|min_length[5]|valid_email',
                                                array('max_length' => 'This field can contain only 100 characters',
                                                    'min_length' => 'This field must be 5 characters or more'
                                                    )
                                            );

            //set rules for password
            $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[20]|min_length[6]|alpha_dash',
                                                array('alpha_dash' => 'This field must contain only letters, numbers, underscores and dashes',
                                                    'max_length' => 'This field can contain only 20 characters',
                                                    'min_length' => 'This field must be 6 characters or more'
                                                    )
                                            );

            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are erros
                $this->session->set_flashdata('erros', 'login');
                $this->load->view("home");      //redirect to the home page
            } else {        //If everything is ok,
                //Get from post
                $this->email = $this->input->post('email');
                $this->password = $this->input->post('password');

                //Login and get ucciaID
                $ucciaID = $this->User_model->login($this->email, $this->password);
                
                //If there's a successful login
                if ($ucciaID) {
                    $get_user_details = $this->User_model->getUserDetails($ucciaID);        //Get the user's details
                    //die($get_user_details);

                    //If we've successfully gotten the user's details,
                    if ($get_user_details) {
                        //die($this->session->firstname);
                        //$this->email->sendMail($this->session->firstname, $this->email, 'login');                        //Send login notification email

                        redirect('dashboard');              //move on to the dashboard
                    } else {
                        //Notify of error
                        $this->session->set_flashdata('failed_login', 'We can\'t log you in at the moment. Please try again later');
                        redirect('home');
                    }
                } else {
                    $this->session->set_flashdata('failed_login', 'Incorrect email or password');
                    redirect('home');
                } 
            }
            
        }

        // This is the password reset function
        public function reset() {
            //set rules for email
            $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|min_length[5]|valid_email',
                                                array('max_length' => 'This field can contain only 100 characters',
                                                    'min_length' => 'This field must be 5 characters or more'
                                                    )
                                            );
            
            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are erros
                $this->session->set_flashdata('erros', 'reset');
                $this->load->view("home");      //redirect to the home page
            } else {        //If everything is ok,

                //Check if the account is already taken or email has been used
                $this->available = $this->User_model->isAccountAvailable($this->input->post('email'));
                //die($this->available);

                //If the account isn't taken, which means we don't have that email in our system, 
                if ($this->available == true) {
                    $this->email->sendMail("", $this->email, 'non_existent');                        //Password reset notification email

                    $this->session->set_flashdata('reset_success', $this->input->post('email'));
                    redirect('home');
                } else {                                    //If it is taken, meaning it is a real email, send right email
                    $this->email->sendMail("", $this->email, 'reset_start');                        //Password reset notification email, real
                    $this->session->set_flashdata('reset_success', $this->input->post('email'));
                    redirect('home');
                }
                
            }
        }

        //This function logs the user out
        public function logout() {
            $this->session->sess_destroy();
            redirect("home");
        }
    }
?>