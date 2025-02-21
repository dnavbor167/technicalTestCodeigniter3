<?php
defined('BASEPATH') or exit('No direct script access allowed');
use Apirest\Libraries\REST_Controller;
require APPPATH . '/libraries/RestController.php';
require APPPATH . '/libraries/Format.php';

class Apirest extends REST_Controller
{

    public function test_get() {
        $array= array("Hola", "mundo");
        $this->response($array);
    }
}
