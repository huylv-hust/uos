<?php

/**
 * @author Huylv6635 <huylv6635@co-well.com.vn>
 * Class Salecustomer
 * @package Model
 */
class Model_Salecustomer extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'sale_customer';
    protected static $_primary_key = 'customer_id';
    protected static $_properties = array(
        'customer_id',
        'entry_time',
        'company_name',
        'company_kana',
        'email',
        'password',
        'zipcode',
        'prefecture_id',
        'city',
        'town',
        'tel',
        'fax',
        'president_name',
        'president_kana',
        'staff_name',
        'staff_kana',
        'note',
        'application_price',
        'employment_price',
        'department_id',
        'user_id',
        'status',
        'created_at',
        'updated_at',
    );
    protected static $_observers = array(
        'Orm\Observer_CreatedAt' => array(
            'events' => array('before_insert'),
            'mysql_timestamp' => true,
            'property' => 'created_at',
            'overwrite' => true,
        ),
        'Orm\Observer_UpdatedAt' => array(
            'events' => array('after_update'),
            'mysql_timestamp' => true,
            'property' => 'updated_at',
            'overwrite' => true,
        ),
    );
    public $fields = array();
    public $validate;

    /**
     * Model_Salecustomer constructor.
     */
    public function __construct()
    {
        \Fuel\Core\Config::set('language', 'jp');
        \Fuel\Core\Lang::load('label');
    }

    /**
     * action Check validation when login
     * @return array|bool|string
     */
    public function validation_login()
    {
        $this->validate = \Fuel\Core\Validation::forge('customer');
        $this->validate->add_field('email', \Fuel\Core\Lang::get('email'), 'required');
        $this->validate->add_field('password', \Fuel\Core\Lang::get('password'), 'required');
        return !$this->validate->run() ? $this->validate->error_message() : true;
    }

    /**
     * action Check validation when reminder password
     * @return array|bool|string
     */
    public function validation_reminder()
    {
        $this->validate = \Fuel\Core\Validation::forge('customer');
        $this->validate->add_field('email', \Fuel\Core\Lang::get('email'), 'required');
        return !$this->validate->run() ? $this->validate->error_message() : true;
    }

    public function validation_email()
    {
        $this->validate = \Fuel\Core\Validation::forge('customer');
        $this->validate->add_callable('myrules');
        $this->validate->add_field('email', \Fuel\Core\Lang::get('email'), 'required|valid_email|max_length[767]|unique[sale_customer.email]');
        $this->validate->add_field('email_check', \Fuel\Core\Lang::get('email_check'), 'match_field[email]');
        return !$this->validate->run() ? $this->validate->error_message() : true;
    }

    /**
     * action validate form input
     * @return array|bool|string
     */
    public function validation_entry()
    {
        $this->validate = \Fuel\Core\Validation::forge('customer');
        $this->validate->add_callable('myrules');
        $this->validate->add_field('email', \Fuel\Core\Lang::get('email'), 'required|valid_email|max_length[767]|unique[sale_customer.email]');
        $this->validate->add_field('company_name', \Fuel\Core\Lang::get('company_name'), 'required|max_length[50]');
        $this->validate->add_field('company_kana', \Fuel\Core\Lang::get('company_kana'), 'required|kana|max_length[50]');
        $this->validate->add_field('zipcode1', \Fuel\Core\Lang::get('zipcode1'), 'required|valid_string[numeric]|exact_length[3]');
        $this->validate->add_field('zipcode2', \Fuel\Core\Lang::get('zipcode2'), 'required|valid_string[numeric]|exact_length[4]');
        $this->validate->add_field('prefecture_id', \Fuel\Core\Lang::get('prefecture_id'), 'required');
        $this->validate->add_field('city', \Fuel\Core\Lang::get('city'), 'required|max_length[10]');
        $this->validate->add_field('town', \Fuel\Core\Lang::get('town'), 'required|max_length[50]');
        $this->validate->add_field('tel1', \Fuel\Core\Lang::get('tel1'), 'required|valid_string[numeric]|max_length[5]');
        $this->validate->add_field('tel2', \Fuel\Core\Lang::get('tel2'), 'required|valid_string[numeric]|max_length[4]');
        $this->validate->add_field('tel3', \Fuel\Core\Lang::get('tel3'), 'required|valid_string[numeric]|max_length[4]');
        $this->validate->add_field('fax1', \Fuel\Core\Lang::get('fax1'), 'valid_string[numeric]|max_length[5]')->add_rule('required_fax', [\Fuel\Core\Input::post('fax2'), \Fuel\Core\Input::post('fax3')]);
        $this->validate->add_field('fax2', \Fuel\Core\Lang::get('fax2'), 'valid_string[numeric]|max_length[4]')->add_rule('required_fax', [\Fuel\Core\Input::post('fax1'), \Fuel\Core\Input::post('fax2')]);
        $this->validate->add_field('fax3', \Fuel\Core\Lang::get('fax3'), 'valid_string[numeric]|max_length[4]')->add_rule('required_fax', [\Fuel\Core\Input::post('fax1'), \Fuel\Core\Input::post('fax2')]);
        $this->validate->add_field('president_name', \Fuel\Core\Lang::get('president_name'), 'required|max_length[50]');
        $this->validate->add_field('president_kana', \Fuel\Core\Lang::get('president_kana'), 'required|kana|max_length[50]');
        $this->validate->add_field('staff_name', \Fuel\Core\Lang::get('staff_name'), 'required|max_length[50]');
        $this->validate->add_field('staff_kana', \Fuel\Core\Lang::get('staff_kana'), 'required|kana|max_length[50]');
        $this->validate->add_field('password', \Fuel\Core\Lang::get('password'), 'required|check_password|min_length[8]|max_length[50]');
        $this->validate->add_field('password_check', \Fuel\Core\Lang::get('password_check'), 'match_field[password]');
        $this->validate->add_field('agree', \Fuel\Core\Lang::get('agree'), 'required');

        return !$this->validate->run() ? $this->validate->error_message() : true;
    }

    /**
     * Set data before save
     * @param array $data
     */
    public function set_data($data = array())
    {
        $fields = array();
        if (isset($data['zipcode1'])) {
            $data['zipcode'] = $data['zipcode1'] . $data['zipcode2'];
        }
        if (isset($data['tel1'])) {
            $data['tel'] = $data['tel1'] . '-' . $data['tel2'] . '-' . $data['tel3'];
        }
        if (isset($data['fax1'])) {
            $data['fax'] = $data['fax1'] !== '' ? $data['fax1'] . '-' . $data['fax2'] . '-' . $data['fax3'] : '';
        }
        if (isset($data['email'])) {
            $data['email'] = strtolower($data['email']);
        }

        foreach ($data as $k => $v) {
            if (in_array($k, self::$_properties)) {
                $fields[$k] = trim($v) != '' ? trim($v) : null;
            }
        }

        $this->fields = $fields;
    }

    /**
     * Save data
     * @return bool
     */
    public function save_data()
    {
        $data = $this->fields;

        try {
            $data['entry_time'] = date("Y-m-d H:i:s", time());
            $data['created_at'] = date('Y-m-d H:i:s', time());
            $data['updated_at'] = date('Y-m-d H:i:s', time());
            $data['password'] = hash('SHA256', $data['password']);
            $customer = Model_Salecustomer::forge();
            $customer->set($data);
            if ($customer->save()) {
                $this->fields['customer_id'] = $customer->customer_id;
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            \Fuel\Core\Log::error($ex->getMessage());
            return false;
        }
    }

    /**
     * action reminder password
     * @param $email
     * @param $password
     * @param $customer
     * @return bool
     */
    public function reminder_password($email, $password, $customer)
    {
        DB::start_transaction();
        //update password
        $customer->password = hash('SHA256', $password);
        $customer->is_new(false);
        if (!$customer->save()) {
            DB::rollback_transaction();
            return false;
        }

        //sent new password to email
        $subject = '【しごさが】パスワード再発行のお知らせ';
        $data = [
            'email' => $email,
            'company_name' => $customer->company_name,
            'staff_name' => $customer->staff_name,
            'password' => $password,
            'baseUrl' => \Fuel\Core\Uri::base()
        ];
        $template = 'email/reminder_password';
        if (!Utility::sendmail($email, $subject, $data, $template)) {
            DB::rollback_transaction();
            return false;
        }
        DB::commit_transaction();
        return true;
    }

    /**
     * author thuanth6589
     * validate for update sale customer
     * @return array|bool|string
     */
    public function validation_account()
    {
        $this->validate = \Fuel\Core\Validation::forge('customer');
        $this->validate->add_callable('myrules');
        $this->validate->add_field('company_name', \Fuel\Core\Lang::get('company_name'), 'required|max_length[50]');
        $this->validate->add_field('company_kana', \Fuel\Core\Lang::get('company_kana'), 'required|kana|max_length[50]');
        $this->validate->add_field('zipcode1', \Fuel\Core\Lang::get('zipcode1'), 'required|valid_string[numeric]|exact_length[3]');
        $this->validate->add_field('zipcode2', \Fuel\Core\Lang::get('zipcode2'), 'required|valid_string[numeric]|exact_length[4]');
        $this->validate->add_field('prefecture_id', \Fuel\Core\Lang::get('prefecture_id'), 'required');
        $this->validate->add_field('city', \Fuel\Core\Lang::get('city'), 'required|max_length[10]');
        $this->validate->add_field('town', \Fuel\Core\Lang::get('town'), 'required|max_length[50]');
        $this->validate->add_field('tel1', \Fuel\Core\Lang::get('tel1'), 'required|valid_string[numeric]|max_length[5]');
        $this->validate->add_field('tel2', \Fuel\Core\Lang::get('tel2'), 'required|valid_string[numeric]|max_length[4]');
        $this->validate->add_field('tel3', \Fuel\Core\Lang::get('tel3'), 'required|valid_string[numeric]|max_length[4]');
        $this->validate->add_field('fax1', \Fuel\Core\Lang::get('fax1'), 'valid_string[numeric]|max_length[5]')->add_rule('required_fax', [\Fuel\Core\Input::post('fax2'), \Fuel\Core\Input::post('fax3')]);
        $this->validate->add_field('fax2', \Fuel\Core\Lang::get('fax2'), 'valid_string[numeric]|max_length[4]')->add_rule('required_fax', [\Fuel\Core\Input::post('fax1'), \Fuel\Core\Input::post('fax3')]);
        $this->validate->add_field('fax3', \Fuel\Core\Lang::get('fax3'), 'valid_string[numeric]|max_length[4]')->add_rule('required_fax', [\Fuel\Core\Input::post('fax1'), \Fuel\Core\Input::post('fax2')]);
        $this->validate->add_field('president_name', \Fuel\Core\Lang::get('president_name'), 'required|max_length[50]');
        $this->validate->add_field('president_kana', \Fuel\Core\Lang::get('president_kana'), 'required|kana|max_length[50]');
        $this->validate->add_field('staff_name', \Fuel\Core\Lang::get('staff_name'), 'required|max_length[50]');
        $this->validate->add_field('staff_kana', \Fuel\Core\Lang::get('staff_kana'), 'required|kana|max_length[50]');
        $this->validate->add_field('password', \Fuel\Core\Lang::get('password'), 'check_password|min_length[8]|max_length[50]');
        $this->validate->add_field('password_check', \Fuel\Core\Lang::get('password_check'), 'match_field[password]');

        return !$this->validate->run() ? $this->validate->error_message() : true;
    }

    /**
     * update sale customer
     * @return mixed
     * @throws Exception
     */
    public function update_data()
    {
        $data = $this->fields;
        $data['password'] = $data['password'] ? hash('SHA256', $data['password']) : '';
        if (!$data['password']) {
            unset($data['password']);
        }
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->set($data);

        $this->is_new(false);
        return $this->save();
    }

    /**
     * validate change password
     * @return array|bool|string
     */
    public function validation_changepassword()
    {
        $this->validate = \Fuel\Core\Validation::forge('customer');
        $this->validate->add_callable('myrules');

        $this->validate->add_field('password', \Fuel\Core\Lang::get('password'), 'required|check_password|min_length[8]|max_length[50]');
        $this->validate->add_field('password_check', \Fuel\Core\Lang::get('password_check'), 'match_field[password]');

        return !$this->validate->run() ? $this->validate->error_message() : true;
    }
}
