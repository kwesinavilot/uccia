<?php
    class QRFactory extends CI_Controller {
        public function index($value) {
            $this->load->library('qrlibrary');

            $data = QRcode::png($value);

            $this->load->view("qr", $data);
        }
    }
?>