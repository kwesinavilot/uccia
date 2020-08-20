<?php
    //require 'assets/php/essentials.php';

    class User_model extends CI_Model {

        public $ucciaId;
		public $fistname;
		public $lastname;
        public $email;
        public $date_created;
        public $isLoggedIn;
        public $check_email;
        public $picture;

        function __construct() {
			//If the isLoggedIn is set to true
			if($this -> isLoggedIn()) {
				$this -> currentUser();		//User has already logged in so get the current user
			}
        }
        
        public function isAccountAvailable($passed_email) {
            $this->check_email = $passed_email;

            $this->db->select('email');
            $this->db->where('email', $this->check_email);
            $query = $this->db->get('users');

            //die(print_r($query->num_rows()));

            if ($query->num_rows() == 1) {
                return false;
            } else {
                return true;
            }
        }

        //Create a new user
        // public function signup() {
        //     //Generate the Cheyn ID of the user
        //     //$ucciaID = generateucciaId();
        //     //die($ucciaID);

        //     //Encrypt the entered password
        //     $password = password_hash($this->input->post('confirm-password'), PASSWORD_DEFAULT);

        //     //die(print_r($this->input->post()));
            
        //     //Create an array to hold the pass inputs from the sign up form
        //     // $data = array(
        //     //     'ucciaID' => $ucciaID,
        //     //     'firstname' => $this->input->post('firstname'),
        //     //     'lastname' => $this->input->post('surname'),
        //     //     'email' => $this->input->post('email')
        //     // );

        //     // set up insert query with tablename, values to insert
        //     $insert_into_users = $this->db->insert('users', $data);

        //     //if we're able to insert into user, insert into login
        //     if ($insert_into_users) {
        //         $data = array(
        //             'ucciaID' => $ucciaID,
        //             'email' => $this->input->post('email'),
        //             'password' => $password
        //         );

        //         $insert_into_login = $this->db->insert('login', $data);

        //         // get query execution result
        //         return $insert_into_login;
        //     }
        // }

        //Log the user in
        public function login($email, $password) {
            //die(print_r($this->input->post()));
            //die(print_r($this->session->;
            
            //Check for the email
            $this->db->select('users.firstname, login.ucciaID, login.email, password');      //Select id, email and password
            $this->db->from('login');           //from the login table
            $this->db->join('users', 'login.email = users.email', 'inner');     //inner join users on login.email = user.email

            $where = "login.email = '$email' AND users.email = '$email'";           //Create custom where clause
            $this->db->where($where);      //Create where clause using custom where clause
            $query = $this->db->get();

            //Check the number of rows returns
            if($query->num_rows() == 1) {
                //die(print_r($query->result_array()));
                $resultSet = $query->row();         //Get the results as a row object

                //Verify entered password with the one in the database
                if (password_verify($password, $resultSet->password)) {
                    return $resultSet->ucciaID;
                } else {
                    return false;      //If wrong, signal wrong password
                }
                
                //die(print_r($resultSet->password));
            } else {        //If the email doesn't exist
                return false;
            }
        }

        //Get the details of the user who just signed in
        public function getUserDetails($ucciaId) {
            //die(print_r($this->input->post()));
            
            //Check for the email
            $this->db->select('*');                         //Select everything
            $this->db->where('ucciaID', $ucciaId);          //Where ucciaID = the passed ucciaId
            $query = $this->db->get('users');               //from the user's table
            //die(print_r($query->row()));

            //Check the number of rows returns
            if($query->num_rows() == 1) {
                //die(print_r($query->result_array()));
                $resultSet = $query->row();         //Get the results as a row object

                //Assign all values to approppriate variables
                $this->ucciaId = $resultSet->ucciaID;
				$this->firstname = $resultSet->firstname;
				$this->lastname = $resultSet->lastname;
                $this->email = $resultSet->email;
                $this->picture = $resultSet->picture;
				$this->date_created = $resultSet->date_created;
				$this->isLoggedIn = true;

                //Now set the session using these values
				$this->setSession();

				return true;
            } else {        //If there's an error
                return false;
            }
        }

        //Add the details of the user
        private function setSession (){
            //Create an array to store user basic details
            $current_user = array(
                'ucciaId' => $this->ucciaId,
                'firstname' => $this->firstname,
			    'lastname' => $this->lastname,
                'email' => $this->email,
                'picture' => $this->picture,
                'date_created' => $this->date_created,
                'loggedIn' => $this->isLoggedIn
            );
            
            $this->session->set_userdata($current_user);
		}

        //Get back the already stored data
		private function currentUser() {
			$this->ucciaID = $this->session->ucciaID;
			$this->firstname = $this->session->firstname;
			$this->lastName = $this->session->lastname;
            $this->email = $this->session->email;
            $this->picture = $this->session->picture;
			$this->date_created = $this->session->date_created;
			$this->isLoggedIn = true;
        }
        
        //Check if the user has logged in already
        public function isLoggedIn() {
	        if(isset($this->session->isLoggedIn) && $this->session->isLoggedIn == true){
	            return true;
	        } else {
	            return false;
	        }
        }
        
        // Get the essentials for the Dashboard
        public function getDashes($ucciaId) {
            // //Check for the email
            // $this->db->select('SUM(income.amount) AS income, SUM(expenses.amount) AS expenses');      //Select the sum of income and expenses
            // $this->db->from('income');           //from the income table
            // $this->db->join('expenses', 'income.ucciaID = expenses.ucciaID', 'inner');     //inner join expenses on 

            // $where = "income.ucciaID = '$ucciaId' AND expenses.ucciaID = '$ucciaId'";           //Create custom where clause
            // $this->db->where($where);      //Create where clause using custom where clause
            // $query = $this->db->get();

            //return $query->row();

            //Get the total income for the user
            $this->db->select('SUM(income.amount) AS income');                         //Select the sum of all incomes
            $this->db->where('ucciaID', $ucciaId);          //Where ucciaID = the passed ucciaId
            $query = $this->db->get('income');               //from the income table
            $dashes['income'] = $query->row()->income;

            //Get the total expenses for the user
            $this->db->select('SUM(expenses.amount) AS expenses');                         //Select the sum of all expenses
            $this->db->where('ucciaID', $ucciaId);          //Where ucciaID = the passed ucciaId
            $query = $this->db->get('expenses');               //from the expenses table
            $dashes['expenses'] = $query->row()->expenses;
            
            //die(print_r($dashes));
            return $dashes;
        }

        // Update the user's personal details
        public function update_details($ucciaId){
            $data = array(
                'firstname' => $this->input->post('firstname'),
                'lastname' => $this->input->post('lastname'),
                'email' => $this->input->post('email')
            );
        
            $this->db->trans_start();                                   //Start the transaction

                //Update the users table with details based on ucciaId
                $this->db->where('ucciaID', $ucciaId);
                $this->db->update('users', $data);

                //Update the email of the user in the login table
                // UPDATE `login` SET `email` = 'Entered email' WHERE `ucciaId` = current user's ucciaId
                $this->db->set('email', $data['email']);
                $this->db->where('ucciaID', $ucciaId);
                $this->db->update('login');
        
            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {      //If there are errors,
                return false;                               //return false
            } else {                                        //If there are no errors,
                //die(print_r($this->session->userdata));
                $this->getUserDetails($ucciaId);
                return true;                                //return true
            }
        }

        //Change the user's password
        public function change_password($ucciaId){
            $new_password = password_hash($this->input->post('confirm_new'), PASSWORD_DEFAULT);

            //Update the password of the user in the login table
            // UPDATE `login` SET `password` = 'new_password' WHERE `ucciaId` = current user's ucciaId
            $this->db->set('password', $new_password);
            $this->db->where('ucciaID', $ucciaId);
            $this->db->update('login');

            //If everything checks out...
            if($this->db->affected_rows() == 1) {
                //die(print_r($this->session->userdata));
                $this->getUserDetails($ucciaId);
                return true;                                //return true
            } else {
                return false;           //say die
            }
        }

        //Change the user's profile picture
        public function updatePicture($ucciaId, $new_picture){
            //Check for the email
            $this->db->select('picture');                         //Select the user's current picture
            $this->db->where('ucciaID', $ucciaId);          //Where ucciaID = the passed ucciaId
            $query = $this->db->get('users');               //from the user's table
            $result = $query->row();
            //die(print_r($query->row()));

            if (file_exists('./assets/profile/' . $result->picture)) {
                //die("File $result->picture found");
                unlink('./assets/profile/' . $result->picture);
            }

            //Update the profile picture of the user in the users table
            // UPDATE `users` SET `picture` = 'new_picture' WHERE `ucciaId` = current user's ucciaId
            $this->db->set('picture', $new_picture);
            $this->db->where('ucciaID', $ucciaId);
            $this->db->update('users');

            //If everything checks out...
            if($this->db->affected_rows() == 1) {
                //die(print_r($this->session->userdata));
                $this->getUserDetails($ucciaId);
                return true;                                //return true
            } else {
                return false;           //say die
            }
        }

        //Verify the user's password
        public function verify_password($ucciaId) {
            $current_password = $this->input->post('current_password');

            //Verify ucciaID and get the user's password
            $this->db->select('password');                         //Select password
            $this->db->where('ucciaID', $ucciaId);          //Where ucciaID = the passed ucciaId
            $query = $this->db->get('login');               //from the login table
            $result = $query->row();                        //Get the result as a row
            //die(print_r($result));

            //Now crosscheck the entered current password against the existing one
            if(password_verify($current_password, $result->password)) {
                //die("yes");
                return true;            //return true
            } else {
                //die('no');
                return false;
            }
        }
    }
    
?>