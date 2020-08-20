<?php
    class Dashboard extends CI_Controller {
        public function index() {
            $ucciaId = $this->session->ucciaId;

            $data['dashes'] = $this->Super_model->getDashes();

            //Get the expenses proportions of the user's buckets
            //$data['inc_centiles'] = $this->Charts_model->bucket_proportions($ucciaId, "income");

            //Get the expenses proportions of the user's buckets
            //$data['exp_centiles'] = $this->Charts_model->bucket_proportions($ucciaId, "expenses");

            //Get all the buckets of the user
            //$data["buckets"] = $this->Buckets_model->get_bucket_essentials($ucciaId);

            //die(print_r($data));
            
            $this->load->view("dashboard", $data);
        }

        public function logout() {
            $this->session->sess_destroy();
            redirect("home");
        }

        public function getHighlights() {
            $ucciaId = $this->session->ucciaId;

            $this->User_model->getDashes($ucciaId);
        }
    }
?>