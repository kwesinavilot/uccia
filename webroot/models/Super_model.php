<?php
    //This model is for fetching universal data
    class Super_model extends CI_Model {

        public $ucciaId;        //user identifier
        private $table;          //Lookup target
        public $search_term;     //the term to be found
        public $invigilatorID, $course_code;

        //This function is for fetching the sums of the system's essentials
        public function getDashes(){
            //Get the sum of all students in the system
            $data['students'] = $this->db->count_all('students');

            //Get the sum of all invigilators in the system
            $data['invigilators'] = $this->db->count_all('invigilators');

            //Get the sum of all exams in the system
            $data['exams'] = $this->db->count_all('exams');

            //die(print_r($data));
            return $data;
        }

        //This function is for fetching the data of the user based on months of the current year
        // @param ucciaId is the ucciaId of the user
        // @param table is the table to perform the lookup on either Income or Expenses
        public function monthlies($userucciaId, $table) {
            $this->ucciaId = $userucciaId;
            $this->table = $table;
            //die($this->ucciaId . " ~ " . $this->table);

            if ($this->table == "expenses") {
                $this->id = "id";
            } else {
                $this->id = "id";
            }
            

            //Get the total of each month from the target table
            $this->db->select('COUNT(' . $this->id . ') entries, MONTHNAME(entry_date) month, SUM(amount) amount');                                              //SELECT MONTH(entry_date) month, SUM(amount) amount
            $this->db->group_by('MONTH(entry_date)');                                                                                //Group the results by month
            $clause = "ucciaId = '" . $this->ucciaId . "' AND YEAR(entry_date) = YEAR(CURRENT_DATE())";                             //Create where condition: ucciaId = id of user and year = the current year(by default)
            $this->db->where($clause);                                                                                    //Put the where clause into it   
            $query = $this->db->get($this->table);                                                                       //from the target table

            //die(print_r($query->result_array()));
            return $query->result();
        }

        //This function is for fetching all the halls in the system
        public function getHalls() {
            //Get all the classes in the system
            $this->db->select('name');
            $query = $this->db->get('halls');

            return $query->result();
        }

        //THis is a function to search the entire system for an entered term
        // @param search_term is the term that is to be searched or found
        public function search($search_term) {
            //Get the passed search_term
            $this->search_term = $search_term;

            //Create where query
            $query = $this->db->get_where(
                'classes',                               //Select * from classs
                array(
                    'class_short' => $this->search_term      //and id = the passed id
                )      
            );

            //die(print_r($query->result()));

            return $query->row();
        }

        //This function is for invigilators to log in using the app
        //@param course_code is the exam to be invigilated
        //@param invigilatorID is the invigilator seeking to log in and auth students
        public function verifyInvigilator($invigilatorID, $course_code) {  
            $this->course_code = $course_code;
            $this->invigilatorID = $invigilatorID;

            //die($this->course_code . " " . $this->invigilatorID);

            // get the invigilator and check if they have been assigned the passed course
            $this->db->select('*');      //Select id, email and password
            $this->db->where('course_code', $this->course_code);
            $this->db->where('invigilatorID', $this->invigilatorID);
            $query = $this->db->get('exam_and_invigilators');

            //die(print_r($query->row()));
            // Check the number of rows returns. if it is one then it is true
            if($query->num_rows() == 1) {
                //die(print_r($query->result_array()));
                return true;

                //return $query->result_array();
            } else {        //If the email doesn't exist
                return false;
            }
        }
    }
?>