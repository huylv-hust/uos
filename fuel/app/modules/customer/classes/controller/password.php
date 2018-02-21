<?php
namespace Customer;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * author HuyLV6635
 * Class Controller_Password
 * @package Customer
 */
class Controller_Password extends \Controller_Template
{
    public $template = 'customer';

    public function before()
    {
        parent::before();

        $login_info = Session::get('login_info');

        if ($login_info == null || !@$login_info['customer_id'] || $login_info['expired'] < time()) {
            Session::delete('login_info');
            Response::redirect(\Fuel\Core\Uri::base() . 'customer/');
        }
    }

    /**
     * action index
     * update Password
     */
    public function action_index()
    {
        if (Input::method() == 'POST') {
            $obj = new \Model_Salecustomer();
            //validate
            $validate = $obj->validation_changepassword();
            if ($validate === true) {
                if (!Input::post('confirm')) {
                    Session::set('password', Input::post());
                    Response::redirect(Uri::base() . 'customer/password/complete');
                }
            }
        }
        $this->template->title = 'アカウント情報 | しごさが';
        $this->template->content = View::forge('password/index', compact('validate'));
    }

    /**
     * action complete
     * confirm update Password
     */
    public function action_complete()
    {
        $login_info = Session::get('login_info');
        if (!($data = Session::get('password'))) {
            Response::redirect(Uri::base() . 'customer/password');
        }

        $obj = \Model_Salecustomer::find_by_pk($login_info['customer_id']);
        $data['status'] = 2;
        $obj->set_data($data);
        if (!$obj->update_data()) {
            Session::set_flash('error', 'エラーに発生しました');
            Response::redirect(Uri::base() . 'customer/password');
        }

        $login_info['status'] = 2;
        Session::set('login_info', $login_info);

        Session::delete('password');
        $this->template->title = 'アカウント情報 | しごさが';
        $this->template->content = View::forge('password/complete');
    }
}
