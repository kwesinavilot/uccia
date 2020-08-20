<?php
    class Auth extends CI_Controller {
        private $assigned;
        public $response;
        public $invigilatorID, $course_code;
        public $student, $studentID;

        // public function __construct() {
        //     parent::__construct();

        //     //parse_str($_SERVER['QUERY_STRING'],$_GET);
        // }

        public function index() {
            print "I work";
            die(print_r($this->input->get()));
        }

        //This function is for invigilators to log in using the app
        //@param exam_code is the exam to be invigilated
        //@param invigilatorID is the invigilator seeking to log in and auth students
        public function remoteInvigilatorLogin() {
            //die(print_r($this->input->get()));

            //get the values passed by the request using GET
            $this->invigilatorID = $this->input->get('invigilatorID', TRUE);;
            $this->course_code = $this->input->get('course_code', TRUE);

            //die($this->invigilatorID . " " . $this->course_code);

            //Check if the person trying to get access is truly assigned to that class
            //verify whether the invigilator has access to the passed exam
            $this->assigned = $this->Super_model->verifyInvigilator($this->invigilatorID, $this->course_code);

            //set the response message
            if ($this->assigned == true) {
                $this->response = "proceed";
            } else {
                $this->response = "return";
            }
            
            //create the response header
            header('Content-Type: application/json');

            //create the json array
            echo json_encode($this->response);
            //echo json_encode(array("invigilator" => $this->invigilatorID, "course_code" => $this->course_code));
        }

        //This function is to check if the student exists in the system
        // check if student is in the class
        // if yes, check if they can take exam
        //@param exam_code is the exam to be invigilated
        //@param invigilatorID is the invigilator seeking to log in and auth students
        public function verifyStudent() {
            //die(print_r($this->input->get()));

            //get the values passed the request
            $this->studentID = $this->input->get('studentID');
            //$this->studentClass = $this->input->get('studentClass');
            //$this->exam_code = $this->input->get('exam_code');
            //$course_code = $this->input->get('exam');

            //Take of the slashes in the student ID
            $this->studentID = str_replace('/', '', $this->studentID);

            //Check if the person trying to get access is truly assigned to that class
            //verify whether the invigilator has access to the passed exam
            $this->student = $this->Students_model->get_student($this->studentID);;
            //die(print_r($this->student));
                
            //Check if there's a content for the view id...
            if(empty($this->student)){
                //show_404();                         //...if there's nothing, show the 404 page;
                $this->response = "return";
            } else {
                $this->response = "proceed";
            }

            //create the response header
            header('Content-Type: application/json');

            //create the json array
            //echo json_encode($this->response);
            echo json_encode(array("response" => $this->response, "studentID" => $this->studentID));
        }

        //@param exam_code is the exam to be invigilated
        //@param invigilatorID is the invigilator seeking to log in and auth students
        public function getStudentDetails() {
            //die(print_r($this->input->get()));

            //get the values passed the request
            $this->studentID = $this->input->get('studentID');
            //$this->studentClass = $this->input->get('studentClass');
            //$this->exam_code = $this->input->get('exam_code');
            //$course_code = $this->input->get('exam');

            //Take of the slashes in the student ID
            $this->studentID = str_replace('/', '', $this->studentID);

            //Check if the person trying to get access is truly assigned to that class
            //verify whether the invigilator has access to the passed exam
            $this->student = $this->Students_model->get_student_remotely($this->studentID);;
            //die(print_r($this->student));
                
            //Check if there's a content for the view id...
            if(empty($this->student)){
                //show_404();                         //...if there's nothing, show the 404 page;
                $this->response = "return";
            } else {
                $this->response = $this->student;
            }

            //create the response header
            header('Content-Type: application/json');

            //create the json array
            echo json_encode($this->response);
        }
    }
?>