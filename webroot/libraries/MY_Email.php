<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
    * This class manages all mailing and customer notifications
    */
    class MY_Email extends CI_Email {

        private $name;
        private $subject, $body;
        private $sender, $verifyCode;
        private $path, $message;
        private $recipient, $resetCode;

        public function __construct($config = array()) {
            parent::__construct($config);

            $this->CI =& get_instance();                      //Get CI resources

            $this->name = "";                           //The name of the user
            $this->verifyCode = "";                     //Verification code
            $this->recipient = "";                      //The user's email
            $this->subject = "";                        //The subject of the email
            $this->body = "";                           //The body of the email
            $this->path = "";                           //Where to save the email
            $this->messge = "";                         //The message of the email itself
            $this->sender = "noreply@cheyn.com";      //The sending email address
            $this->resetCode = "";                      //The reset code to be sent
        }

        /**
         * This function is the core function for sending mails.
         * @param name is the name of the customer to recieve mail
         * @param recipient is the recipient address of the customer
         * @param case is the case which specifies the kind of message the mail will contain
         */
        public function sendMail ($name, $recipient, $case) {
            $this->name = $name;
            $this->recipient = $recipient;

            switch ($case) {
                /**
                 * Notify the user that they just signed up for a Cheyn account
                 */
                case 'join':
                    //$veris = new VerificationFactory();
                    //$this->verifyCode = $veris->getCode($this->recipient);
                    //die(print_r($this->verifyCode));

                    $this->subject = "Join Successful!";
                    $this->body = "Welcome, $this->name to Cheyn!\n"
                                    ."Cheyn is a platform purely geared towards helping your manage your financial life without breaking a sweat."
                                    ."To start discovering this great opportunity, please verify your account by clicking the link below:\n\n";

                    $this->body .= "http://" . $_SERVER['SERVER_NAME'] . "/www.cheyn.com/verify/?yell=j78767jmh66\n\n"
                                    ."Feel free to explore the Cheyn universe. Thank you.\n\n"
                                    . "Yours sincerely,\n"                    
                                    . "Your Cheyn Team.";
                break;

                /**Notify the user that they just logged in.
                 * Tell the user the time they logged in and the browser, device and ip address they are using
                */
                case 'login':
                    $this->subject = "You Just Logged In!";
                    $this->body = "Welcome back, $this->name, to Cheyn!\n"
                                    . "Beware of the little expenses: a small leak will sink a great ship! So remember to do your possible best to keep track of everything.\n\n"
                                    . "Here are some further details about your account login:\n\n";

                    $this->body .= "Time: " . date('g:i A') . "\n"
                                    . "Means: " . $this->CI->session->agent. "\n"
                                    . "Platform: " . $this->CI->session->platform. "\n"
                                    . "Location: " . $this->CI->session->ip . "\n\n";

                    $this->body .= "If this wasn't you and you believe your account may have been compromised, then you need to take a few steps to make sure your account is secure."
                                    . " To start, reset your password now using the link below:\n"
                                    . "http://" . $_SERVER['SERVER_NAME'] . "/www.cheyn.com/reset\n\n"
                                    . "Yours sincerely,\n"                    
                                    . "Your Cheyn Team.";
                break;

                /**Notify the user that they just logged in.
                 * Tell the user the time they logged in and the browser, device and ip address they are using
                */
                case 'vendor-login':
                    $this->subject = "You just logged in";
                    $this->body = "Welcome back, $this->name, to your Cheyn store!\n"
                                    . "Be sure to check out our new promos and deals cos they're just right for you.\n\n"
                                    . "You logged in at " . date('g:i A') . " from " . $_SERVER['REMOTE_ADDR'] . "\n\n"
                                    . "If this wasn't you and you believe your account may have been compromised, then you need to take a few steps to make sure your account is secure."
                                    . "To start, reset your password now using the link below:\n"
                                    . "http://" . $_SERVER['SERVER_NAME'] . "/vendors.Cheyn.com/reset\n\n"
                                    . "Yours sincerely,\n"                    
                                    . "Your Cheyn Team.";
                break;

                /**
                 * Notify the user that their account has been verified successfully
                 */
                case 'verified':
                    $this->subject = "Account Verified Successfully!";
                    $this->body = "Hi, $this->name,\n"
                                    . "Your account has been verified successfully. You can now explore the Cheyn universe and enjoy all the fun that comes with it."
                                    . "Let nothing stop you now, go on and explore a whole new world of opportunities.\n\n"
                                    . "Yours sincerely,\n"                    
                                    . "Your Cheyn Team.";
                break;

                /**
                 * Notify the user that they have subscribed to recieve newsletters
                 */
                case 'subscribed':
                        $this->subject = "Thanks For Subscribing!";
                        $this->body = "Hello there, we're so glad you signed up for our newsletters.\n"
                                        . "By signing up, you get to recieve insights about the latest trends and updates in the Cheyn world.\n"
                                        .   "You also get the change to recieve headstart news about upcoming promotions, deals and offers even before they start.\n"
                                        . "These newsletters will help you stay on top of the game and be proactive to the opportunities that comes with them.". PHP_EOL . PHP_EOL
                                        . "Thanks again for signing up and we hope to give you the best gist in the Cheyn universe.". PHP_EOL . PHP_EOL
                                        . "If you want to unsubscribe too, please click the link below:\n"
                                        . "http://" . $_SERVER['SERVER_NAME'] . "/www.cheyn.com/subscriptions/?opt=unscriber&recPoint=$this->recipient\n\n"
                                        . "Yours sincerely,\n"                    
                                        . "Your Cheyn Team.";
                break;

                /**
                 * Notify the user that they just unsubscribed from the Cheyn newsletters
                 */
                case 'unsubscribed':
                    $this->subject = "You've Unsubscribed From Our Newsletters!";
                    $this->body = "Hello there, you just unsubscribed from our newsletters.\n"
                                    . "It's rather unfortunate that you've unsubscribed from our newsletters but you can always subscribe again, anytime.\n"
                                    .   "Our newsletters are tailored to give you detailed news and information about upcoming promotions, deals and offers even before they start.\n"
                                    . "These newsletters will help you stay on top of the game and be proactive to the opportunities that comes with them.". PHP_EOL . PHP_EOL
                                    . "Thanks again for signing up initially and we hope to see you subscribe again.". PHP_EOL . PHP_EOL
                                    . "If you want to subscribe now, please click the link below:\n"
                                    . "http://" . $_SERVER['SERVER_NAME'] . "/www.cheyn.com/subscriptions/?opt=scriber&recPoint=$this->recipient\n\n"
                                    . "Yours sincerely,\n"                    
                                    . "Your Cheyn Team.";
                break;
                
                /**
                 * Notify the user that they just updated their hall address
                 */
                case 'bucket-create':
                    $this->subject = "You Created A New Bucket";                    
                    $this->body = "Hi, $this->name, this is to confirm that you've created a new bucket called " . $this->CI->session->bucket_name . "\n"
                                    . "Well done! Categorising the flow of your money is a great step to financial freedom."
                                    . "It helps you know where your money comes from and goes to. Keep it up.\n\n"
                                    . "Yours sincerely,\n"                    
                                    . "Your Cheyn Team.";
                                    
                break;

                /**
                 * Notify the user that they just updated their hostel address
                 */
                // case 'hostel-update':
                //     $this->subject = "You Updated Your Hostel Address";                    
                //     $this->body = "Hi, $this->name,\n"
                //                     . "This is to confirm that you have updated your Cheyn hostel address.\n"
                //                     . "Here are the details:\n\n"
                //                     . "Contact: " . $this->CI->session->hostel_address']['contact'] . PHP_EOL
                //                     . "Room: " . $this->CI->session->hostel_address']['room'] . PHP_EOL
                //                     . "Hostel: " . $this->CI->session->hostel_address']['hall_hostel'] . PHP_EOL
                //                     . "Street: " . $this->CI->session->hostel_address']['street'] . PHP_EOL;

                //                     if (isset($this->CI->session->hostel_address']['description'])) {
                //                         $this->body .= "Description: " . $this->CI->session->hostel_address']['description'] . PHP_EOL;
                //                     }

                //     $this->body .= PHP_EOL . "If you didn't make this change, let us know right away by using the link below:\n"
                //                     . "http://" . $_SERVER['SERVER_NAME'] . "/www.cheyn.com/custcare/?rec=yes&ish=unauth_add_change\n\n"
                //                     . "Yours sincerely,\n"                    
                //                     . "Your Cheyn Team.";
                                    
                // break;

                /**
                 * Notify the user that they just requested for a password reset link.
                 */
                case 'reset_start':
                    //$reset = new ResetFactory();
                    //$this->resetCode = $reset->getCode($this->recipient);
                    //die($this->resetCode);

                    $this->subject = "Here's Your Password Reset Link";
                    $this->body = "Hi, did you forget your Cheyn password?\n"
                                    ."No problem. We are here to help you get back on track. Click on the link below to change your password\n\n"
                                        ."http://" . $_SERVER['SERVER_NAME'] . "/www.cheyn.com/reset/?yell=3233456\n\n"
                                    ."We suggest making your password easy to remember, but also as strong as possible. Try not to use any word that can be found in the dictionary, but do use a combination of upper and lower-case letters along with numbers and/or special characters\n\n"
                                    ."If you did not request a password reset, then simply ignore this email and no changes will be made.\n\n"
                                    . "Have a great day!\n"                    
                                    . "Your Cheyn Team.";
                break;

                /**
                 * Notify the user that they just requested for a password reset link without a legit account.
                 */
                case 'non_existent':
                    $this->subject = "You Gotta Have An Account To Reset Its Password";
                    $this->body = "Hello, we noticed that you wanted to change the Cheyn password of an account that doesn't exist.\n"
                                    ."You see, that's quite impossible. To reset the password of an account, you need to have actually created that account.\n"
                                    ."If you still want to have a feel of how our password reset system works, that's totally fine. Go ahead and click <a>here</a> to signup, log out, then reset your password.\n"
                                    ."We bet you, there's nothing much to see there - trust us, it's a total waste of time.\n\n";

                    $this->body .= "Rather, let's tell you where all the action is. You see, a lot of people want to be financially free but don't know how. Cheyn is therefore a platform simplified for tracking and managing your personal finances.\n"
                                    ."It is so because we believe that the basic key to wealth is to know where your money comes from and where it goes to.\n\n";
                                    
                    $this->body .= "All you have to do is to sign up for an account - for real this time - and stick to updating your spendings.\n\n"
                                    . "Have a great day!\n"                    
                                    . "Your Cheyn Team.";
                break;

                /**
                 * Notify the user that their password just got reseted.
                 */
                case 'reseted':
                    $this->subject = "Your Password Has Been Reseted";
                    $this->body = "Hi, $this->name, your Cheyn password just got reseted.\n"
                                    . "This password reset was done using $this->recipient on " . date('F j, Y') . " at " . date('g:i A') . "\n"
                                    . "Here are some further details:\n\n";

                    $this->body .= "Operating System: User's OS\n"
                                    . "Browser: User's Browser\n"
                                    . "Estimated Location: User's Location\n\n";

                    $this->body .= "If you did this, then you can safely disregard this email.\n"
                                    . "If you did not make this change and believe your Cheyn account has been compromised, please contact us using the link below:\n"
                                    . "http://" . $_SERVER['SERVER_NAME'] . "/www.cheyn.com/hacked\n\n"
                                    . "Yours sincerely,\n"                    
                                    . "Your Cheyn Team.";
                break;

                /**
                 * Notify the user that their password just got changed.
                 */
                case 'pass-change':
                    $this->subject = "Your Just Changed Your Password";
                    $this->body = "Hi, $this->name, your Cheyn password just got changed.\n"
                                    . "This password change was done on " . date('F j, Y') . " at " . date('g:i A') . "\n\n";

                    $this->body .= "If you did not make this change and believe your Cheyn account has been compromised, please contact us using the link below:\n"
                                    . "http://" . $_SERVER['SERVER_NAME'] . "/www.cheyn.com/custcare/?rec=yes&ish=unauth_pass_change\n\n"
                                    . "Yours sincerely,\n"                    
                                    . "Your Cheyn Team.";
                break;

                /**
                 * Notify the user that they just updated their details
                 */
                case 'details-update':
                    $this->subject = "You Updated Your Details";                    
                    $this->body = "Hi, $this->name,\n"
                                    . "This is to confirm that you have updated your Cheyn account details.\n"
                                    . "Here are your current details:\n\n";

                    $this->body .= "First Name: " . $this->CI->session->firstname . "\n"
                                    . "Last Name: " . $this->CI->session->lastname . "\n"
                                    . "Email: " . $this->CI->session->email . "\n";

                    $this->body .= "\nIf you didn't make this change, let us know right away by using the link below:\n"
                                    . "http://" . $_SERVER['SERVER_NAME'] . "/www.cheyn.com/custcare/?rec=yes&ish=unauth_det_change\n\n"
                                    . "Yours sincerely,\n"                    
                                    . "Your Cheyn Team.";
                                    
                break;

                /**
                 * Default message
                 */
                default:
                    $this->subject = "Experience Cheyn";
                    $this->body = "Cheyn is a Twi word that means 'Good market\n"
                                    . "This shows how we at Cheyn have you at heart to deliver only the best and quality products at affordable prices.";
                break;
            }


            $this->CI->email->from($this->sender, 'Cheyn Team');        //Set the sender email
            $this->CI->email->to($this->recipient);                     //Set the recipient email
            $this->CI->email->subject($this->subject);                  //Set the subject of the email
            $this->CI->email->message($this->body);                     //Set the message of the email

            $this->CI->email->send();                                   //Now, send it!
        }
    }
?>