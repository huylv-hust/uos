<?php

namespace Customer;

use Fuel\Core\Config;
use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

/**
 * author ThuanTH6589
 * Class Controller_Job
 * @package Customer
 */
class Controller_Job extends \Controller_CustomerBase
{
    private $session;

    /**
     * load driver session file
     * Controller_Job constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->session = Session::forge(array('driver' => 'file', 'file' => array(
            'cookie_name' => 'fuelfid',
            'path' => APPPATH . 'tmp',
            'gc_probability' => 5
        )));
    }

    /**
     * compare old data and edit data
     * @param $old_data
     * @param $edit_data
     * @return array
     */
    private function compare_data($old_data, $edit_data)
    {
        if ($edit_data == '') {
            return [];
        }
        $data = json_decode($edit_data, true);
        $hide = array();
        foreach ($data as $k => $v) {
            if ($k == 'image_list') {
                $image_list_json = $data['image_list'] ? json_decode($data['image_list'], true) : [];
                $image_list_old = $old_data['image_list'] ? json_decode($old_data['image_list'], true) : [];
                if (count(array_diff($image_list_json, $image_list_old)) || count(array_diff($image_list_old, $image_list_json))) {
                    $hide['title'] = '';
                    $hide[$k] = '';
                }
            } else {
                try {
                    if ((isset($old_data->$k) || $old_data->$k === null) && $v != $old_data->$k) {
                        $hide['title'] = '';
                        $hide[$k] = '';
                    }
                } catch (\OutOfBoundsException $ex) {
                    // throw
                }
            }
        }
        return $hide;
    }

    /**
     * create/update sale job
     */
    public function action_index()
    {
        $login_info = Session::get('login_info');
        $job_id = Input::get('job_id');
        $sale_job = new \Model_Salejob();
        $m_image_obj = new \Model_Mimage();
        $m_image_old = [];
        $m_image_edit = [];
        //get shop id from persons
        $shop_id = Input::get('shop_id');
        if ($shop_id && $sale_shop = \Model_Saleshop::find_by_pk($shop_id)) {
            if ($login_info['customer_id'] != $sale_shop->customer_id) {
                return Response::redirect(Uri::base() . 'customer/jobs');
            }
            $shop_name = $sale_shop->shop_name;
            $_POST['access'] = $sale_shop->access;
        }

        $customer = \Model_Salecustomer::find_by_pk($login_info['customer_id']);
        $price = $customer->employment_price;

        if ($job_id) {
            if (!$sale_job = \Model_Salejob::find_by_pk($job_id)) {
                return Response::redirect(Uri::base() . 'customer/jobs');
            }
            $sale_shop = \Model_Saleshop::find_by_pk($sale_job->shop_id);
            if ($login_info['customer_id'] != $sale_shop->customer_id) {
                return Response::redirect(Uri::base() . 'customer/jobs');
            }
            //get shop name, company name old
            $sale_shop_old = \Model_Saleshop::find_by_pk($sale_job->shop_id);
            $price = $sale_shop_old->employment_price;
            $shop_name_old = $sale_shop_old->shop_name;

            $json = $sale_job;
            $shop_name_json = $shop_name_old;
            //get image
            $m_image_edit = $m_image_obj->get_list_m_image($sale_job->image_list);
            $m_image_old = $m_image_edit;

            if ($sale_job->edit_data) {
                $json = json_decode($sale_job->edit_data);
                if ($json->shop_id != $sale_job->shop_id) {
                    $sale_shop_json = \Model_Saleshop::find_by_pk($json->shop_id);
                    $shop_name_json = $sale_shop_json->shop_name;
                    $price = $sale_shop_json->employment_price;
                }
                //get image
                $m_image_edit = $m_image_obj->get_list_m_image($json->image_list);
            }

            $is_view = $this->compare_data($sale_job, $sale_job->edit_data);
        }

        if (Input::method() == 'POST') {
            $_POST['salary_min'] = mb_convert_kana($_POST['salary_min'], 'n', 'UTF-8');
            $_POST['work_day_week'] = mb_convert_kana($_POST['work_day_week'], 'n', 'UTF-8');
            $_POST['employment_people_num'] = mb_convert_kana($_POST['employment_people_num'], 'n', 'UTF-8');
            $validate = $sale_job->validate();
            if ($validate === true) {
                if (!\Model_Saleshop::find_by_pk(Input::post('shop_id'))) {
                    Session::set_flash('error', '店舗が存在しません');
                } else {
                    if (!Input::post('hidden')) {
                        $data = $sale_job->set_data(Input::post());
                        $data['shop_name'] = Input::post('shop_name');
                        $data['price'] = Input::post('price');
                        if ($job_id) {
                            $data['job_id'] = $job_id;
                        }

                        $this->session->set('customer_job', $data);
                        Response::redirect(Uri::base() . 'customer/job/confirm');
                    }
                }
            }
            if (Input::post('price') !== null) {
                $price = Input::post('price');
            }
        }
        $this->template->title = '求人 | しごさが';
        $this->template->content = View::forge(
            'job/index',
            compact('sale_job', 'login_info', 'sale_customer', 'm_image_old', 'm_image_edit', 'shop_name_old', 'shop_name_json', 'is_view', 'json', 'validate', 'shop_id', 'shop_name', 'price')
        );
    }

