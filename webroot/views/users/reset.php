<?php
    if($this->session->flashdata('reset_success')) {
        echo "An email from us is on its way to <em>" . $this->session->flashdata('reset_success') . "</em>. Please follow the instructions therein to reset your password";
        //echo "<label class='container down-liner'>
                //<a href='' id='back-to-reset'>Used the wrong email?</a>
            //</label>";
    } else {
        $attributes = array('id' => 'reset-form');     //Create main form attributes

        echo form_open('users/reset', $attributes);    //Create form and set attributes

        //Set the attributes for the email input
        $data = array('name' => 'email',
                        'type' => "email",
                        'class' => "content-form-elems",
                        'placeholder' => "Email",
                        'value' => set_value("email")
                );
        echo form_input($data);     //Create the email input
        echo form_error('email');

        //Set the attributes for the signup button input
        $data = array('name' => 'reset-button',
                        'class' => "content-form-action",
                        'value' => "reset"
                );
        echo form_submit($data);     //

        echo "<label class='container down-liner'>
                <a href='' id='reset-to-signup'>Create a new account?</a>
            </label>";

        echo form_close();
    }
?>