<?php

namespace Merlin;

class TelegramLead
{
    private $botToken = '7254068591:AAHco195jxqzYl2eXnqb0AuCzhAduEHlaBg';
    private $chatId = '-1002197842137';
    private $lineBreakCharacter = "%0A";
    private $message = "";

    /*
     * В переменную $token нужно вставить токен, который нам прислал @botFather
     * https://vc.ru/dev/158136-kak-otpravlyat-zayavki-s-lendinga-pryamo-v-telegram
     */
    public function __construct()
    {
    }

    public function prepareMessage($dataArray) {
        foreach($dataArray as $key => $value) {
            $this->message .= "<b>".$key."</b> ".$value.$this->lineBreakCharacter;
        };
    }

    public function addString($string) {
        $this->message .= $string.$this->lineBreakCharacter;
    }

    public function send() {
        return fopen("https://api.telegram.org/bot{$this->botToken}/sendMessage?chat_id={$this->chatId}&parse_mode=html&text={$this->message}","r");
    }
}

