<?php
    class Home extends CI_Controller {
        public function index() {
            //$data['main_content'] = "home";
            //$this->load->view("generics/header-footer", $data);

            // if (!file_exists(APPATH . '/' . $page . '.php')) {
            //     show_404();
            // }

            $this->deviceDetails();

            if(!isset($this->session->adminId)) {
                $this->load->view("home");
            } else {
                $this->load->view("dashboard");
            }
        }

        public function deviceDetails () {
            $this->load->library('user_agent');                             //Get the User Agent library

            //Check for device of access
            if ($this->agent->is_browser()) {                               //Is is a browser....
                    $agent['agent'] = $this->agent->browser() . ' ' . $this->agent->version();               //Get the browser's name and version
            } elseif ($this->agent->is_robot()) {                            //Is it a robot...
                    $agent['agent'] = $this->agent->robot();                //Get the robot
            } elseif ($this->agent->is_mobile()) {                          //Mobile access...
                    $agent['agent'] = $this->agent->mobile();
            } else {                                                        //We don't know...
                    $agent['agent'] = 'Unidentified User Agent';                     //We don't know!
            }

            $agent['ip'] = $_SERVER['REMOTE_ADDR'];
            $agent['platform'] = $this->agent->platform();                  // Platform info (Windows, Linux, Mac, etc.)

            $this->session->set_userdata($agent);

            return true;
        }

        // public function view($page = 'home') {
        //     if (!file_exists(APPATH . 'views/' . $page . '.php')) {
        //         show_404();
        //     }
        // }


    }
?>