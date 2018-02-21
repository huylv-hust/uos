<?php

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Model_Muser
 * @package Model
 */
class Model_Muser extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'm_user';
    protected static $_primary_key = 'user_id';
    protected static $_properties = array(
        'user_id',
        'department_id',
        'division_type',
        'name',
        'login_id',
        'created_at',
        'updated_at',
        'mail',
        'pass',
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

    /*
     * List email
     *
     * @since 28/10/2015
     * @author Ha Huu Don<donhh6551@seta-asia.com.vn>
     */
    public function get_list_user_email()
    {
        $query = DB::select('mail')
            ->from(self::$_table_name);
        $query->where('division_type', 1);
        $query->where('mail', '!=', null);
        $query->where('mail', '!=', '');

        return $query->execute()->as_array();
    }

    public function get_list_mail_department($department_id)
    {
        $query = DB::select('mail')
            ->from(self::$_table_name);
        $query->where('department_id', $department_id);
        $query->where('mail', '!=', null);
        $query->where('mail', '!=', '');

        return $query->execute()->as_array();
    }

    /**
     * author thuanth6589
     * get mail by user id
     * @param array $user_id
     * @return array
     */
    public function get_list_mail_by_user($user_id = [])
    {
        if (empty($user_id)) {
            return [];
        }
        $query = DB::select('mail')->from(self::$_table_name);
        $query->where('user_id', 'IN', $user_id);
        return $query->execute()->as_array();
    }
}
