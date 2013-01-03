<?php defined('SYSPATH') or die('No direct script access.');
/*
 * @package		App-skeleton
 * @author      Pap Tamas
 * @copyright   (c) 2011-2012 Pap Tamas
 * @website		https://github.com/paptamas/app-skeleton
 *
 */
class Controller_OAuth extends Controller_Template_Main {

    /**
     * @var  View  page template
     */
    public $template = 'templates/auth';

    /**
     * @var bool Check if user is authenticated
     */
    public $check_authenticated = false;

    /**
     * Facebook
     */
    public function action_facebook()
    {
        $this->_process_oauth('facebook');
    }

    /**
     * Google
     */
    public function action_google()
    {
        $this->_process_oauth('google');
    }

    /**
     * Process oauth
     *
     * @param $provider
     */
    protected function _process_oauth($provider)
    {
        // If user is already logged in, redirect
        if (User::instance()->logged_in())
        {
            $this->request->redirect(URL::map('auth.after_login'));
        }

        // User is not logged in, check for facebook/google id
        $oauth_instance = ($provider == 'facebook') ? Facebook_OAuth::instance() : Google_OAuth::instance();
        if ($oauth_instance->has_access_token())
        {
            // Try to get user info
            $data = array();
            try
            {
                $data = $oauth_instance->user_info();
            }
            catch (Exception $e)
            {
                // Something went wrong, maybe the access token expired
                $this->request->redirect($oauth_instance->login_url());
            }

            $oauth = OAuth_Manager::instance();
            try
            {
                // Try to get oauth identity
                $oauth_identity = $oauth->load_oauth_identity($data['id'], $provider);

                // OAuth account registered, log in
                $this->_login($oauth_identity->user_id, $provider);
            }
            catch (OAuth_Exception $e)
            {
                // OAuth account is not registered yet
                // Check if the user is registered
                $auth_identity = ORM::factory('Identity')
                    ->where('email', '=', $data['email'])
                    ->find();

                if ($auth_identity->loaded())
                {
                    // User already exists, link oauth account to user account
                    $user_id = $auth_identity->user_id;
                    $oauth->create_oauth_identity($user_id, $data['id'], $provider);
                    $this->_login($user_id, $provider);
                }
                else
                {
                    // User with the given email doesn't exists
                    // Prepare data
                    if ($provider == 'facebook')
                    {
                        $data['name'] = $data['first_name'].' '.$data['last_name'];
                    }
                    elseif ($provider == 'google')
                    {
                        $data['username'] = substr($data['email'], 0, strpos($data['email'], '@'));
                    }

                    $data['oauth_provider'] = $provider;
                    $data['oauth_secret'] = Encrypt::instance()->encode(json_encode(array(
                        Text::random('alnum', 4),
                        $data['id'],
                        Text::random('alnum', 4),
                        $provider
                    )));

                    // Display the signup form
                    $this->template
                        ->set('title', __('Sign up'))
                        ->set('content', View::factory('Oauth/Signup')->set('data', $data));
                }
            }
        }
        else
        {
            // Get access permission from the user
            $this->request->redirect($oauth_instance->login_url());
        }
    }

    /**
     * Login a user
     *
     * @param $user_id
     * @param $provider
     */
    protected function _login($user_id, $provider)
    {
        $identity = Identity::factory();

        if ($identity->authenticate_with_id($user_id))
        {
            $user = User::instance();
            $user->login($identity, TRUE);
            $user->authenticated_with($provider);

            $this->request->redirect(URL::map('auth.after_login'));
        }
    }
}