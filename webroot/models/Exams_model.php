<?php
    class Exams_model extends CI_Model {
        public $invigilators;
        public $course_code;
        public $invigilator;
        public $studentID, $class_short;

        function __construct() {
			//$this->generateExamShort("Food");
        }

        //add a new exam
        public function add_exam() {
            //die(print_r($this->input->post('invigilators')));
            // Get the data from $_POST into an array
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'course_code' => $this->input->post('course_code'),
                'class_short' => $this->input->post('program'),
                'date' => $this->input->post('exam_date'),
                'start_time' => $this->input->post('start_time'),
                'close_time' => $this->input->post('end_time'),
                'venue' => $this->input->post('venue'),
                'description' => $this->input->post('description')
            );

            //start transaction
            $this->db->trans_start();
                //insert the exam details first
                $this->db->insert('exams', $data);

                //then get the invigilators array from the post request
                $invigilators = $this->input->post('invigilators');
                $course_code = $this->input->post('course_code');
                $class_short = $this->input->post('program');

                //die(print_r($invigilators));

                //run through the array and save the values in the exams_and_invigilators table
                foreach ($invigilators as $invigilator) {
                    $data = array(
                        'course_code' => $course_code,
                        'invigilatorID' => $invigilator,
                        'class_short' => $class_short
                    );
                    
                    $this->db->insert('exam_and_invigilators', $data);
                }


            $this->db->trans_complete();            //end the transaction

            if ($this->db->trans_status() === FALSE) {      //If there are errors,
                return false;                               //return false
            } else {                                        //If there are no errors,
                return true;                                //return true
            }
        }

        //Get all the exam entries
        public function get_all_exams() {
            //Get all the exams in the system
            $this->db->select('exam_short, name, level');
            $this->db->order_by('name', 'ASC');
            $this->db->order_by('level', 'ASC');
            $query = $this->db->get('exams');

            return $query->result();
        }

        //Get the number of returned rows
        public function record_count() {
            return $this->db->count_all('exams');
        }

        //This function gets a specific number of entries based on the parameters
        //@param $limit is the total number to retrieve
        //@param $start is where to start or ignore from
        public function get_spec_exams($limit, $start) {
            //Set the limits to retrieve
            $this->db->limit($limit, $start);

            //Get all the exams in the system based on the limits
            $this->db->select('course_name, course_code, date, start_time, close_time, venue');
            $this->db->order_by('course_code', 'ASC');
            $this->db->order_by('date', 'ASC');
            $query = $this->db->get('exams');
    
            //Put the data into an array and stripe off the junk info
            if ($query->num_rows() > 0) {
                foreach ($query->result() as $row) {
                    $data[] = $row;
                }

                return $data;
            }
            
            return false;
        }

        //Get the requested exam
        public function get_exam($course_code) {
            //Get the passed exam short
            $this->course_code = $course_code;

            $this->db->select('exams.*, classes.name');       //Select everything from exams, but class name and level from Classes
            $this->db->from('exams');                             //from exams
            $this->db->join('classes', 'exams.class_short=classes.class_short', 'inner');      //inner join classes on invigilators.class_short = classes.class_short
            //$this->db->join('exam_and_invigilators', 'exam_and_invigilators.course_code=exams.course_code', 'inner');      //inner join classes on invigilators.class_short = classes.class_short
            $this->db->where('exams.course_code', $this->course_code);         //where the course_code is the one passed
            $query = $this->db->get();

            //Create where query
            // $query = $this->db->get_where(
            //     'exams',                               //Select * from exams
            //     array(
            //         'course_code' => $this->course_code      //and id = the passed id
            //     )      
            // );

            //die(print_r($query->result()));

            return $query->row();
        }

        //Get all the invigilators assigned to the passed exam
        public function get_exam_invigilators($course_code) {
            //Get the passed $course_code
            $this->$course_code = $course_code;

            //Select invigilator's details
            //from the invigilator's table
            $this->db->select('invigilators.invigilatorID, invigilators.picture, invigilators.firstname, invigilators.lastname, invigilators.other_names, invigilators.department');       //Select everything from invigilators, but class name and level from Classes
            $this->db->from('exam_and_invigilators');                             //from invigilators
            $this->db->join('invigilators', 'invigilators.invigilatorID=exam_and_invigilators.invigilatorID', 'inner');      //inner join classes on invigilators.class_short = classes.class_short
            $this->db->where('exam_and_invigilators.course_code', $this->course_code);         //where the course_code is the one passed
            //$this->db->where('class_short', $this->$course_code);         //where the $course_code is the one passed
            $this->db->order_by('invigilators.lastname', 'ASC');
            $this->db->order_by('invigilators.department', 'ASC');
            $query = $this->db->get();

            //die(print_r($query->num_rows()));
            //die(print_r($query->result()));
            return $query->result();
        }

        //Get all the exams assigned to the passed invigilator
        public function get_invigilator_exams($invigilator) {
            //Get the passed $course_code
            $this->$invigilator = $invigilator;

            //Select exam's details
            //from the exams table
            $this->db->select('exams.course_name, exams.course_code, exams.date, exams.venue');
            $this->db->from('exams');
            $this->db->join('exam_and_invigilators', 'exam_and_invigilators.course_code=exams.course_code', 'inner');
            //$this->db->join('invigilators', 'exam_and_invigilators.invigilatorID=invigilators.invigilatorID', 'left');      //inner join classes on invigilators.class_short = classes.class_short
            $this->db->where('exam_and_invigilators.invigilatorID', $this->invigilator);
            //$this->db->where('invigilators.invigilatorID', $this->invigilator);
            $this->db->order_by('exams.course_code', 'ASC');
            $this->db->order_by('exams.venue', 'ASC');
            $query = $this->db->get();

            //die(print_r($query->num_rows()));
            die(print_r($query->result()));
            return $query->result();
        }

        //Get all the exams assigned to the student
        //Students are already in a class and classes are assigned to each exam
        //So, if a student is in a class, then it means the student writes all the exams of that class
        //So, this algorithm uses the class_short of a student to determine their class and exams
        public function get_student_exams($class_short) {
            //Get the passed class short
            //$this->$class_short = $class_short;
            //die($class_short);

            //Select exam's details
            //from the exams table
            $this->db->select('exams.course_name, exams.course_code, exams.date, exams.venue');
            $this->db->from('exams');
            $this->db->join('classes', 'classes.class_short=exams.class_short', 'inner');
            $this->db->where('classes.class_short', $class_short);         //where the course_code is the one passed
            $this->db->order_by('exams.course_code', 'ASC');
            $this->db->order_by('exams.venue', 'ASC');
            $query = $this->db->get();
            //$query = $this->db->get_compiled_select();

            //echo $query;
            //die(print_r($query->result()));
            return $query->result();
        }

        //Update the exams
        public function update_exam($course_code) {
            //die(print_r($this->input->post('invigilators')));
            // Get the data from $_POST into an array
            $data = array(
                'course_name' => $this->input->post('course_name'),
                'course_code' => $this->input->post('course_code'),
                'class_short' => $this->input->post('program'),
                'date' => $this->input->post('exam_date'),
                'start_time' => $this->input->post('start_time'),
                'close_time' => $this->input->post('end_time'),
                'venue' => $this->input->post('venue'),
                'description' => $this->input->post('description')
            );

            //start transaction
            $this->db->trans_start();
                // set up update query with tablename, values to insert and checkpoints
                $this->db->where('exam_short', $course_code);
                $this->db->update('exams', $data);

                //then get the invigilators array from the post request
                $invigilators = $this->input->post('invigilators');
                $course_code = $this->input->post('course_code');

                //die(print_r($invigilators));

                //run through the array, check if an entry exist already...
                //If an entry exist already, delete it...
                //If one doesn't exist already, insert a new one
                foreach ($invigilators as $invigilator) {
                    $data = array(
                        'course_code' => $course_code,
                        'invigilatorID' => $invigilator
                    );
                    
                    //check if the entry exist already
                    $q = $this->db->get_where('exam_and_invigilators', $data);

                    if ($q->num_rows() == 1) {
                        $this->db->update('exam_and_invigilators', $data);            //if it does, just update it
                    } else {
                        $this->db->insert('exam_and_invigilators', $data);
                    }
                }


            $this->db->trans_complete();            //end the transaction

            if ($this->db->trans_status() === FALSE) {      //If there are errors,
                return false;                               //return false
            } else {                                        //If there are no errors,
                return true;                                //return true
            }

            // if ($this->db->affected_rows() == 1) {
            //     return true;
            // } else {
            //     return false;
            // }
        }
    }
?>