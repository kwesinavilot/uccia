<?php
    class Students_model extends CI_Model {

        public $ucciaId;
        public $student_pic;
        private $stu_ID;
        private $studentID;
        private $new_qrfile, $studentClass;

        //Insert a new student
        public function insert_student() {
            //Get the passed pic name
            $this->student_pic = $this->session->student_pic;

            //Get the passed qrpic name
            $this->qrfile = $this->session->qrfile;

            //Take of the slashes in the student ID
            $this->stu_ID = str_replace('/', '', $this->input->post('index_number'));

            //Save the ID for the current student being added
            $this->session->set_userdata('new_student', $this->stu_ID);

            // Get the data from $_POST into an array
            $data = array(
                'class_short' => $this->input->post('student_class'),
                'studentID' => $this->stu_ID,
                'picture' => $this->student_pic,
                'qrfile' => $this->qrfile,
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'other_names' => $this->input->post('other_names'),
                'index_number' => $this->input->post('index_number'),
                'hall' => $this->input->post('hall'),
                'nationality' => $this->input->post('nationality'),
                'pin' => $this->generatePin(),
                'description' => $this->input->post('description')
            );

            // set up insert query with tablename, values to insert
            $insert_student_entry = $this->db->insert('students', $data);

            if ($insert_student_entry) {
                return true;
            } else {
                return false;
            }
        }

        //Get the details of a specific student
        public function get_student($studentID) {
            //Get the passed ucciaId
            $this->studentID = $studentID;

            //Create where query
            $this->db->select('students.*, classes.name, classes.level');       //Select everything from Students, but class name and level from Classes
            $this->db->from('students');                                        //from students
            $this->db->join('classes', 'students.class_short = classes.class_short', 'inner');      //inner join classes on students.class_short = classes.class_short
            $this->db->where('studentID', $this->studentID);                                        //where the studentID is the one passed
            $query = $this->db->get();

            return $query->row();
        }

        // Get picture of student
        public function get_student_details($studentID) {
            //Get the passed ucciaId
            $this->studentID = $studentID;

            $this->db->select('students.studentID, students.class_short, students.firstname, students.lastname, students.other_names, students.index_number, students.hall, students.nationality, students.description, classes.name, classes.level');       //Select everything from Students, but class name and level from Classes
            $this->db->from('students');                             //from students
            $this->db->join('classes', 'students.class_short = classes.class_short', 'inner');      //inner join classes on students.class_short = classes.class_short
            $this->db->where('studentID', $this->studentID);         //where the studentID is the one passed
            $query = $this->db->get();
    
            //die(print_r($query->result()));
    
            return $query->row();
        }

        //Update the student's details
        public function update_student_details($studentID) {
            //Get the passed qrpic name
            $this->new_qrfile = $this->session->qrfile;
            //die($this->new_qrfile);

            //Take of the slashes in the student ID
            $this->stu_ID = str_replace('/', '', $this->input->post('index_number'));

            //Try updating the student's qrfile first, if it works, update the student's details
            if ($this->update_student_qr($studentID, $this->new_qrfile)) {
                // Get the data from $_POST into an array
                $data = array(
                    'class_short' => $this->input->post('student_class'),
                    'studentID' => $this->stu_ID,
                    'qrfile' => $this->new_qrfile,
                    'firstname' => $this->input->post('firstname'),
                    'lastname' => $this->input->post('lastname'),
                    'other_names' => $this->input->post('other_names'),
                    'index_number' => $this->input->post('index_number'),
                    'hall' => $this->input->post('hall'),
                    'nationality' => $this->input->post('nationality'),
                    'description' => $this->input->post('description')
                );

                // set up update query with tablename, values to insert and checkpoints
                $this->db->where('studentID', $studentID);
                $update_students_entry = $this->db->update('students', $data);

                if ($this->db->affected_rows() == 1) {
                    return true;
                } else {
                    return false;
                }
            } else {                //if updating the student's qrfile doesn't work, return false
                return false;
            }
        }

        // Get picture of student
        public function get_student_pic($studentID) {
            //Get the passed ucciaId
            $this->studentID = $studentID;

            $this->db->select('studentID, firstname, lastname, picture');       //Select everything from Students, but class name and level from Classes
            $this->db->from('students');                             //from students
            $this->db->where('studentID', $this->studentID);         //where the studentID is the one passed
            $query = $this->db->get();
    
            //die(print_r($query->result()));
    
            return $query->row();
        }

        public function update_student_pic($studentID, $new_picture) {
            $this->db->select('picture');                         //Select the user's current picture
            $this->db->where('studentID', $studentID);          //Where ucciaID = the passed ucciaId
            $query = $this->db->get('students');               //from the user's table
            $result = $query->row();
            //die(print_r($query->row()));

            if (file_exists('./assets/student_pic/' . $result->picture)) {
                //die("File $result->picture found");
                unlink('./assets/student_pic/' . $result->picture);
            }

            //Update the profile picture of the user in the users table
            // UPDATE `students` SET `picture` = 'new_picture' WHERE `studentID` = current student's id
            $this->db->set('picture', $new_picture);
            $this->db->where('studentID', $studentID);
            $this->db->update('students');

            //If everything checks out...
            if($this->db->affected_rows() == 1) {
                //die(print_r($this->session->userdata));
                return true;                                //return true
            } else {
                return false;           //say die
            }
        }

        //update QRCode file
        public function update_student_qr($studentID, $new_picture) {
            $this->db->select('qrfile');                         //Select the user's current picture
            $this->db->where('studentID', $studentID);          //Where ucciaID = the passed ucciaId
            $query = $this->db->get('students');               //from the user's table
            $result = $query->row();
            //die(print_r($query->row()));

            if (file_exists('./assets/qrs/' . $result->qrfile)) {
                //die("File $result->picture found");
                unlink('./assets/qrs/' . $result->qrfile);
            }

            //Update the prcode picture of the user in the users table
            // UPDATE `students` SET `picture` = 'new_picture' WHERE `studentID` = current student's id
            $this->db->set('qrfile', $new_picture);
            $this->db->where('studentID', $studentID);
            $this->db->update('students');

            //If everything checks out...
            if($this->db->affected_rows() == 1) {
                //die(print_r($this->session->userdata));
                return true;                                //return true
            } else {
                return false;           //say die
            }
        }

        //Get the number of returned rows
        public function record_count() {
            return $this->db->count_all('students');
        }

        //This function gets a specific number of entries based on the parameters
        //@param $limit is the total number to retrieve
        //@param $start is where to start or ignore from
        public function get_spec_students($limit, $start) {
            //Set the limits to retrieve
            $this->db->limit($limit, $start);

            //Get all the classes in the system based on the limits
            $this->db->select('studentID, picture, firstname, lastname, other_names, index_number');
            $this->db->order_by('index_number', 'ASC');
            $this->db->order_by('lastname', 'ASC');
            $query = $this->db->get('students');
    
            //Put the data into an array and stripe off the junk info
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }

                return $data;
            }
            
            return false;
        }

        //Delete the students entry of this user
        public function delete_students($userucciaId, $id) {
            //Get the passed ucciaId
            $this->ucciaId = $userucciaId;
            $this->id = $id;

            //Create delete query
            $query = $this->db->delete(
                'students',                               //Delete from students
                array(
                    'ucciaId' => $this->ucciaId,       //where ucciaId = user's id
                    'id' => $this->id      //and id = the passed id
                    //'title' => $this->id      //and title = the passed title
                )      
            );

            if ($this->db->affected_rows() == 1) {
                return true;
            } else {
                return false;
            }
        }

        //Get all the students assigned to the passed class
        public function get_class_students($classshort) {
            //Get the passed classshort
            $this->classshort = $classshort;

            $this->db->select('students.studentID, students.picture, students.firstname, students.lastname, students.other_names, students.index_number');       //Select everything from Students, but class name and level from Classes
            $this->db->from('students');                             //from students
            $this->db->where('class_short', $this->classshort);         //where the classshort is the one passed
            $this->db->order_by('students.index_number', 'ASC');
            $this->db->order_by('students.lastname', 'ASC');
            $query = $this->db->get();

            //die(print_r($query->result()));
            return $query->result();
        }

        //generate random pin for student
        public function generatePin(){
            $charset = '0123456789';                            //charset to randomize
            $length = 4;                                        //length to generate
            $input_length = strlen($charset);
            $random_string = '';
    
            for($i = 0; $i < $length; $i++) {
                $random_character = $charset[mt_rand(0, $input_length - 1)];
                $random_string .= $random_character;
            }
    
            $rand = $random_string;

            //die($rand);
            return $rand;
        }

        //Get the details of a specific student
        public function get_student_remotely($studentID) {
            //Get the passed ucciaId
            $this->studentID = $studentID;
            //$this->studentClass = $studentClass;

            //first check if that class writes that exam


            //Create where query
            $this->db->select('students.*, classes.name, classes.level');       //Select everything from Students, but class name and level from Classes
            $this->db->from('students');                                        //from students
            $this->db->join('classes', 'students.class_short = classes.class_short', 'inner');      //inner join classes on students.class_short = classes.class_short
            $this->db->where('studentID', $this->studentID);                                        //where the studentID is the one passed
            $query = $this->db->get();
            //die
            return $query->row();
        }
    }
?>