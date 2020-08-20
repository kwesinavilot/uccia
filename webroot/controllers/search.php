<?php
    class Search extends CI_Controller {
        public function index() {
            $search_term = $this->input->get('search_term');

            if ($search_term == " ") {
                $data['set'] = false;

                $this->load->view('search', $data);
            } else {
                //die($search_term);

                //Get the search term and search for it
                if ($this->Super_model->search($search_term)) {       //If we successfully inserted entry
                    $data['result'] = $this->Search_model->search($search_term);

                    redirect('search', $data);
                } else {
                    $data['set'] = false;

                    redirect('search', $data);
                }
            }
        }
    }
?>