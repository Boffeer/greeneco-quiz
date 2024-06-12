<?php
    // формируем запись в таблицу google (изменить)
    $url = "https://docs.google.com/forms/u/0/d/e/1FAIpQLScCwnFlYYw2ds9pVV3-KbDL9XfohYxgCvlyubFIPgFAf7dMJg/formResponse";
    // массив данных (изменить entry, draft и fbzx)
    $post_data = array (
        "entry.849616493" => $_POST['user_geo'],
        "entry.418154505" => $_POST['user_tel'],
        "entry.2104004045" => $_POST['UTM'],

        "partialResponse" => "[,,&quot;-8210781512274709099&quot;]",
        "pageHistory" => "0",
        "fbzx" => "-8210781512274709099"
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

?>