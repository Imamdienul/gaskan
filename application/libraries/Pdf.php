<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Load fpdf class from third_party
require_once(APPPATH . 'third_party/fpdf/fpdf.php');

class Pdf extends fpdf {
    public function __construct() {
        parent::__construct();
    }
}
