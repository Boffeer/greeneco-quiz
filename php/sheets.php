<?php
    // формируем запись в таблицу google (изменить)
    $url = "https://docs.google.com/forms/u/0/d/e/1FAIpQLSc-zz-In4ML1pX1VbQ3hpRhgw7lpNlRaGLfnMykjPV2MUJl8A/formResponse";
    // массив данных (изменить entry, draft и fbzx)
    $post_data = array (
        "entry.989598364" => $_POST['user_tel'],
        "entry.964364239" => $_POST['step_1'],
        "entry.745423854" => $_POST['step_2'],
        "entry.775779092" => $_POST['step_3'],
        "entry.202632878" => $_POST['step_4'],
        "entry.357335889" => $_POST['step_5'],
        "entry.575002439" => $_POST['UTM'],

        "partialResponse" => "[null,null,&quot;3007928168883549170&quot;]",
        "pageHistory" => "0",
        "fbzx" => "3007928168883549170"
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