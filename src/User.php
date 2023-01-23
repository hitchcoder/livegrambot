<?php

namespace tglib;


class User
{

    public $id;
    public $username = null;

    function __construct($id)
    {
        $this->id = $id;
    }


    /*
     * set_step sets users step in directory tmp/
     * call function without arguments to delete step of user
     */
    public function set_step($step = false)
    {
        if (is_dir('./step')) {
            if ($step) file_put_contents('./step/' . $this->id, $step);
            else {
                if (file_exists('./step/' . $this->id)) unlink('./step/' . $this->id);
            }
        } else {
            mkdir('./step');
            file_put_contents('./step/' . $this->id, $step);
        }
    }


    /*
     * get_step gets users step
     */
    public function get_step()
    {
        return file_exists('./step/' . $this->id) ? file_get_contents('./step/' . $this->id) : false;
    }

    /*
     * get_step_byId is used to get users step without creating object of class User
     */
    public static function get_step_byId($id)
    {
        return file_exists('./step/' . $id) ? file_get_contents('./step/' . $id) : null;
    }

    /*
     * set_step_byId is used to set users step without creating object of class User
     */
    public static function set_step_byId($id, $step = false)
    {
        if (is_dir('./step')) {
            if ($step) file_put_contents('./step/' . $id, $step);
            else {
                if (file_exists('./step/' . $id)) unlink('./step/' . $id);
            }
        } else {
            mkdir('./step');
            file_put_contents('./step/' . $id, $step);
        }
    }

    public static function destroy_step_byId($id)
    {
        if (file_exists('./step/' . $id)) unlink('./step/' . $id);
    }

    public function user_exist($user_id)
    {
        global $db;
        $user = $user = $db->queryRow("select * from users where chat_id=" . $user_id);;
        return empty($user) ? false : true;
    }

    public function init_user($id, $name = 'null', $login = 'null', $message_id = null)
    {
        /**
         * @var \Db
         */
        global $db;
        $user = $db->db->query("select * from users where 'chat_id'=" . $id);

        if (empty($user)) {
            $name = preg_replace('/\xEE[\x80-\xBF][\x80-\xBF]|\xEF[\x81-\x83][\x80-\xBF]/', '.', $name);

            $db->exec("INSERT INTO `users`(`chat_id`, `name`, `username`, `message_id`) VALUES('$id', '$name', '$login', '$message_id')");
        } else {
            $db->update('users', ['name' => $name, 'message_id' => $message_id, 'username' => $login], 'chat_id=:chat_id', ['chat_id' => $id]);
        }

    }

    public function check_user($id)
    {
        global $db;
        global $bot;
        $user = $db->queryRow("select * from users where chat_id=" . $id);
        if(empty($user['name'])){
            $this->set_step('name');
            return false;
        } else if(empty($user['phone'])){
            $this->set_step('phone');
            return false;
        } else {
            return true;
        }
    }





}