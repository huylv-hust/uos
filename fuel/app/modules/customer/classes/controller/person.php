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

class Controller_Person extends \Controller_CustomerBase
{
    private $session_name;
    private $person_id;
    public $sale_person;
    private $session;
    private $url_redirect;

    public function __construct()
    {
        parent::__construct();
        $this->sale_person = new \Model_Saleperson();
        $this->session = Session::forge(array('driver' => 'file', 'file' => array(
            'cookie_name' => 'fuelfid',
            'path' => APPPATH . 'tmp',
            'gc_probability' => 5
        )));
        $this->session_name = 'form_person';
        $this->person_id = Input::get('person_id',0);
        $this->url_redirect = Uri::base() . 'customer/persons';
    }

    /**
     * Check login customer
     * @return array|void
     */
    private function check_login()
    {
        $person_id = $this->person_id;
        $login_info = Session::get('login_info');
        //Get info person
        $data = $this->sale_person->get_info_data($person_id);
        if(!$login_info || !$person_id) {
            return Response::redirect($this->url_redirect);
        }

        // Update is_read = 1
        if ($data['is_read'] == \Constants::$is_read['unread'] &&
            !$this->sale_person->update_isread($person_id, \Constants::$is_read['read'])) {
            Session::set_flash('error', 'エーラーに発生しました');
            return Response::redirect($this->url_redirect);
        }

        $sale_job = \Model_Salejob::find_one_by_job_id($data['job_id']);
        $sale_shop= \Model_Saleshop::find_by_pk($sale_job->shop_id);
        if($login_info['customer_id'] != $sale_shop->customer_id) {
            return Response::redirect($this->url_redirect);
        }

        $data['job_id'] = $sale_job->job_id;
        $data['job_name'] = $sale_job->job_name;
        $data['shop_name'] = $sale_shop->shop_name;
        $data['birthday_y'] = date('Y',strtotime($data['birthday']));
        $data['birthday_d'] = date('d',strtotime($data['birthday']));
        $data['birthday_m'] = date('m',strtotime($data['birthday']));
        if($data['application_time'])
            $data['application_time_d'] = date('Y-m-d',strtotime($data['application_time']));
        else
            $data['application_time_d'] = '';

        $data['application_time_h'] = date('H',strtotime($data['application_time']));
        $data['application_time_m'] = date('i',strtotime($data['application_time']));
        $tels = explode('-', $data['tel']);
        $data['tel1'] = @$tels[0];
        $data['tel2'] = @$tels[1];
        $data['tel3'] = @$tels[2];
        $mobiles = explode('-', $data['mobile']);
        $data['mobile1'] = @$mobiles[0];
        $data['mobile2'] = @$mobiles[1];
        $data['mobile3'] = @$mobiles[2];
        $data['zipcode1'] = substr($data['zipcode'],0,3);
        $data['zipcode2'] = substr($data['zipcode'],3,4);
        return $data;
    }

    /**
     * Set session data
     */
    public function action_index()
    {
        $data = $this->check_login();
        $errors = array();
        if (Input::method() == 'POST') {
            $_POST['person_kana'] = mb_convert_kana($_POST['person_kana'], 'HVc', 'UTF-8');
            $_POST['zipcode1'] = mb_convert_kana($_POST['zipcode1'], 'n', 'UTF-8');
            $_POST['zipcode2'] = mb_convert_kana($_POST['zipcode2'], 'n', 'UTF-8');
            $_POST['tel1'] = mb_convert_kana($_POST['tel1'], 'n', 'UTF-8');
            $_POST['tel2'] = mb_convert_kana($_POST['tel2'], 'n', 'UTF-8');
            $_POST['tel3'] = mb_convert_kana($_POST['tel3'], 'n', 'UTF-8');
            $_POST['mobile1'] = mb_convert_kana($_POST['mobile1'], 'n', 'UTF-8');
            $_POST['mobile2'] = mb_convert_kana($_POST['mobile2'], 'n', 'UTF-8');
            $_POST['mobile3'] = mb_convert_kana($_POST['mobile3'], 'n', 'UTF-8');
            $check_validate = $this->sale_person->validate();
            if ($check_validate) {
                $this->session->delete($this->session_name);
                $_POST['person_name'] = mb_convert_kana(Input::post('person_name'), 'HVc', 'UTF-8');
                $this->session->set($this->session_name, Input::post());
                return Response::redirect(Uri::base() . 'customer/personconfirm?person_id='.$this->person_id);
            }

            $errors = $this->sale_person->get_errors();
        }

        /*Process button back*/
        if (\Fuel\Core\Input::get('back') && $this->session->get($this->session_name)) {
            $data = $this->session->get($this->session_name);
            $data['gender'] = isset($data['gender']) ?  $data['gender'] : null;
            /* Delete session */
            $this->session->delete($this->session_name);
        }

        $this->template->title = '店舗 | しごさが';
        $this->template->content = View::forge('person/index', array('row' => $data, 'errors' => $errors));
    }

    /**
     * Confirm data
     */
    public function action_confirm()
    {
        $this->check_login();
        $data = $this->session->get($this->session_name);
        if (!$data) {
            return Response::redirect($this->url_redirect);
        }

        $data['json_data'] = json_encode($data);

        $this->template->title = '店舗 | しごさが';
        $this->template->content = View::forge('person/confirm', $data);
    }

    /**
     * Complete form
     */
    public function action_complete()
    {
        $this->check_login();
        $data = array();
        if (!$this->session->get($this->session_name)) {
            return Response::redirect($this->url_redirect);
        }

        $data_post = $this->session->get($this->session_name);
        $data_post['tel'] = $data_post['tel1'] . '-'  .$data_post['tel2'] . '-' . $data_post['tel3'];
        $data_post['tel'] = trim($data_post['tel'],'--');
        $data_post['mobile'] = $data_post['mobile1'] . '-' . $data_post['mobile2'] . '-' . $data_post['mobile3'];
        $data_post['mobile'] = trim($data_post['mobile'],'--');
        $data_post['birthday'] = $data_post['birthday_y'].'-'.$data_post['birthday_m'].'-'.$data_post['birthday_d'];
        $data_post['application_time'] = $data_post['application_time_d'].' '.$data_post['application_time_h'].':'.$data_post['application_time_m'].':00';
        $data_post['zipcode'] = $data_post['zipcode1'].$data_post['zipcode2'];
        $data_post['prefecture_id'] = (int)$data_post['prefecture_id'];
        if (!$this->sale_person->save_data($data_post, $data_post['person_id'])) {
            $data['report'] = 'Error';
        } else {
            // Send report
            $data['report'] = ' 保存が完了しました';
        }

        $this->session->delete($this->session_name);

        $this->template->title = '店舗 | しごさが';
        $this->template->content = View::forge('person/complete', $data);
    }

}
