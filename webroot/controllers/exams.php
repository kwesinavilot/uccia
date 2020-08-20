<?php
    class Exams extends CI_Controller {

        //Function to insert new entries into the database
        public function add_exam() {
            //die("We're inserting" . print_r($_POST));

            //set rules for date
            $this->form_validation->set_rules('exam_date', 'Exam Date', 'trim|required');

            //set rules for class name
            $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required|max_length[100]|min_length[1]');

            //set rules for class number
            $this->form_validation->set_rules('course_code', 'Class Code', 'trim|required|max_length[7]|min_length[1]|alpha_numeric');

            //set rules for start time
            $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');

            //set rules for class department
            $this->form_validation->set_rules('program', 'Program', 'trim|required|max_length[100]|min_length[1]|alpha_numeric');
            
            //set rules for class school
            $this->form_validation->set_rules('venue', 'Venue', 'trim|required|max_length[100]|min_length[1]');
            
            //set rules for end time
            $this->form_validation->set_rules('end_time', 'End TIme', 'trim|required');

            //set rules for description
            $this->form_validation->set_rules('description', 'Description', 'max_length[450]|min_length[1]');

            //set rules for the invigilator
            $this->form_validation->set_rules('invigilators[]', 'Invigilator', 'trim|required|alpha_numeric');

            //die("We're inserting" . print_r($_POST));

            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are erros
                //die("Alll's good");
                $data['classes'] = $this->Classes_model->get_all_classes();
                $data['invigilators'] = $this->Invigilators_model->get_all_invigilators();

                $this->load->view('exams/add', $data);
            } else {        //If everything is ok,                
                //Try inserting the new class entry for this user
                if ($this->Exams_model->add_exam()) {       //If we successfully inserted entry
                    $this->session->set_flashdata('exam_entry_success', 'Exam added successfully');
                    redirect('exams/all');
                } else {
                    $this->session->set_flashdata('exam_entry_failure', 'Couldn\'t exam class! Please try again');
                    redirect('exams/all');
                }
                
            }
        }

        //Get all the class entries of this user
        public function all() {            
            $config = array();                                              //Create config array
            $config["base_url"] = base_url() . "exams/all";         //set the link to the method
            $config["total_rows"] = $this->Exams_model->record_count();    //get total number of class records
            $config["per_page"] = 15;                                       //set number of pages to show
            $config["uri_segment"] = 3;                                     //set the segments to show
            $choice = $config["total_rows"] / $config["per_page"];          //divide the rows by the number of pages to show
            $config["num_links"] = round($choice);                         //now, round it up and set it to the number of links to create
            //$config['enable_query_strings'] = TRUE;
            //$config['page_query_string'] = TRUE;

            //config for bootstrap pagination class integration
            $config['full_tag_open'] = '<ul class="pagination pull-right" style="margin:0;">';
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

            // Get all the exams per this page
            $data["exams"] = $this->Exams_model->get_spec_exams($config["per_page"], $page);
            
            //Get the total records the user has
            $data["total_rows"] = $config["total_rows"];
            
            // Get the pagination links
            $data["links"] = $this->pagination->create_links();
            
            //die(print_r($data));

            $this->load->view("exams/all", $data);
        }

        public function selectCheck($value){               //Use anonymous method to check value
            //die($value);
            if($value == "select") {    //If it's 'Select'
                $this->form_validation->set_message('selectCheck', 'You\'ve to select one of the provided values');
                return false;           //Lodge error
            } else {
                return true;            //If it's not 'Select', continue
            }
        }

        //This method is for viewing the details of an entry
        public function view($course_code = 0) {
            if ($course_code == "") {            //If we didn't pass any class to edit
                //$data['class_details'] = null;        //...give us an empty page
                $data['set'] = false;
                //$this->load->view('exams/edit');
            } else {
                //Get the exam with the passed course_code
                $data['exam_details'] = $this->Exams_model->get_exam($course_code);
                $data['exam_invigilators'] = $this->Exams_model->get_exam_invigilators($course_code);
                //die(print_r($data['class_details']));

                //Check if there's a content for the view id...
                if(empty($data['exam_details'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                }
            }

            $this->load->view('exams/view', $data);
        }

        //This method is for adding the details of a class
        public function add() {
            $data['classes'] = $this->Classes_model->get_all_classes();
            $data['invigilators'] = $this->Invigilators_model->get_all_invigilators();

            $this->load->view('exams/add', $data);
        }

        //This method is for an entry
        public function delete($course_code) {
            $ucciaId = $this->session->ucciaId;     //Get the current user's ID

            $data['reply'] = $this->Classes_model->delete_income($course_code);
            //die(print_r($data['reply']));

            //Check if there's a content for the view id...
            if(empty($data['reply'])){
                show_404();                         //...if there's nothing, show the 404 page;
            }

            redirect('exams/all');
        }

        //This method is for an entry
        public function edit($course_code = 0) {
            if ($course_code == "") {            //If we didn't pass any class to edit
                //$data['content'] = null;        //...give us an empty page
                $data['set'] = false;
                //$this->load->view('exams/edit');
            } else {
                //Get the class with the passed short
                $data['content'] = $this->Exams_model->get_exam($course_code);
                //die(print_r($data['content']));

                //Check if there's a content for the view id...
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                }

                $data['classes'] = $this->Classes_model->get_all_classes();
                $data['invigilators'] = $this->Invigilators_model->get_all_invigilators();
            }

            $this->load->view('exams/edit', $data);
        }

        //Function to update class details
        public function update($course_code) {
            //die("We're inserting" . print_r($_POST));

            //set rules for date
            $this->form_validation->set_rules('exam_date', 'Exam Date', 'trim|required');

            //set rules for class name
            $this->form_validation->set_rules('course_name', 'Course Name', 'trim|required|max_length[100]|min_length[1]');

            //set rules for class number
            $this->form_validation->set_rules('course_code', 'Class Code', 'trim|required|max_length[7]|min_length[1]|alpha_numeric');

            //set rules for start time
            $this->form_validation->set_rules('start_time', 'Start Time', 'trim|required');

            //set rules for class department
            $this->form_validation->set_rules('program', 'Program', 'trim|required|max_length[100]|min_length[1]|alpha_numeric');
            
            //set rules for class school
            $this->form_validation->set_rules('venue', 'Venue', 'trim|required|max_length[100]|min_length[1]');
            
            //set rules for end time
            $this->form_validation->set_rules('end_time', 'End TIme', 'trim|required');

            //set rules for description
            $this->form_validation->set_rules('description', 'Description', 'max_length[450]|min_length[1]');

            //set rules for the invigilator
            $this->form_validation->set_rules('invigilators[]', 'Invigilator', 'trim|required|alpha_numeric');

            //die("We're inserting" . print_r($_POST));

            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are errors, return them to the edit page with the class details
                //Get the class with the passed short
                $data['content'] = $this->Exams_model->get_exam($course_code);
                //die(print_r($data['content']));

                //Check if there's a content for the passed class short....
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                } else {
                    //...if there is, send them back to the page
                    $data['classes'] = $this->Classes_model->get_all_classes();
                    $data['invigilators'] = $this->Invigilators_model->get_all_invigilators();

                    $this->load->view('exams/edit', $data);
                }

            } else {        //If everything is ok,
                //die("All's good" . $this->session->ucciaId);
                
                //Try inserting the new income entry for this user
                if ($this->Exams_model->update_exam($course_code)) {       //If we successfully inserted entry
                    //die("All");
                    $this->session->set_flashdata('exam_update_success', 'Exam details updated successfully');
                    redirect('exams/view/' .$course_code);
                } else {
                    $this->session->set_flashdata('exam_update_failure', 'Couldn\'t update the exam details! Please try again');
                    redirect('exams/view/'  .$course_code);
                }
                
            }
        }
    }
?>