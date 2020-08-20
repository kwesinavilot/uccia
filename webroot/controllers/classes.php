<?php
    class Classes extends CI_Controller {
        //Function to log out
        public function logout() {
            $this->session->sess_destroy();
            redirect("home");
        }

        //Function to insert new entries into the database
        public function add_class() {
            //die("We're inserting" . print_r($_POST));

            //set rules for degree
            $this->form_validation->set_rules('degree', 'Degree', 'required|callback_selectCheck');

            //set rules for class name
            $this->form_validation->set_rules('class_name', 'Name', 'trim|required|max_length[100]|min_length[1]');

            //set rules for class number
            $this->form_validation->set_rules('class_number', 'Class Number', 'trim|required|max_length[4]|min_length[1]|numeric');

            //set rules for level
            $this->form_validation->set_rules('level', 'Level', 'required|callback_selectCheck');

            //set rules for class department
            $this->form_validation->set_rules('department', 'Department', 'trim|required|max_length[100]|min_length[1]');

            //set rules for class school
            $this->form_validation->set_rules('school', 'School', 'trim|required|max_length[100]|min_length[1]');

            //set rules for class college
            $this->form_validation->set_rules('college', 'College', 'trim|required|max_length[100]|min_length[1]');

            //set rules for description
            $this->form_validation->set_rules('description', 'Description', 'max_length[450]|min_length[1]');

            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are erros
                //die("Alll's good");
                $this->load->view('classes/add');
            } else {        //If everything is ok,
                //die("All's good" . $this->session->ucciaId);

                $ucciaId = $this->session->ucciaId;     //Get the current user's ID
                
                //Try inserting the new class entry for this user
                if ($this->Classes_model->add_class()) {       //If we successfully inserted entry
                    $this->session->set_flashdata('classes_entry_success', 'Class added successfully');
                    redirect('classes/all');
                } else {
                    $this->session->set_flashdata('classes_entry_failure', 'Couldn\'t add class! Please try again');
                    redirect('classes/all');
                }
                
            }
        }

        //Get all the class entries of this user
        public function all() {            
            $config = array();                                              //Create config array
            $config["base_url"] = base_url() . "classes/all";         //set the link to the method
            $config["total_rows"] = $this->Classes_model->record_count();    //get total number of class records
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

            // Get all the classes per this page
            $data["classes"] = $this->Classes_model->get_spec_classes($config["per_page"], $page);

            //$data["classes"] = $this->Classes_model->get_all_classes();
            
            //Get the total records the user has
            $data["total_rows"] = $config["total_rows"];
            
            // Get the pagination links
            $data["links"] = $this->pagination->create_links();
            
            //die(print_r($data));

            $this->load->view("classes/all", $data);
        }

        // Get all the degrees of the user
        public function get_degrees($ucciaId) {
            //Get the passed ucciaId
            $this->ucciaId = $ucciaId;

            $degrees = $this->degrees_model->get_degree_essentials($ucciaId);
             
            return $degrees;
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
        public function view($classshort = 0) {
            if ($classshort == "") {            //If we didn't pass any class to edit
                //$data['class_details'] = null;        //...give us an empty page
                $data['set'] = false;
                //$this->load->view('classes/edit');
            } else {
                //Get the details of the class with the passed short
                $data['class_details'] = $this->Classes_model->get_class($classshort);

                //Get all the students in the class with the passed short
                $data['class_students'] = $this->Students_model->get_class_students($classshort);

                $config = array();                                              //Create config array
                $config["base_url"] = base_url() . "classes/view/" . $classshort;         //set the link to the method
                $config["total_rows"] = $this->Students_model->record_count($classshort);    //get total number of student records
                $config["per_page"] = 15;                                       //set number of pages to show
                $config["uri_segment"] = 3;                                     //set the segments to show
                $choice = $config["total_rows"] / $config["per_page"];          //divide the rows by the number of pages to show
                $config["num_links"] = round($choice);                         //now, round it up and set it to the number of links to create

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

                // Get all the classes per this page
                //$data["classes"] = $this->Classes_model->get_spec_classes($config["per_page"], $page);
                
                //Get the total records the user has
                $data["total_rows"] = $config["total_rows"];
                
                // Get the pagination links
                $data["links"] = $this->pagination->create_links();

                // //Check if there's a content for the view id...
                // if(empty($data['class_details'])){
                //     show_404();                         //...if there's nothing, show the 404 page;
                // }
            }

            $this->load->view('classes/view', $data);
        }

        //This method is for adding the details of a class
        public function add() {
            //die(substr(date("Y"), 1, 4));
            $this->load->view('classes/add');
        }

        //This method is for an entry
        public function delete($classshort) {
            $ucciaId = $this->session->ucciaId;     //Get the current user's ID

            $data['reply'] = $this->Classes_model->delete_income($ucciaId, $classshort);
            //die(print_r($data['reply']));

            //Check if there's a content for the view id...
            if(empty($data['reply'])){
                show_404();                         //...if there's nothing, show the 404 page;
            }

            redirect('classes/all');
        }

        //This method is for an entry
        public function edit($classshort = 0) {
            if ($classshort == "") {            //If we didn't pass any class to edit
                //$data['content'] = null;        //...give us an empty page
                $data['set'] = false;
                //$this->load->view('classes/edit');
            } else {
                //Get the class with the passed short
                $data['content'] = $this->Classes_model->get_class($classshort);
                //die(print_r($data['content']));

                //Check if there's a content for the view id...
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                }
            }

            $this->load->view('classes/edit', $data);
        }

        //Function to update class details
        public function update($classshort) {
            //die("We're inserting " . $classshort);

            //set rules for degree
            $this->form_validation->set_rules('degree', 'Degree', 'required|callback_selectCheck');

            //set rules for class name
            $this->form_validation->set_rules('class_name', 'Name', 'trim|required|max_length[100]|min_length[1]');

            //set rules for class number
            $this->form_validation->set_rules('class_number', 'Class Number', 'trim|required|max_length[4]|min_length[1]|numeric');

            //set rules for level
            $this->form_validation->set_rules('level', 'Level', 'required|callback_selectCheck');

            //set rules for class department
            $this->form_validation->set_rules('department', 'Department', 'trim|required|max_length[100]|min_length[1]');

            //set rules for class school
            $this->form_validation->set_rules('school', 'School', 'trim|required|max_length[100]|min_length[1]');

            //set rules for class college
            $this->form_validation->set_rules('college', 'College', 'trim|required|max_length[100]|min_length[1]');

            //set rules for description
            $this->form_validation->set_rules('description', 'Description', 'max_length[450]|min_length[1]');

            // Check if form has been submitted
            if ($this->form_validation->run() == FALSE) {       //if it hasn't submitted or there are errors, return them to the edit page with the class details
                //Get the class with the passed short
                $data['content'] = $this->Classes_model->get_class($classshort);
                //die(print_r($data['content']));

                //Check if there's a content for the passed class short....
                if(empty($data['content'])){
                    show_404();                         //...if there's nothing, show the 404 page;
                } else {
                    //...if there is, send them back to the page
                    $this->load->view('classes/edit', $data);
                }

            } else {        //If everything is ok,
                //die("All's good" . $this->session->ucciaId);
                
                //Try inserting the new income entry for this user
                if ($this->Classes_model->update_class($classshort)) {       //If we successfully inserted entry
                    //die("All");
                    $this->session->set_flashdata('class_update_success', 'Class details updated successfully');
                    redirect('classes/view/' . $classshort);
                } else {
                    $this->session->set_flashdata('class_update_failure', 'Couldn\'t update the class details! Please try again');
                    redirect('classes/view/'  . $classshort);
                }
                
            }
        }
    }
?>