<?php
    class Invigilators_model extends CI_Model {

        public $invigilatorID;
        private $id;

        //Get all the invigilator entries
        public function get_all_invigilators() {
            //Get all the invigilators in the system
            $this->db->select('invigilatorID, firstname, lastname');
            $this->db->order_by('lastname', 'ASC');
            $this->db->order_by('department', 'ASC');
            $query = $this->db->get('invigilators');

            return $query->result();
        }

        //Insert a new invigilators
        public function insert_invigilator() {
            //Get the passed pic name
            $this->invigilator_pics_name = $this->session->invigilator_pics_name;

            //Take of the slashes in the invigilator ID
            $this->invigilatorID = $this->generateInvigilatorShort($this->input->post('firstname'));

            //Save the ID for the current invigilator being added
            $this->session->set_userdata('new_invigilator', $this->invigilatorID);

            // Get the data from $_POST into an array
            $data = array(
                'invigilatorID' => $this->invigilatorID,
                'picture' => $this->invigilator_pics_name,
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'other_names' => $this->input->post('other_names'),
                'department' => $this->input->post('department'),
                'description' => $this->input->post('description')
            );

            // set up insert query with tablename, values to insert
            $insert_invigilator_entry = $this->db->insert('invigilators', $data);

            if ($insert_invigilator_entry) {
                return true;
            } else {
                return false;
            }        
        }
        
        //Get all the invigilators entries of this user
        public function get_invigilator($invigilatorID) {
            $this->invigilatorID = $invigilatorID;

            //Create where query
            $query = $this->db->get_where(
                'invigilators',                               //Select * from invigilators
                array(
                    'invigilatorID' => $this->invigilatorID      //where invigilatorID = user's id
                )      
            );

            //die(print_r($query->row()));

            return $query->row();
        }

        // Get picture of invigilator
        public function get_invigilator_details($invigilatorID) {
            //Get the passed ucciaId
            $this->invigilatorID = $invigilatorID;

            $this->db->select('invigilators.invigilatorID, invigilators.firstname, invigilators.lastname, invigilators.other_names, invigilators.department, invigilators.description');       //Select everything from invigilators, but class name and level from Classes
            $this->db->from('invigilators');                             //from invigilators
            //$this->db->join('classes');      //inner join classes on invigilators.class_short = classes.class_short
            $this->db->where('invigilatorID', $this->invigilatorID);         //where the invigilatorID is the one passed
            $query = $this->db->get();
    
            //die(print_r($query->result()));
    
            return $query->row();
        }

        // Get picture of invigilator
        public function get_invigilator_pics($invigilatorID) {
            //Get the passed ucciaId
            $this->invigilatorID = $invigilatorID;

            $this->db->select('invigilatorID, firstname, lastname, picture');       //Select everything from invigilator, but class name and level from Classes
            $this->db->from('invigilators');                             //from invigilator
            $this->db->where('invigilatorID', $this->invigilatorID);         //where the invigilatorID is the one passed
            $query = $this->db->get();
    
            //die(print_r($query->result()));
    
            return $query->row();
        }

        public function update_invigilator_pics($invigilatorID, $new_picture) {
            $this->db->select('picture');                         //Select the user's current picture
            $this->db->where('invigilatorID', $invigilatorID);          //Where ucciaID = the passed ucciaId
            $query = $this->db->get('invigilators');               //from the user's table
            $result = $query->row();
            //die(print_r($query->row()));

            if (file_exists('./assets/invigilator_pics/' . $result->picture)) {
                //die("File $result->picture found");
                unlink('./assets/invigilator_pics/' . $result->picture);
            }

            //Update the profile picture of the user in the users table
            // UPDATE `invigilator` SET `picture` = 'new_picture' WHERE `invigilatorID` = current invigilator's id
            $this->db->set('picture', $new_picture);
            $this->db->where('invigilatorID', $invigilatorID);
            $this->db->update('invigilators');

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
            return $this->db->count_all('invigilators');
        }

        //This function gets a specific number of entries based on the parameters
        //@param $limit is the total number to retrieve
        //@param $start is where to start or ignore from
        public function get_spec_invigilators($limit, $start) {
            //Set the limits to retrieve
            $this->db->limit($limit, $start);

            //Get all the classes in the system based on the limits
            $this->db->select('invigilatorID, picture, firstname, lastname, other_names, department');
            $this->db->order_by('lastname', 'ASC');
            $this->db->order_by('department', 'ASC');
            $query = $this->db->get('invigilators');
    
            //Put the data into an array and stripe off the junk info
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }

                return $data;
            }
            
            return false;
        }

        //Delete the invigilators entry of this user
        public function delete_invigilators($userinvigilatorID, $id) {
            //Get the passed invigilatorID
            $this->invigilatorID = $userinvigilatorID;
            $this->id = $id;

            //Create delete query
            $query = $this->db->delete(
                'invigilators',                               //Delete from invigilators
                array(
                    'invigilatorID' => $this->invigilatorID,       //where invigilatorID = user's id
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

        //Update the invigilators
        public function update_invigilator_details($invigilatorID) {
            //die("Inserting " . $this->session->invigilatorID);

            //Get the passed invigilatorID
            $this->invigilatorID = $invigilatorID;

            // Get the data from $_POST into an array
            $data = array(
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'other_names' => $this->input->post('other_names'),
                'department' => $this->input->post('department'),
                'description' => $this->input->post('description')
            );

            // set up update query with tablename, values to insert and checkpoints
            $this->db->where('invigilatorID', $this->invigilatorID);
            $update_invigilators_entry = $this->db->update('invigilators', $data);

            if ($this->db->affected_rows() == 1) {
                return true;
            } else {
                return false;
            }
        }

        public function generateInvigilatorShort($firstName){
            $sub = strtoupper(substr($firstName, 0, 3));       //get the uppercase version of the first 2 letter of the class name
            //die($sub);

            $charset = '0123456789';                            //charset to randomize
            $length = 4;                                        //length to generate
            $input_length = strlen($charset);
            $random_string = '';
    
            for($i = 0; $i < $length; $i++) {
                $random_character = $charset[mt_rand(0, $input_length - 1)];
                $random_string .= $random_character;
            }
    
            $rand = $random_string;
            //die($gened);
    
            $gened = "IVG" . $sub . $rand;
            //die($gened);
            return $gened;
        }
    }
?>