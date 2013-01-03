<?php defined('SYSPATH') or die('No direct script access.');
/*
 * @package		App-skeleton
 * @author      Pap Tamas
 * @copyright   (c) 2011-2012 Pap Tamas
 * @website		https://bitbucket.org/paptamas/app-skeleton
 *
 */
class Kohana_Exception extends Kohana_Kohana_Exception {

    /**
     * @var array Default error titles and messages
     */
    public static $default = array(
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
            'message' => 'We are maintaining our servers. We will back very soon.'
        ),

        500 => array(
            'title' => 'Internal server error',
            'message' => 'Something went wrong. Please try again later.'
        )
    );

    public static function response(Exception $e)
    {
        if (Kohana::$environment === Kohana::DEVELOPMENT)
        {
            return parent::response($e);
        }
        else
        {
            try
            {
                $code = ($e instanceof HTTP_Exception) ? $e->getCode() : 500;

                // Prepare the response object.
                $response = Response::factory();

                // Set the response status
                $response->status($code);

                // Set the response headers
                $response->headers('Content-Type', Kohana_Exception::$error_view_content_type.'; charset='.Kohana::$charset);

                // Set the response body
                if (Request::initial()->is_ajax())
                {
                    $response->body(Kohana_Exception::$default[$code]['message']);
                }
                else
                {
                    // Render error page
                    $view = View::factory('errors/'.$code)
                        ->set('title', Kohana_Exception::$default[$code]['title'])
                        ->set('message', Kohana_Exception::$default[$code]['message']);

                    $response->body($view->render());
                }
            }
            catch (Exception $e)
            {
                /**
                 * Things are going badly for us, Lets try to keep things under control by
                 * generating a simpler response object.
                 */
                $response = Response::factory();
                $response->status(500);
                $response->headers('Content-Type', 'text/plain');
                $response->body(Kohana_Exception::text($e));
            }

            return $response;
        }
    }
}

// END Kohana_Exception