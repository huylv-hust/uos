<?php
/**
 * Created by PhpStorm.
 * User: Huy
 * Date: 4/28/2017
 * Time: 9:00 PM
 */
namespace Customer;

use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Log;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;
use Model_Salecustomer;

class Controller_Emailupdate extends Controller_Template
{
    public $template = 'customer';

    public function before()
    {
        parent::before();
        $this->template->title = 'メールアドレス変更 | しごさが';
    }

    public function action_index()
    {
        $saved = \Model_Cache::getJson(Input::get('key'));

        $data = [];
        do {
            if (is_array($saved) == false) {
                $data['error'] = 'ご指定のURLは処理済みか有効期限切れです';
                break;
            }

            $customer = Model_Salecustomer::find_by_pk($saved['id']);

            if (($saved['time'] + 86400) < time()) {
                $data['error'] = 'ご指定のURLは有効期限切れです';
                break;
            }

            if ($customer->email == $saved['email']) {
                $data['error'] = 'ご指定のURLは処理済みです';
                break;
            }

            try {
                $customer->is_new(false);
                $customer->email = $saved['email'];
                $customer->updated_at = date('Y-m-d H:i:s');
                $customer->save();
                \Model_Cache::find_by_pk(Input::get('key'))->delete();
            } catch (\Exception $ex) {
                Log::error($ex->getMessage());
                $data['error'] = '登録済みメールアドレスのため処理できませんでした';
                break;
            }

            Session::delete('login_info');
            Session::delete('uri_before_login');

            Response::redirect(Uri::base() . 'customer/emailupdate/complete');

        } while (false);

        $this->template->content = View::forge('email/update', $data);
    }

    public function get_complete()
    {
        $data = ['error' => null];
        $this->template->content = View::forge('email/update', $data);
    }

}
