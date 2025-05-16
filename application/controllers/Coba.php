<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coba extends CI_Controller {
    
    public function __construct() {
     
        parent::__construct();
        // Load models
        
    }
    
    public function index()
	{
	    $data['title'] = 'WEBSITE';

		
		$this->template->load('shared/index', 'coba', $data);
	}

    
    
    
    
    
    
    
}