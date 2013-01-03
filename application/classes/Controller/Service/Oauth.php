<?php defined('SYSPATH') or die('No direct script access.');
/*
 * @package		App-skeleton
 * @author      Pap Tamas
 * @copyright   (c) 2011-2012 Pap Tamas
 * @website		https://github.com/paptamas/app-skeleton
 *
 */
class Controller_Service_OAuth extends Controller_Service {

    /**
     * @var bool Check if user is authenticated
     */
    public $check_authenticated = false;

    /**
     * Signup a new user
     *
     * @throws Kohana_Exception
     */
    public function action_signup()
    {
        // Get post data
        $post = $this->request->post('signup');

        // Validate oauth secret
        $oauth_secret = Arr::get($post, 'oauth_secret');
        $oauth_array = $this->_decode_secret($oauth_secret);
        $oauth_id = $oauth_array[1];
        $oauth_provider = $oauth_array[3];

        $values = array(
            'full_name' => Arr::get($post, 'full_name'),
            'username' => Arr::get($post, 'username'),
            'email' => Arr::get($post, 'email'),
            'password' => Arr::get($post, 'password'),
            'password_confirm' => Arr::get($post, 'password'),
        );

        $auth = Auth_Manager::instance();
        $oauth = OAuth_Manager::instance();

        try
        {
            $user = $auth->signup($values);

            // Registration was successful, link the oauth account to user
            $oauth->create_oauth_identity($user->pk(), $oauth_id, $oauth_provider);

            // Log in the user
            $identity = Identity::factory();
            if ($identity->authenticate_with_id($user->pk()))
            {
                User::instance()->login($identity);

                // Login was successful
                $this->response->body(json_encode(array(
                    'next' => URL::map('auth.after_signup')
                )));
            }
        }
        catch (Auth_Validation_Exception $e)
        {
            // Invalid data
            $this->response->status(409);

            $this->response->body(json_encode(array(
                'code' => 1,
                'errors' => array(
                    'signup' => $e->getErrors()
                )
            )));
        }
        catch (Kohana_Exception $e)
        {
            // Some database error
            $this->response->status(409);

            $this->response->body(json_encode(array(
                'code' => 2,
                'message' => $e->getMessage()
            )));
        }
    }

    /**
     * Decode oauth secret
     *
     * @param $oauth_secret
     * @return mixed
     * @throws HTTP_Exception_403
     */
    protected function _decode_secret($oauth_secret)
    {
        if (empty($oauth_secret))
        {
            throw HTTP_Exception::factory(403);
        }
        else
        {
            $oauth_array = json_decode(Encrypt::instance()->decode($oauth_secret));
            if (( ! is_array($oauth_array)) || (sizeof($oauth_array) != 4))
            {
                throw HTTP_Exception::factory(403);
            }

            return $oauth_array;
        }
    }
}