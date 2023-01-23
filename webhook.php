<?php

require_once __DIR__ . '/src/loader.php';
$config = json_decode(file_get_contents('./config.json'), true);
$bot = new tglib\Bot($config['token']);
$db = new tglib\Db(__DIR__ . '/db.db');

$update = json_decode(file_get_contents('php://input'));

if ($update->message) {
    $user = new tglib\User($update->message->from->id);
    if ($update->message->text == '/start') {
        if ($user->check_user($update->message->from->id)) {
            $bot->sendTextMessage($update->message->chat->id, 'Siz ro`yxatdan o`tganingiz uchun rahmat! Har qanday savolingiz bo`lsa, shu yerga yozib qoldirishingiz munkun.');
        }
    } elseif($user->get_step() == 'name'){
        $bot->sendTextMessage($user->id, 'Iltimos, ismingizni kiriting');
    } elseif($user->get_step() == 'phone'){
        $bot->sendTextMessage($user->id, 'Iltimos, telefon raqamingizni kiriting');
    } else{
//        TODO: forward and reply
        $bot->forward_message();
    }
}


if (isset($update->callback_query)) {

}