    /**
     * confirm sale job information
     */
    public function action_confirm()
    {
        if (!$data = $this->session->get('customer_job')) {
            return Response::redirect(Uri::base() . 'customer/job');
        }
        if (!\Model_Saleshop::find_by_pk($data['shop_id'])) {
            Session::set_flash('error', '店舗が存在しません');
            return Response::redirect(Uri::base() . 'customer/job');
        }
        if (Input::method() == 'POST') {
            $sale_job = new \Model_Salejob();
            if (isset($data['job_id'])) {
                $sale_job = \Model_Salejob::find_by_pk($data['job_id']);
            }
            unset($data['shop_name']);
            if ($sale_job->save_data($data)) {
                return Response::redirect(Uri::base() . 'customer/job/complete?job_id=' . $sale_job->job_id);
            }
        }

        $this->template->title = '求人 | しごさが';
        $this->template->content = View::forge('job/confirm', compact('data'));
    }

    /**
     * complete save sale job
     */
    public function action_complete()
    {
        if (!$this->session->get('customer_job')) {
            return Response::redirect(Uri::base() . 'customer/job');
        }
        $this->session->delete('customer_job');
        $this->template->title = '求人 | しごさが';
        $this->template->content = View::forge('job/complete');
    }

    public function post_apply()
    {
        $job_id = Input::post('job_id');
        $sale_job = \Model_Salejob::find_by_pk($job_id);
        if (!$sale_job) {
            return Response::redirect(Uri::base() . 'customer/jobs');
        }

        $sale_shop = \Model_Saleshop::find_by_pk($sale_job->shop_id);
        $login_info = Session::get('login_info');
        if ($login_info['customer_id'] != $sale_shop->customer_id) {
            return Response::redirect(Uri::base() . 'customer/jobs');
        }

        $sale_job->is_new(false);
        $sale_job->status = 1;
        $sale_job->updated_at = date('Y-m-d H:i:s');
        $sale_job->save();

        $customer = \Model_Salecustomer::find_by_pk($sale_shop->customer_id);
        \Utility::sendmail(
            Config::get('mail_admin'),
            '【しごさが】求人掲載申請がありました',
            [
                'company_name' => $customer->company_name,
                'shop_name' => $sale_shop->shop_name,
                'url' => Config::get('bo_url') . 'sales/jobs'
            ],
            'email/salejob_apply'
        );

        return Response::redirect(Uri::base() . 'customer/job/apply');
    }

    public function get_apply()
    {
        $this->template->title = '求人 | しごさが';
        $this->template->content = View::forge('job/apply');
    }
}
