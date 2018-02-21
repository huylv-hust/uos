<?php
/**
 * Created by PhpStorm.
 * User: Huy
 * Date: 4/25/2017
 * Time: 3:07 PM
 */
use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Session;
use Fuel\Core\Response;
use Fuel\Core\Uri;

class Controller_CustomerBase extends Controller_Template
{
    public $template = 'customer';

    /**
     * Controller_CustomerBase constructor.
     */
    public function __construct()
    {
    }

    /**
     *action Check Login
     */
    public function before()
    {
        parent::before();

        $login_info = Session::get('login_info');

        if ($login_info == null || !@$login_info['customer_id'] || $login_info['expired'] < time()) {
            Session::delete('login_info');
            $uri = Uri::current();
            if (Input::server('QUERY_STRING')) {
                $uri .= '?' . Input::server('QUERY_STRING');
            }
            Session::set('uri_before_login', $uri);
            Response::redirect(\Fuel\Core\Uri::base() . 'customer/');
        } else {
            $login_info['expired'] = time() + 30 * 60;
            Session::set('login_info', $login_info);
            if ($login_info['status'] == 1) {
                Response::redirect(\Fuel\Core\Uri::base() . 'customer/password');
            }
        }
    }
}
