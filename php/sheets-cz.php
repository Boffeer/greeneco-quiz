<?php

include_once __DIR__ . '/TelegramLead.php';
    // формируем запись в таблицу google (изменить)
//    $url = "https://docs.google.com/forms/d/1DA9da4e_CUlEgYTGRkkp5_BvqHmixuUtRd9h05QVJx8/formResponse";

    $url = "https://docs.google.com/forms/u/0/d/e/1FAIpQLSes1-dKTvHJf8tBjdAasMMzvjoWCc6EiN1rBnvfPpdhKK5KZw/formResponse";
//    $url = "https://docs.google.com/forms/d/1FAIpQLSes1-dKTvHJf8tBjdAasMMzvjoWCc6EiN1rBnvfPpdhKK5KZw/formResponse";
    // массив данных (изменить entry, draft и fbzx)

    $telegram = new \Merlin\TelegramLead();
    $telegram->addString('<b>Quiz lead</b>');
    $ignoreTelegramKeys = [
        'salebot',
        'redirect',
        'form_name',
        'UTM',
        'ym_event',
    ];
    foreach ($_POST as $key => $string) {
        if (in_array($key, $ignoreTelegramKeys)) {
            continue;
        }
        if (strpos($string, 'step') !== false) {
            $string = $key.': ' . $string;
        }
        $telegram->addString($string);
    }
    $telegram->send();

    $post_data = array (
        "entry.2127694805" => $_POST['user_name'],
        "entry.122091207" => $_POST['user_tel'],
        "entry.412399827" => $_POST['step_1'],
        "entry.1998304485" => $_POST['step_2'],
        "entry.610950231" => $_POST['step_3'],
        "entry.898347568" => $_POST['step_4'],
        "entry.506556271" => $_POST['step_5'],
        "entry.1686574090" => $_POST['UTM'],


        "partialResponse" => "[,,&quot;-3044823391786069845&quot;]",
        "pageHistory" => "0",
        "fbzx" => "-3044823391786069845"
    );

    // Далее не трогать
    // с помощью CURL заносим данные в таблицу google
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // указываем, что у нас POST запрос
    curl_setopt($ch, CURLOPT_POST, 1);
    // добавляем переменные
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    //заполняем таблицу google
    $output = curl_exec($ch);
    curl_close($ch);

    echo json_encode($post_data);
?>