<?php

/**
 * @author Thuanth6589 <thuanth6589@seta-asia.com.vn>
 * Class Model_Mailqueue
 */
class Model_Mailqueue extends \Fuel\Core\Model_Crud
{
    protected static $_table_name = 'mail_queue';
    protected static $_primary_key = 'queue_id';


    /**
     * save data to mail queue
     * @param $data_mail_user
     * @param $data_mail_admin
     * @return bool
     */
    public function save_data_after_confirm_person($data_mail_user, $data_mail_admin)
    {
        \Fuel\Core\DB::start_transaction();
        try {
            if ($data_mail_user != null) {
                $queue = new Model_Mailqueue();
                $queue->set($data_mail_user);
                if (!$queue->save()) {
                    \Fuel\Core\DB::rollback_transaction();
                    return false;
                }
            }

            $queue = new Model_Mailqueue();
            if (count($data_mail_admin) && $data_mail_admin['mail_to']) {
                $queue->set($data_mail_admin);
                if (!$queue->save()) {
                    \Fuel\Core\DB::rollback_transaction();
                    return false;
                }
            }
            \Fuel\Core\DB::commit_transaction();
            return true;
        } catch (Exception $e) {
            \Fuel\Core\DB::rollback_transaction();
        }
        return true;
    }
}
