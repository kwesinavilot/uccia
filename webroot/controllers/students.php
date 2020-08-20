<?php
    class Students extends CI_Controller {

        public $qresponse;

        //Function to insert student's picture
        public function student_picture() {
            //set up picture upload configs
            $config['upload_path']       = './assets/student_pics/';
            //die($config['upload_path']);
            $config['allowed_types']     = 'gif|jpg|png';
            $config['file_ext_tolower']  = TRUE;
            $config['encrypt_name']      = TRUE;
            $config['max_size']          = 0;
            $config['max_width']         = 0;
            $config['max_height']        = 0;

            $this->load->library('upload', $config);

            //Check if the uploaded didn't work...
            if (!$this->upload->do_upload('student_picture')) {
                $error = array('error' => $this->upload->display_errors());             //If it didn't get the errors

                $this->load->view('students/picture', $error);                               //Now display them
            } else {                                                                    //If it worked...
                $data = array('upload_data' => $this->upload->data());                  //Get the response
                //die(print_r($data));
                $student_pic_name = $data['upload_data']['file_name'];

                $this->session->set_userdata('student_pic', $student_pic_name);

                redirect('students/add/details');
            }
        }

        //Function to insert student's picture
        public function update_picture($studentID) {
            //die($studentID);
            //set up picture upload configs
            $config['upload_path']       = './assets/student_pics/';
            //die($config['upload_path']);
            $config['allowed_types']     = 'gif|jpg|png';
            $config['file_ext_tolower']  = TRUE;
            $config['encrypt_name']      = TRUE;
            $config['max_size']          = 0;
            $config['max_width']         = 0;
            $config['max_height']        = 0;

            $this->load->library('upload', $config);

            //Check if the uploaded didn't work...
            if (!$this->upload->do_upload('new_student_picture')) {
                $data['error'] = $this->upload->display_errors();             //If it got errors
                $data['content'] = $this->Students_model->get_student_pic($studentID);

                $this->load->view('students/edit-picture', $data);                               //Now display them
            } else {                                                                    //If it worked...
                $data = array('upload_data' => $this->upload->data());                  //Get the response
                //die(print_r($data));
                $filename = $data['upload_data']['file_name'];

                //Try updating the student's picture in the database
                if ($this->Students_model->update_student_pic($studentID, $filename)) {       //If we successfully inserted picture
                    $this->session->set_flashdata('update_picture_success', 'Student\'s picture updated successfully');
                    //$this->load->view('accounts');                             //Go to the account page
                    redirect('students/edit/' . $studentID . '/details');
                } else {
                    $this->session->set_flashdata('update_picture_failure', 'Couldn\'t update profile picture! Please try again');
                    //$this->load->view('accounts');                             //Go to the account page
                    redirect('students/edit/' . $studentID . '/picture');
                }
            }
        }

        public function picture() {
            $this->load->view('students/picture');
        }

        public function edit_picture($studentID = 0) {
            if ($studentID == "") {            //If we didn't pass any class to edit
                //$data['class_details'] = null;        //...give us an empty page
                $data['set'] = false;
                //$this->load->view('classes/edit');
            } else {
                //Get the class with the passed short
                $data['content'] = $this->Students_model->get_student_pic($studentID);
                //die(print_r($data['content']));

                //Check if there's a content for the view id...
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                }
            }

            $this->load->view('students/edit-picture', $data);
        }

        //Function to insert new entries into the database
        public function student_details() {
            //die("We're inserting" . print_r($_POST));

            //set rules for first name
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|max_length[25]|min_length[1]');

            //set rules for last name
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|max_length[30]|min_length[1]');

            //set rules for other name
            $this->form_validation->set_rules('other_names', 'Other Names', 'trim|max_length[30]|min_length[1]');

            //set rules for index number
            $this->form_validation->set_rules('index_number', 'Index Number', 'trim|required|max_length[14]|min_length[14]');

            //set rules for program or class
            $this->form_validation->set_rules('student_class', 'Program', 'required|callback_selectCheck');

            $this->form_validation->set_rules('hall', 'Hall', 'required|callback_selectCheck');

            //set rules for class name
            $this->form_validation->set_rules('nationality', 'Nationality', 'trim|required|max_length[30]|min_length[1]');

            //set rules for description
            $this->form_validation->set_rules('description', 'Description', 'max_length[450]|min_length[1]');

            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are erros
                //die("Alll's good");
                $data['halls'] = $this->Super_model->getHalls();
                $data['classes'] = $this->Classes_model->get_all_classes();

                $this->load->view('students/details', $data);
            } else {        //If everything is ok,
                //die("All's good" . $this->session->ucciaId);

                $this->generateQR($this->input->post('index_number'));
                //die($this->session->qrfile);
                
                //Try inserting the new student entry for this user
                if ($this->Students_model->insert_student()) {       //If we successfully inserted entry
                    $this->session->set_flashdata('students_entry_success', 'Student added successfully');
                    redirect('students/view/' . $this->session->new_student);
                } else {
                    $this->session->set_flashdata('students_entry_failure', 'Couldn\'t add student! Please try again');
                    redirect('students/add');
                }
                
            }
        }

        public function edit_details($studentID) {
            if ($studentID == "") {            //If we didn't pass any class to edit
                //$data['class_details'] = null;        //...give us an empty page
                $data['set'] = false;
                //$this->load->view('classes/edit');
            } else {
                //Get the class with the passed short
                $data['content'] = $this->Students_model->get_student_details($studentID);
                $data['halls'] = $this->Super_model->getHalls();
                $data['classes'] = $this->Classes_model->get_all_classes();
                //die(print_r($data['content']));

                //Check if there's a content for the view id...
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                }
            }

            $this->load->view('students/edit-details', $data);
        }

        //Function to update the details of the student
        public function update_details($studentID) {
            //die("We're inserting " . $id);

            //set rules for first name
            $this->form_validation->set_rules('firstname', 'First Name', 'trim|required|max_length[25]|min_length[1]');

            //set rules for last name
            $this->form_validation->set_rules('lastname', 'Last Name', 'trim|required|max_length[30]|min_length[1]');

            //set rules for other name
            $this->form_validation->set_rules('other_names', 'Other Names', 'trim|max_length[30]|min_length[1]');

            //set rules for index number
            $this->form_validation->set_rules('index_number', 'Index Number', 'trim|required|max_length[14]|min_length[14]');

            //set rules for program or class
            $this->form_validation->set_rules('student_class', 'Program', 'required|callback_selectCheck');

            $this->form_validation->set_rules('hall', 'Hall', 'required|callback_selectCheck');

            //set rules for class name
            $this->form_validation->set_rules('nationality', 'Nationality', 'trim|required|max_length[30]|min_length[1]');

            //set rules for description
            $this->form_validation->set_rules('description', 'Description', 'max_length[450]|min_length[1]');

            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are erros
                $data['content'] = $this->Students_model->get_student_details($studentID);
                //die(print_r($data['content']));

                //Check if there's a content for the view id...
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                } else {
                    //Get all the buckets of the user
                    $data['halls'] = $this->Super_model->getHalls();
                    $data['classes'] = $this->Classes_model->get_all_classes();

                    $this->load->view('students/edit-details', $data);
                }

            } else {        //If everything is ok,               
                $this->generateQR($this->input->post('index_number'));

                //Try inserting the new income entry for this user
                if ($this->Students_model->update_student_details($studentID)) {       //If we successfully inserted entry
                    $this->session->set_flashdata('details_update_success', 'Student\'s details updated successfully');
                    redirect('students/view/' . $studentID);
                } else {
                    $this->session->set_flashdata('details_update_failure', 'Couldn\'t update the student\'s details! Please try again');
                    redirect('students/view/'  . $studentID);
                }
                
            }
        }

        //This method is for adding the details of a student
        public function details() {
            $data['halls'] = $this->Super_model->getHalls();
            $data['classes'] = $this->Classes_model->get_all_classes();
            //die(print_r($data['classes']));

            $this->load->view('students/details', $data);
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

        //Get all the student entries of this user
        public function all() {            
            $config = array();                                              //Create config array
            $config["base_url"] = base_url() . "students/all";         //set the link to the method
            $config["total_rows"] = $this->Students_model->record_count();    //get total number of student records
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

            //Get all the students per this page
            $data["students"] = $this->Students_model->get_spec_students($config["per_page"], $page);

            //Get the total records the user has
            $data["total_rows"] = $config["total_rows"];

            //Get the pagination links
            $data["links"] = $this->pagination->create_links();

            $this->load->view("students/all", $data);
        }

        //This method is for viewing the details of an entry
        public function view($studentID = 0) {
            if ($studentID == "") {            //If we didn't pass any class to edit
                //$data['class_details'] = null;        //...give us an empty page
                $data['set'] = false;
                //$this->load->view('classes/edit');
            } else {
                //Get the class with the passed short
                $data['content'] = $this->Students_model->get_student($studentID);
                //die(print_r($data['content']));

                //Check if there's a content for the view id...
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                }

                $data['exams'] = $this->Exams_model->get_student_exams($data['content']->class_short);
            }

            $this->load->view('students/view', $data);
        }

        //This method is for an entry
        public function delete($id) {
            $ucciaId = $this->session->ucciaId;     //Get the current user's ID

            $data['reply'] = $this->students_model->delete_income($ucciaId, $id);
            //die(print_r($data['reply']));

            //Check if there's a content for the view id...
            if(empty($data['reply'])){
                show_404();                         //...if there's nothing, show the 404 page;
            }

            redirect('students/all');
        }

        //Function to generate student's qrcode and picture
        //Take index number
        //Hash it
        //Add it to the path, location of qrcodes
        //first check if it already exist
        //if yes, do nothing, get the path and return
        //if no, generate a new one and save it to file
        public function generateQR($stuindex) {
            //load the QRCode library
            $this->load->library('qrlibrary');

            $dir = './assets/qrs/';
            $qrfile = md5($stuindex) . '.png';
            $path = $dir . $qrfile;

            //if the file exists in the folder
            if (file_exists($path)) {
                //we don't need to generate again so get the already existent file
                $this->session->set_userdata('qrfile', $qrfile);

                $this->qresponse = "exist";
            } else {                            //...a file hasn't been generated already
                //generate a new code with file
                $data = QRcode::png($stuindex, $path);
                $this->session->set_userdata('qrfile', $qrfile);

                $this->qresponse = "new";
            }

            // $data['path'] = $dir . $qrfile;
            // $data['qrfile'] = md5($stuindex) . '.png';
            // $data['path'] = $path;

            // die(print_r($data));

            //die($this->session->qrfile);

            //$this->load->view("qr", $data);
            return $this->qresponse;
        }
    }
?>