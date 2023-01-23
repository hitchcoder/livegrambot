<?php

namespace tglib;

class Bot
{
    private $API_TOKEN;
    public $user_id;

    public function __construct($API_TOKEN)
    {
        $this->API_TOKEN = $API_TOKEN;
    }

    public function user_id($user_id)
    {
        $this->user_id = $user_id;
    }

    /**
     * @param $method
     * @param $data
     * @return mixed
     */
    public function bot($method, $data)
    {
        $url = "https://api.telegram.org/bot" . $this->API_TOKEN . '/' . $method;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        if (curl_error($ch)) {
            var_dump(curl_error($ch));
        } else {
            return json_decode($res);
        }
        return json_decode($res);
    }

    /**
     * @param $user_id
     * @param $data
     * @return mixed
     */
    public function sendTextMessage($user_id, $text)
    {
        $data = [
            'chat_id' => $user_id,
            'text' => $text,
        ];
        return $this->sm($user_id, $data);
    }

    public function sm($user_id, $data)
    {
        $data['chat_id'] = $user_id;
        return $this->bot('sendmessage', $data);
    }

    public function forward_message($message_id, $from, $to){
        return $this->bot('ForwardMessage',[
            'chat_id'=> $admin,
            'from_chat_id'=> $from,
            'message_id'=>$message_id,
        ])->result->message_id;
    }
}