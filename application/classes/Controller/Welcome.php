<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Welcome extends Controller {

	public function action_index()
	{
		//$this->response->body('Hello world!');
        $this->response->body('Hello '.User::instance()->name()); 
	}

} // End Welcome
