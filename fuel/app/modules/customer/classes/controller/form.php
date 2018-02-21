<?php
/**
 * Created by PhpStorm.
 * User: Huy
 * Date: 5/16/2017
 * Time: 9:00 PM
 */
namespace Customer;

use Fuel\Core\Input;
use Fuel\Core\Response;
use Fuel\Core\Session;
use Fuel\Core\Uri;
use Fuel\Core\View;

class Controller_Form extends \Controller_Uos
{
    private $session;

    /**
     * action create session file
     * Controller_Form constructor.
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
     * action create person (input form)
     */
    public function action_index()
    {
        if (!$job_id = Input::post('job_id')) {
            Response::redirect(Uri::base());
        }

        // Set $_POST['job_id']
        $job_id = trim($job_id, 'c');
        $_POST['job_id'] = $job_id;
        
        // Get Company_name and Trouble

        $job = new \Model_Salejob();
        $data = $job->get_data(['job_id' => $job_id]);
        if (!count($data)) {
            Response::redirect(Uri::base());
        }

        $data = current($data);
        $data['trouble'] = $this->convert_trouble($data['trouble']);

        // Delete session when back from 'confirm' or create
        $this->session->delete('form');

        // Process input
        if (Input::method() == 'POST' && Input::post('index')) {
            $url = Uri::base() . 'customer/form/confirm';
            $person = new \Model_Saleperson();

            // Convert katakana to hiragana
            $_POST['person_kana'] = mb_convert_kana($_POST['person_kana'], 'HVc', 'UTF-8');

            // Validation data
            $validate = $person->validation_form();
            if ($validate === true) {
                $person->set_data(Input::post());
                $person->fields['company_name'] = $data['company_name'];
                $person->fields['job_name'] = $data['job_name'];
                $this->session->set('form', $person->fields);
                Response::redirect($url);
            }
        }
        $this->template->content = View::forge('form/index', compact('validate', 'data'));
    }

    /**
     * action confirm with information
     */
    public function action_confirm()
    {
        // Check isset session
        if (!($data = $this->session->get('form'))) {
            Response::redirect(Uri::base() . 'customer/form');
        }

        // Process input
        if (Input::method() == 'POST') {
            $obj = new \Model_Saleperson();
            $data = $this->session->get('form');

            if (!$obj->save_data_send_email($data)) {
                Session::set_flash('error', '失敗しました');
                Response::redirect(Uri::base() . 'customer/form');
            }

            Response::redirect(Uri::base() . 'customer/form/complete');
        }

        $this->template->content = View::forge('form/confirm', compact('data'));
    }

    /**
     * action complete
     */
    public function action_complete()
    {
        if (!$this->session->get('form')) {
            Response::redirect(Uri::base() . 'customer/form');
        }
        $this->session->delete('form');
        $this->template->content = View::forge('form/complete');
    }

    /**
     * action convert trouble in DB to String
     * @param $data
     * @return string
     */
    public function convert_trouble($data)
    {
        $trouble = '';
        foreach (\Trouble::$trouble as $k => $v) {
            if (substr_count($data, ',' . $v['id'] . ',') && $v['pubname']) {
                $trouble .= $v['pubname'] . ',';
            }
        }
        $trouble = trim($trouble, ',');

        return str_replace(',', '、', $trouble);
    }
}
