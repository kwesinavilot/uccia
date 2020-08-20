<?php
    class Classes_model extends CI_Model {
        function __construct() {
			//$this->generateclassShort("Food");
        }

        //add a new class
        public function add_class() {
            // Get the data from $_POST into an array
            $data = array(
                'name' => $this->input->post('class_name'),
                'size' => $this->input->post('class_number'),
                'level' => $this->input->post('level'),
                'degree' => $this->input->post('degree'),
                'department' => $this->input->post('department'),
                'school' => $this->input->post('school'),
                'college' => $this->input->post('college'),
                'description' => $this->input->post('description'),
                'class_short' => $this->generateclassShort($this->input->post('class_name'), $this->input->post('level')),
            );

            // set up add query with tablename, values to add
            $add_class_entry = $this->db->insert('classes', $data);

            if ($add_class_entry) {
                return true;
            } else {
                return false;
            }
        }

        //Get all the class entries of this user
        public function get_all_classes() {
            //Get all the classes in the system
            $this->db->select('class_short, name, level');
            $this->db->order_by('name', 'ASC');
            $this->db->order_by('level', 'ASC');
            $query = $this->db->get('classes');

            return $query->result();
        }

        //Get the number of returned rows
        public function record_count() {
            return $this->db->count_all('classes');
        }

        //This function gets a specific number of entries based on the parameters
        //@param $limit is the total number to retrieve
        //@param $start is where to start or ignore from
        public function get_spec_classes($limit, $start) {
            //Set the limits to retrieve
            $this->db->limit($limit, $start);

            //Get all the classes in the system based on the limits
            $this->db->select('class_short, name, level, size, department');
            $this->db->order_by('name', 'ASC');
            $this->db->order_by('level', 'ASC');
            $query = $this->db->get('classes');
    
            //Put the data into an array and stripe off the junk info
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }

                return $data;
            }
            
            return false;
       }

        public function generateclassShort($className, $classLevel){
            $sub = strtoupper(substr($className, 0, 4));       //get the uppercase version of the first 2 letter of the class name
            //die($sub);

            // $charset = '0123456789';                            //charset to randomize
            // $length = 3;                                        //length to generate
            // $input_length = strlen($charset);
            // $random_string = '';
    
            // for($i = 0; $i < $length; $i++) {
            //     $random_character = $charset[mt_rand(0, $input_length - 1)];
            //     $random_string .= $random_character;
            // }
    
            $gened = "CLS" . $sub . substr(date("Y"), 1, 4) . $classLevel;
            //die($gened);
            return $gened;
        }

        //Get the requested class
        public function get_class($classshort) {
            //Get the passed class short
            $this->short = $classshort;

            //Create where query
            $query = $this->db->get_where(
                'classes',                               //Select * from classs
                array(
                    'class_short' => $this->short      //and id = the passed id
                )      
            );

            //die(print_r($query->result()));

            return $query->row();
        }

        //Update the classs
        public function update_class($classshort) {
            //die(print_r($_POST));

            // Get the data from $_POST into an array
            $data = array(
                'name' => $this->input->post('class_name'),
                'size' => $this->input->post('class_number'),
                'level' => $this->input->post('level'),
                'degree' => $this->input->post('degree'),
                'department' => $this->input->post('department'),
                'school' => $this->input->post('school'),
                'college' => $this->input->post('college'),
                'description' => $this->input->post('description')
            );

            // set up update query with tablename, values to insert and checkpoints
            $this->db->where('class_short', $classshort);
            $update_classs_entry = $this->db->update('classes', $data);

            if ($this->db->affected_rows() == 1) {
                return true;
            } else {
                return false;
            }
        }
    }
?>