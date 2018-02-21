<?php
namespace Customer;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * author thuanth6589
 * Class Controller_Account
 * @package Customer
 */
class Controller_Account extends \Controller_CustomerBase
{
    /**
     * action index
     * update sale customer
     */
    public function action_index()
    {
        $login_info = Session::get('login_info');
        $sale_customer = \Model_Salecustomer::find_by_pk($login_info['customer_id']);
        if (Input::method() == 'POST') {
            $obj = new \Model_Salecustomer();
            //convert data
            $_POST['company_kana'] = mb_convert_kana($_POST['company_kana'], 'HVc', 'UTF-8');
            $_POST['president_kana'] = mb_convert_kana($_POST['president_kana'], 'HVc', 'UTF-8');
            $_POST['staff_kana'] = mb_convert_kana($_POST['staff_kana'], 'HVc', 'UTF-8');
            $_POST['zipcode1'] = mb_convert_kana($_POST['zipcode1'], 'n', 'UTF-8');
            $_POST['zipcode2'] = mb_convert_kana($_POST['zipcode2'], 'n', 'UTF-8');
            $_POST['tel1'] = mb_convert_kana($_POST['tel1'], 'n', 'UTF-8');
            $_POST['tel2'] = mb_convert_kana($_POST['tel2'], 'n', 'UTF-8');
            $_POST['tel3'] = mb_convert_kana($_POST['tel3'], 'n', 'UTF-8');
            $_POST['fax1'] = mb_convert_kana($_POST['fax1'], 'n', 'UTF-8');
            $_POST['fax2'] = mb_convert_kana($_POST['fax2'], 'n', 'UTF-8');
            $_POST['fax3'] = mb_convert_kana($_POST['fax3'], 'n', 'UTF-8');
            //validate
            $validate = $obj->validation_account();
            if ($validate === true) {
                if (!Input::post('hidden')) {
                    Session::set('customer_account', Input::post());
                    return Response::redirect(Uri::base() . 'customer/account/confirm');
                }
            }
        }
        $this->template->title = 'アカウント情報 | しごさが';
        $this->template->content = View::forge('account/index', compact('sale_customer', 'validate'));
    }

    /**
     * action confirm
     * confirm update sale customer
     */
    public function action_confirm()
    {
        $login_info = Session::get('login_info');
        if (!($data = Session::get('customer_account'))) {
            Response::redirect(Uri::base() . 'customer/account');
        }

        if (Input::method() == 'POST') {
            $obj = \Model_Salecustomer::find_by_pk($login_info['customer_id']);
            $obj->set_data($data);
            if ($obj->update_data()) {
                return Response::redirect(Uri::base() . 'customer/account/complete');
            }
        }

        $this->template->title = 'アカウント情報 | しごさが';
        $this->template->content = View::forge('account/confirm', compact('data'));
    }

    /**
     * complete update sale customer
     */
    public function action_complete()
    {
        if (!($data = Session::get('customer_account'))) {
            Response::redirect(Uri::base() . 'customer/account');
        }

        Session::delete('customer_account');
        $this->template->title = 'アカウント情報 | しごさが';
        $this->template->content = View::forge('account/complete', compact('data'));
    }
}
