<?php defined('SYSPATH') or die('No direct script access.');
/*
 * @package		App-skeleton
 * @author      Pap Tamas
 * @copyright   (c) 2011-2012 Pap Tamas
 * @website		https://bitbucket.org/paptamas/app-skeleton
 */

class Controller_Error_Handler extends Controller {

    /**
     * @var array Default error titles and messages
     */
    public $default = array(
        404 => array(
            'title' => '404 Not Found',
            'message' => 'Server can not find the requested page.'
        ),

        403 => array(
            'title' => '403 Forbidden',
            'message' => 'You do not have permission to access this page.'
        ),

        503 => array(
            'title' => '503 service unavailable',
            'message' => 'We are maintaining our server. We will very back soon.'
        ),

        500 => array(
            'title' => 'Internal server error',
            'message' => 'Something went wrong. Please try again later.'
        )
    );

    /**
     * Before
     */
    public function before()
    {
        parent::before();

        // Internal request only!
        if (Request::current()->is_initial())
        {
            $this->request->action(404);
        }

        $this->response->status((int) $this->request->action());
    }

    /**
     * 404 - Not found
     */
    public function action_404()
    {
        $this->_error(404);
    }

    /**
     * 403 - Access forbidden
     */
    public function action_403()
    {
        $this->_error(403);
    }

    /**
     * 503 - Maintenance mode
     */
    public function action_503()
    {
        $this->_error(503);
    }

    /**
     * 500 - Internal server error
     */
    public function action_500()
    {
        $this->_error(500);
    }

    /**
     * Helper for response creation
     *
     * @param $error_code
     */
    protected function _error($error_code)
    {
        // Set status
        $this->response->status($error_code);

        if (Request::initial()->is_ajax())
        {
            $this->response->body($this->default[$error_code]['message']);
        }
        else
        {
            // Render error page
            $body = View::factory('errors/'.$error_code)
                ->set('title', $this->default[$error_code]['title'])
                ->set('message', $this->default[$error_code]['message'])
                ->render();

            $this->response->body($body);
        }
    }
}

// END Controller_Error_Handler