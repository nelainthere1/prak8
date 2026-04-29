<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Prak5 extends CI_Controller {
    public function index() {
        $this->load->view('prak5/header');
        $this->load->view('prak5/app');
        $this->load->view('prak5/footer');
    }

    public function forum() {
        $this->load->view('prak5/header');
        $this->load->view('prak5/forum');
        $this->load->view('prak5/footer');
    }
}
