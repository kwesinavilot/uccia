<?php
    class Invigilators extends CI_Controller {

        //Function to insert invigilator's picture
        public function invigilator_picture() {
            //set up picture upload configs
            $config['upload_path']       = './assets/invigilator_pics/';
            //die($config['upload_path']);
            $config['allowed_types']     = 'gif|jpg|png';
            $config['file_ext_tolower']  = TRUE;
            $config['encrypt_name']      = TRUE;
            $config['max_size']          = 0;
            $config['max_width']         = 0;
            $config['max_height']        = 0;

            $this->load->library('upload', $config);

            //Check if the uploaded didn't work...
            if (!$this->upload->do_upload('invigilator_picsture')) {
                $error = array('error' => $this->upload->display_errors());             //If it didn't get the errors

                $this->load->view('invigilators/picture', $error);                               //Now display them
            } else {                                                                    //If it worked...
                $data = array('upload_data' => $this->upload->data());                  //Get the response
                //die(print_r($data));
                $filename = $data['upload_data']['file_name'];

                $this->session->set_userdata('invigilator_pics_name', $filename);

                redirect('invigilators/add/details');
            }
        }

        //Function to insert invigilator's picture
        public function update_picture($invigilatorID) {
            //die($invigilatorID);
            //set up picture upload configs
            $config['upload_path']       = './assets/invigilator_pics/';
            //die($config['upload_path']);
            $config['allowed_types']     = 'gif|jpg|png';
            $config['file_ext_tolower']  = TRUE;
            $config['encrypt_name']      = TRUE;
            $config['max_size']          = 0;
            $config['max_width']         = 0;
            $config['max_height']        = 0;

            $this->load->library('upload', $config);

            //Check if the uploaded didn't work...
            if (!$this->upload->do_upload('new_invigilator_picsture')) {
                $data['error'] = $this->upload->display_errors();             //If it got errors
                $data['content'] = $this->Invigilators_model->get_invigilator_pics($invigilatorID);

                $this->load->view('invigilators/edit-picture', $data);                               //Now display them
            } else {                                                                    //If it worked...
                $data = array('upload_data' => $this->upload->data());                  //Get the response
                //die(print_r($data));
                $filename = $data['upload_data']['file_name'];

                //Try updating the invigilator's picture in the database
                if ($this->Invigilators_model->update_invigilator_pics($invigilatorID, $filename)) {       //If we successfully inserted picture
                    $this->session->set_flashdata('update_picture_success', 'Invigilator\'s picture updated successfully');
                    //$this->load->view('accounts');                             //Go to the account page
                    redirect('invigilators/edit/' . $invigilatorID . '/details');
                } else {
                    $this->session->set_flashdata('update_picture_failure', 'Couldn\'t update profile picture! Please try again');
                    //$this->load->view('accounts');                             //Go to the account page
                    redirect('invigilators/edit/' . $invigilatorID . '/picture');
                }
            }
        }

        public function picture() {
            $this->load->view("invigilators/picture");
        }

        public function edit_picture($invigilatorID = 0) {
            if ($invigilatorID == "") {            //If we didn't pass any class to edit
                //$data['class_details'] = null;        //...give us an empty page
                $data['set'] = false;
                //$this->load->view('classes/edit');
            } else {
                //Get the class with the passed short
                $data['content'] = $this->Invigilators_model->get_invigilator_pics($invigilatorID);
                //die(print_r($data['content']));

                //Check if there's a content for the view id...
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                }
            }

            $this->load->view('invigilators/edit-picture', $data);
        }

        //Function to insert new entries into the database
        public function invigilator_details() {
            //die("We're inserting" . print_r($_POST));

            //set rules for first name
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|max_length[25]|min_length[1]');

            //set rules for last name
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|max_length[30]|min_length[1]');

            //set rules for other name
            $this->form_validation->set_rules('other_names', 'Other Names', 'trim|max_length[30]|min_length[1]');

            //set rules for class name
            $this->form_validation->set_rules('department', 'Department', 'trim|required|max_length[30]|min_length[1]');

            //set rules for description
            $this->form_validation->set_rules('description', 'Description', 'max_length[450]|min_length[1]');

            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are erros
                //die("Alll's good");
                //$data['classes'] = $this->Classes_model->get_all_classes();

                $this->load->view('invigilators/details');
            } else {        //If everything is ok,
                //die("All's good" . $this->session->ucciaId);
                
                //Try inserting the new invigilator entry for this user
                if ($this->Invigilators_model->insert_invigilator()) {       //If we successfully inserted entry
                    $this->session->set_flashdata('invigilators_entry_success', 'Invigilator added successfully');
                    redirect('invigilators/view/' . $this->session->new_invigilator);
                } else {
                    $this->session->set_flashdata('invigilators_entry_failure', 'Couldn\'t add Invigilator! Please try again');
                    redirect('invigilators/add');
                }
                
            }
        }

        public function edit_details($invigilatorID) {
            if ($invigilatorID == "") {            //If we didn't pass any class to edit
                //$data['class_details'] = null;        //...give us an empty page
                $data['set'] = false;
                //$this->load->view('classes/edit');
            } else {
                //Get the class with the passed short
                $data['content'] = $this->Invigilators_model->get_invigilator_details($invigilatorID);
                $data['halls'] = $this->Super_model->getHalls();
                $data['classes'] = $this->Classes_model->get_all_classes();
                //die(print_r($data['content']));

                //Check if there's a content for the view id...
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                }
            }

            $this->load->view('invigilators/edit-details', $data);
        }

        //Function to update the details of the invigilator
        public function update_details($invigilatorID) {
            //die("We're inserting " . $id);
            $this->invigilatorID = $invigilatorID;

            //set rules for first name
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|max_length[25]|min_length[1]');

            //set rules for last name
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|max_length[30]|min_length[1]');

            //set rules for other name
            $this->form_validation->set_rules('other_names', 'Other Names', 'trim|max_length[30]|min_length[1]');

            //set rules for class name
            $this->form_validation->set_rules('department', 'department', 'trim|required|max_length[30]|min_length[1]');

            //set rules for description
            $this->form_validation->set_rules('description', 'Description', 'max_length[450]|min_length[1]');

            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are erros
                $data['content'] = $this->Invigilators_model->get_invigilator_details($this->invigilatorID);
                //die(print_r($data['content']));

                //Check if there's a content for the view id...
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                }
                
                $this->load->view('invigilators/edit-details', $data);

            } else {        //If everything is ok,                
                //Try inserting the new income entry for this user
                if ($this->Invigilators_model->update_invigilator_details($this->invigilatorID)) {       //If we successfully inserted entry
                    $this->session->set_flashdata('details_update_success', 'Invigilator\'s details updated successfully');
                    redirect('invigilators/view/' . $this->invigilatorID);
                } else {
                    $this->session->set_flashdata('details_update_failure', 'Couldn\'t update the invigilator\'s details! Please try again');
                    redirect('invigilators/view/'  . $this->invigilatorID);
                }
                
            }
        }

        //This method is for adding the details of a invigilator
        public function details() {
            $data['halls'] = $this->Super_model->getHalls();
            $data['classes'] = $this->Classes_model->get_all_classes();
            //die(print_r($data['classes']));

            $this->load->view('invigilators/details', $data);
        }

        public function selectCheck($value){               //Use anonymous method to check value
            //die($value);
            if($value == "select") {    //If it's 'Select'
                $this->form_validation->set_message('selectCheck', 'You\'ve to select one of the provided options');
                return false;           //Lodge error
            } else {
                return true;            //If it's not 'Select', continue
            }
        }

        //Get all the invigilator entries of this user
        public function all() {            
            $config = array();                                              //Create config array
            $config["base_url"] = base_url() . "invigilators/all";         //set the link to the method
            $config["total_rows"] = $this->Invigilators_model->record_count();    //get total number of invigilator records
            $config["per_page"] = 10;                                       //set number of pages to show
            $config["uri_segment"] = 3;                                     //set the segments to show
            $choice = $config["total_rows"] / $config["per_page"];          //divide the rows by the number of pages to show
            $config["num_links"] = round($choice);                         //now, round it up and set it to the number of links to create
            //$config['enable_query_strings'] = TRUE;
            //$config['page_query_string'] = TRUE;

            //config for bootstrap pagination class integration
            $config['full_tag_open'] = '<ul class="pagination" style="margin:0;">';
            $config['full_tag_close'] = '</ul>';
            $config['first_link'] = false;
            $config['last_link'] = false;
            $config['first_tag_open'] = '<li class="paginate_button page-item ">';
            $config['first_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo';
            $config['prev_tag_open'] = '<li class="paginate_button page-item prev">';
            $config['prev_tag_close'] = '</li>';
            $config['next_link'] = '&raquo';
            $config['next_tag_open'] = '<li class="paginate_button page-item ">';
            $config['next_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li class="paginate_button page-item ">';
            $config['last_tag_close'] = '</li>';
            $config['cur_tag_open'] = '<li class="paginate_button page-item active"><a href="#" class="page-link">';
            $config['cur_tag_close'] = '</a></li>';
            $config['num_tag_open'] = '<li class="paginate_button page-item ">';
            $config['num_tag_close'] = '</li>';

            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

            //Get all the incomes per this page
            $data["invigilators"] = $this->Invigilators_model->get_spec_invigilators($config["per_page"], $page);

            //Get the total records the user has
            $data["total_rows"] = $config["total_rows"];

            //Get the pagination links
            $data["links"] = $this->pagination->create_links();

            $this->load->view("invigilators/all", $data);
        }

        //This method is for viewing the details of an entry
        public function view($invigilatorID = 0) {
            if ($invigilatorID == "") {            //If we didn't pass any class to edit
                //$data['class_details'] = null;        //...give us an empty page
                $data['set'] = false;
                //$this->load->view('classes/edit');
            } else {
                //Get the class with the passed short
                $data['content'] = $this->Invigilators_model->get_invigilator($invigilatorID);
                //$data['invigilator_exams'] = $this->Exams_model->get_invigilator_exams($invigilatorID);
                //die(print_r($data['content']));

                //Check if there's a content for the view id...
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                }
            }

            $this->load->view('invigilators/view', $data);
        }

        //This method is for an entry
        public function delete($id) {
            $ucciaId = $this->session->ucciaId;     //Get the current user's ID

            $data['reply'] = $this->Invigilators_model->delete_income($ucciaId, $id);
            //die(print_r($data['reply']));

            //Check if there's a content for the view id...
            if(empty($data['reply'])){
                show_404();                         //...if there's nothing, show the 404 page;
            }

            redirect('invigilators/all');
        }
    }
?>