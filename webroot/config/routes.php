<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Routings for Auth and remote access from the app
$route['auth'] = 'auth';
$route['auth/invigilator'] = 'auth/remoteInvigilatorLogin';
$route['auth/invigilator/(:any)'] = 'auth/remoteInvigilatorLogin/$1';
$route['auth/student/verif'] = 'auth/verifyStudent';
$route['auth/student/verif/(:any)'] = 'auth/verifyStudent/$1';
$route['auth/student/details'] = 'auth/getStudentDetails';
$route['auth/student/details/(:any)'] = 'auth/getStudentDetails/$1';


// Routings for search
$route['search'] = 'search';
$route['search/(:any)'] = 'search/$1';

//Routings for QRCode
$route['qr/(:any)'] = 'qrfactory/$1';
$route['students/qr/(:any)'] = 'students/generateQR/$1';

// Routings for invigilators
$route['invigilators'] = 'invigilator/all';
$route['invigilators/add'] = 'invigilators/picture';
$route['invigilators/add/picture'] = 'invigilators/picture';
$route['invigilators/add/details'] = 'invigilators/details';
$route['invigilators/edit'] = 'invigilators/edit_picture';
$route['invigilators/edit/(:any)'] = 'invigilators/edit_picture/$1';
$route['invigilators/edit/(:any)/picture'] = 'invigilators/edit_picture/$1';
$route['invigilators/edit/(:any)/details'] = 'invigilators/edit_details/$1';
$route['invigilators/view/(:any)'] = 'invigilators/view/$1';

// Routings for the classes
$route['exams/insert_record'] = 'exams/insert_record';
$route['exams/edit/(:any)'] = 'exams/edit/$1';
$route['exams/add/(:any)'] = 'exams/add/$1';
$route['exams/view/(:any)'] = 'exams/view/$1';
$route['exams'] = 'exams/all';

//Routings for Students
$route['students'] = 'students/picture';
$route['students/add'] = 'students/picture';
$route['students/add/picture'] = 'students/picture';
$route['students/add/details'] = 'students/details';
$route['students/edit'] = 'students/edit_picture';
$route['students/edit/(:any)'] = 'students/edit_picture/$1';
$route['students/edit/(:any)/picture'] = 'students/edit_picture/$1';
$route['students/edit/(:any)/details'] = 'students/edit_details/$1';
$route['students/view/(:any)'] = 'students/view/$1';

// Routings for the classes
$route['classes/insert_record'] = 'classes/insert_record';
$route['classes/edit/(:any)'] = 'classes/edit/$1';
$route['classes/add/(:any)'] = 'classes/add/$1';
$route['classes/view/(:any)'] = 'classes/view/$1';
$route['classes'] = 'classes/all';

// Routings for logout
$route['logout'] = 'users/logout';

//General routings
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;