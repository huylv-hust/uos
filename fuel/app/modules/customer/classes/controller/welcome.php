<?php
namespace Customer;

use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Log;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;
use Model_Salecustomer;

class Controller_Welcome extends Controller_Template
{
    public $template = 'customer';

    public function before()
    {
        parent::before();
        $this->template->title = '初回ログイン | しごさが';
    }

    public function action_index()
    {
        Session::delete('login_info');

        $saved = \Model_Cache::getJson(Input::get('key'));

        $data = [];
        do {
            if (is_array($saved) == false) {
                $data['error'] = 'ご指定のURLは処理済みか有効期限切れです';
                break;
            }

            $customer = Model_Salecustomer::find_by_pk($saved['id']);
            if ($customer == null || $customer->status > 1) {
                Response::redirect(Uri::base() . 'customer/');
            }

            try {
                $customer->is_new(false);
                $customer->status = 1;
                $customer->updated_at = date('Y-m-d H:i:s');
                $customer->save();
                \Model_Cache::find_by_pk(Input::get('key'))->delete();
                Response::redirect(Uri::base() . 'customer/?email=' . urldecode($customer->email));
            } catch (\Exception $ex) {
                Log::error($ex->getMessage());
                $data['error'] = 'エラーが発生しました';
                break;
            }
        } while (false);

        $this->template->content = View::forge('error', $data);
    }

}
