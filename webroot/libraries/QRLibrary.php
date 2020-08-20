<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
    * This class manages all mailing and customer notifications
	*/
	
	class QRLibrary {
		
		function __construct() {
			// call original library
			include "phpqrcode/qrlib.php";
		}
	}

	/* end of file */
?>
