<?php
/**
 * Author NamDD6566
 */
namespace Customer;

use Fuel\Core\Controller_Template;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

class Controller_Shop extends \Controller_CustomerBase
{

    public $sale_shop;
    public $sale_customer;
    private $session_name;
    private $shop_id;
    private $session;

    public function __construct()
    {
        parent::__construct();
        $this->session = Session::forge(array('driver' => 'file', 'file' => array(
            'cookie_name' => 'fuelfid',
            'path' => APPPATH . 'tmp',
            'gc_probability' => 5
        )));
        $this->sale_shop = new \Model_Saleshop();

        $this->shop_id = Input::get('shop_id', 0);
        $this->session_name = 'form_shop';
    }

    /**
     * Check login customer
     * @return array|void
     */
    private function check_login()
    {
        $shop_id = $this->shop_id;
        $login_info = Session::get('login_info');
        if (!$login_info) {
            return Response::redirect(Uri::base() . 'customer');
        }

        $data = $this->sale_shop->get_info_data($shop_id);
        if ($this->shop_id && ($data['customer_id'] != $login_info['customer_id'] || !$data['shop_id'])) {
            return Response::redirect(Uri::base() . 'customer/shops');
        }

        // Create new shop
        $data['customer_id'] = $login_info['customer_id'];
        if ($data['stations']) {
            $data['stations'] = json_decode($data['stations'], true);
        } else {
            $data['stations'] = array_pad(array(), 3, array('company' => null, 'line' => null, 'time' => null));
        }

        return $data;
    }

    /**
     * Set session data
     */
    public function action_index()
    {
        $data = $this->check_login();
        /* Post data*/
        $errors = array();
        if (Input::method() == 'POST') {
            if (is_array(Input::post('station_time'))) {
                foreach (Input::post('station_time') as $key => $val) {
                    $_POST['station_time'][$key] = mb_convert_kana($val, 'n', 'UTF-8');
                }
            }
            $_POST['shop_kana'] = mb_convert_kana($_POST['shop_kana'], 'HVc', 'UTF-8');
            $errors = $this->sale_shop->validate();
            if (!count($errors)) {
                $this->session->delete($this->session_name);
                $this->session->set($this->session_name, Input::post());
                return Response::redirect(Uri::base() . 'customer/shopconfirm');
            }
        }

        /*Process button back*/
        if (\Fuel\Core\Input::get('back') && $this->session->get($this->session_name)) {
            $data = $this->session->get($this->session_name);
            $arr_station = array();
            for ($i = 0; $i < 3; ++$i) {
                $arr_station[] = array(
                    'company' => htmlspecialchars($data['station_company'][$i]),
                    'line' => htmlspecialchars($data['station_line'][$i]),
                    'name' => htmlspecialchars($data['station_name'][$i]),
                    'time' => htmlspecialchars($data['station_time'][$i]),
                );
            }
            $data['stations'] = $arr_station;
            /* Delete session */
            $this->session->delete($this->session_name);
        }

        $this->template->title = '店舗 | しごさが';
        $this->template->content = View::forge('shop/index', array('row' => $data, 'errors' => $errors));
    }

    /**
     * Confirm data
     */
    public function action_confirm()
    {
        $this->check_login();
        $data = $this->session->get($this->session_name);
        if (!$data) {
            return Response::redirect(Uri::base() . 'customer/shop/');
        }

        $data['json_data'] = json_encode($data);
        $this->template->title = '店舗 | しごさが';
        $this->template->content = View::forge('shop/confirm', $data);
    }

    /**
     * Complete form
     */
    public function action_complete()
    {
        $this->check_login();
        if (!$this->session->get($this->session_name)) {
            return Response::redirect(Uri::base() . 'customer/shop/');
        }

        $data_post = $this->session->get($this->session_name);
        $arr_station = array();
        for ($i = 0; $i < 3; ++$i) {
            $arr_station[] = array(
                'company' => $data_post['station_company'][$i],
                'line' => $data_post['station_line'][$i],
                'name' => $data_post['station_name'][$i],
                'time' => $data_post['station_time'][$i],
            );
        }

        unset($data_post['station_company']);
        unset($data_post['station_line']);
        unset($data_post['station_time']);
        unset($data_post['station_name']);
        $data_post['stations'] = json_encode($arr_station, 2);
        unset($data_post['company_name']);
        if (!$this->sale_shop->save_data($data_post, $data_post['shop_id'])) {
            $data['report'] = 'Error';
        } else {
            // Send report
            $data['report'] = '保存が完了しました';
        }

        $data['shop_id'] = $this->sale_shop->lastInsertId();

        $this->session->delete($this->session_name);
        $this->template->title = '店舗 | しごさが';
        $this->template->content = View::forge('shop/complete', $data);
    }

}
