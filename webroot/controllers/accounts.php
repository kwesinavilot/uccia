<?php
    class Accounts extends CI_Controller {
        private $filename;

        public function index() {
            $this->load->view("accounts");
        }

        public function logout() {
            $this->session->sess_destroy();
            redirect("home");
        }

        public function update_details () {
            //set rules for firstname
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|alpha|required|max_length[25]|min_length[2] ',
                                                array('alpha' => 'This field must contain only letters. eg: Kweku',
                                                        'max_length' => 'This field can contain only 25 letters',
                                                        'min_length' => 'This field must be 2 letters or more'
                                                    )
                                            );

            //set rules for lastname
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|alpha|required|max_length[25]|min_length[2] ',
                                                array('alpha' => 'This field must contain only letters. eg: Mensah',
                                                    'max_length' => 'This field can contain only 25 letters',
                                                    'min_length' => 'This field must be 2 letters or more'
                                                    )
                                            );

            //set rules for email
            $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[100]|min_length[5]|valid_email ',
                                                array('max_length' => 'This field can contain only 100 letters',
                                                    'min_length' => 'This field must be 5 letters or more'
                                                    )
                                            );
            
            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are erros
                $this->load->view("accounts");      //redirect to the home page
            } else {        //If everything is ok,
                $ucciaId = $this->session->ucciaId;     //Get the current user's ID

                if($this->User_model->update_details($ucciaId)) {           //Try update the details
                    $this->email->sendMail($this->session->firstname, $this->session->email, 'details-update');                        //Send details update notification email

                    //Worked? Redirect and notify
                    $this->session->set_flashdata('details_update_success', 'Your details have been updated successfully');
                    redirect('accounts');
                } else {
                    // Failed? Redirect and notify
                    $this->session->set_flashdata('details_update_failure', 'We\'re unable to update your details now! Try again in a moment');
                    redirect('accounts');
                }
                
            }
        }

        public function change_password () {
            //set rules for password
            $this->form_validation->set_rules('current_password', 'Current Password', 'trim|required|max_length[20]|min_length[6]|alpha_dash ',
                                                array('alpha_dash' => 'This field must contain only letters, numbers, underscores and dashes',
                                                    'max_length' => 'This field can contain only 20 characters',
                                                    'min_length' => 'This field must be 6 characters or more'
                                                    )
                                            );

            //set rules for password
            $this->form_validation->set_rules('new_password', 'New Password', 'trim|required|max_length[20]|min_length[6]|alpha_dash ',
                                                array('alpha_dash' => 'This field must contain only letters, numbers, underscores and dashes',
                                                    'max_length' => 'This field can contain only 20 characters',
                                                    'min_length' => 'This field must be 6 characters or more'
                                                    )
                                            );

            //set rules for password
            $this->form_validation->set_rules('confirm_new', 'Confirm New Password', 'trim|required|max_length[20]|min_length[6]|alpha_dash|matches[new_password] ', 
                                                array('matches' => 'Passwords don\'t match',
                                                    'alpha_dash' => 'This field must contain only letters, numbers, underscores and dashes',
                                                    'max_length' => 'This field can contain only 20 characters',
                                                    'min_length' => 'This field must be 6 characters or more'
                                                    )
                                            );

            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are erros
                $this->load->view("accounts");      //redirect to the home page
            } else {        //If everything is ok,
                $ucciaId = $this->session->ucciaId;     //Get the current user's ID

                if($this->User_model->verify_password($ucciaId)) {           //Verify the current password

                    if($this->User_model->change_password($ucciaId)) {           //Try update the password
                        $this->email->sendMail($this->session->firstname, $this->session->email, 'pass-change');                        //Send password change notification email

                        //Worked? Redirect and notify
                        $this->session->set_flashdata('password_change_success', 'Your password has been changed successfully');
                        redirect('accounts');
                    } else {           //If we couldn't change the passwords...
                        // Failed? Redirect and notify
                        $this->session->set_flashdata('password_change_failure', 'We\'re unable to change your password now! Try again in a moment');
                        redirect('accounts');
                    }

                } else {
                    // Unmatched? Redirect and notify
                    $this->session->set_flashdata('password_change_failure', 'The entered current password is incorrect!');
                    redirect('accounts');
                }
                
            }
        }

        public function update_picture() {
            //die(print_r($_FILES));
            //$this->filename = $_FILES['picture']['name'];           //Set the name of the file to be uploaded

            $ucciaId = $this->session->ucciaId;     //Get the current user's ID

            $config['upload_path']       = './assets/profile/';
            //die($config['upload_path']);
            $config['allowed_types']     = 'gif|jpg|png';
            $config['file_ext_tolower']  = TRUE;
            $config['encrypt_name']      = TRUE;
            $config['max_size']          = 0;
            $config['max_width']         = 0;
            $config['max_height']        = 0;

            $this->load->library('upload', $config);

            //Check if the uploaded didn't work...
            if (!$this->upload->do_upload('profile-picture')) {
                $error = array('error' => $this->upload->display_errors());             //If it didn't get the errors

                $this->load->view('accounts', $error);                               //Now display them
            } else {                                                                    //If it worked...
                $data = array('upload_data' => $this->upload->data());                  //Get the response
                //die(print_r($data));
                $filename = $data['upload_data']['file_name'];

                //Try updating the user's picture in the database
                if ($this->User_model->updatePicture($ucciaId, $filename)) {       //If we successfully inserted picture
                    $this->session->set_flashdata('update_picture_success', 'Profile picture updated successfully');
                    //$this->load->view('accounts');                             //Go to the account page
                    redirect('accounts');
                } else {
                    $this->session->set_flashdata('update_picture_failure', 'Couldn\'t update profile picture! Please try again');
                    //$this->load->view('accounts');                             //Go to the account page
                    redirect('accounts');
                }

                //$this->load->view('accounts', $data);                             //Go to the account page
            }
        }
    }
?>