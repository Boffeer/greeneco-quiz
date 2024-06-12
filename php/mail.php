<?php

// Перед тем, как орать почему заявка не отправляется, проверь этот массив

$config = array(
    'email' => false,
    'telegram' => false,
    'google_sheets' => true,
    'logfile' => false,
    'amo' => false,
	'wirecrm' => false,
);

/**
 * @date 2021-10-18
 * @param {string} $var_name
 * @returns {any}
 */
function getSafeValue ($var_name) {
    $safe_value = strip_tags($_GET[$var_name]);
    $safe_value = htmlentities($safe_value, ENT_QUOTES, "UTF-8");
    $safe_value = htmlspecialchars($safe_value, ENT_QUOTES);
    return $safe_value;
}

function getActualLink() {
    return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
}

function getCurrentDate() {
    $date = new DateTime();
    $date = $date->format('d.m.Y, H:i');
    return $date;
}

?>


<?php
/**
 * EMAIL
 */
// configs

if ($config['email']) {

    $formname = getSafeValue('formname');
    $name = getSafeValue('user_name');
    $tel = getSafeValue('user_tel');

    $actual_link = getActualLink();

    $message_body =
        "<a href=\"$actual_link\">$actual_link</a><br/><br/>" .
        "Форма: $formname<br/><br/>" .
        "Имя: $name<br/><br/>" .
        "Телефон: $tel<br/><br/>";

	$email_to = '=== === Куда отправлять === ===';
	$email_from = '=== === От кого отправлять === ===';
	$email_subject = "=== === Тема письма === ===";

    $msg_box = "";
    $errors = array();

    // если форма без ошибок
    if(empty($errors)){
        // собираем данные из формы
        $message = "Имя: " . $_POST['user_name'] . "<br/> Телефон: " . $_POST['user_tel'];
        send_mail($message, $email_to, $email_subject, $email_from); // отправим письмо
    }

    // функция отправки письма
    function send_mail($message, $email_to, $email_subject, $email_from){


        // почта, на которую придет письмо
        $mail_to = $email_to;

        // тема письма
        $subject = $email_subject;

        // заголовок письма
        $headers= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n"; // кодировка письма
        $headers .= "From: <". $email_from .">\r\n"; // от кого письмо

        // отправляем письмо
        mail($mail_to, $subject, $message, $headers);
    }
}
?>


<?php
/**
 * Telegram
 */

if ($config['telegram']) {
    //В переменную $token нужно вставить токен, который нам прислал @botFather
    $token = "";

    //Сюда вставляем chat_id
    $chat_id = "";

    //Определяем переменные для передачи данных из нашей формы
    // if ($_POST['act'] == 'order') {
        $name = ($_POST['user_name']);
        $phone = ($_POST['user_tel']);
    // }

    //Собираем в массив то, что будет передаваться боту
        $arr = array(
            'Имя:' => $name,
            'Телефон:' => $phone
        );

    //Настраиваем внешний вид сообщения в телеграме
        foreach($arr as $key => $value) {
            $txt .= "<b>".$key."</b> ".$value."%0A";
        };

    //Передаем данные боту
        $sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}","r");
}
?>


<?php
/**
 * GOOGLE SPREADSHEETS
 */

if ($config['google_sheets']) {
    // формируем запись в таблицу google (изменить)
    $url = "https://docs.google.com/forms/u/0/d/e/1FAIpQLSc-zz-In4ML1pX1VbQ3hpRhgw7lpNlRaGLfnMykjPV2MUJl8A/formResponse";
    // массив данных (изменить entry, draft и fbzx)
    $post_data = array (
        "entry.170535966" => $_POST['user_geo'],
        "entry.989598364" => $_POST['user_tel'],
        "entry.964364239" => $_POST['step_1'],
        "entry.745423854" => $_POST['step_2'],
        "entry.775779092" => $_POST['step_3'],
        "entry.202632878" => $_POST['step_4'],
        "entry.357335889" => $_POST['step_5'],

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

}
?>

<?php
if ($config['logfile']) {

    $log_file_name = 'leads.log';

    $fp = fopen($log_file_name, 'a+');

    $date = date('Y-m-d H:i:s') . "\n";


    $formname = getSafeValue('formname');
    $name = getSafeValue('user_name');
    $tel = getSafeValue('user_tel');

    $actual_link = getActualLink();

    $log_data =
        "$actual_link\n" .
        "Форма: $formname\n" .
        "Имя: $name\n" .
        "Телефон: $tel\n";

    $text = $date . "\n" .
        $log_data . "\n" .
        "---------\n\n";

    fwrite($fp, $text);
    fclose($fp);

}
?>

<?php

if ($config['amo']) {
    // AMO lead
    if(isset($_POST['form_name'])) {
        if ($_POST['form_name'] == 'quiz') {
    $paramsArray = array(
        'fields[note_2]' => '',
        // This parameters you can find at from publishing section → Wordpress shortcode
        'form_id' => '1180678',
        'hash'    => '6173c65591460d1243d29c7ab808ca93'
    ); 

    if (isset($_POST['user_name'])) {
        $paramsArray['fields[name_1]'] = $_POST['user_name'];
    } else {
        $paramsArray['fields[name_1]'] = '';
    }
    if (isset($_POST['user_tel'])) {
        $paramsArray['fields[419093_1][816111]'] = $_POST['user_tel'];
    } else {
        $paramsArray['fields[419093_1][816111]'] = '';
    }
    if (isset($_POST['salebot'])) {
        $paramsArray['fields[805201_2]'] = $_POST['salebot'];
    } else {
        $paramsArray['fields[805201_2]'] = '';
    }
    if (isset($_POST['from_source'])) {
        $paramsArray['fields[805001_2]'] = $_POST['from_source'];
    } else {
        $paramsArray['fields[805001_2]'] = '';
    }
    if (isset($_POST['step-2'])) {
        $paramsArray['fields[805003_2]'] = $_POST['step-2'];
    } else {
        $paramsArray['fields[805003_2]'] = '';
    }
    if (isset($_POST['step-3'])) {
        $paramsArray['fields[805005_2]'] = $_POST['step-3'];
    } else {
        $paramsArray['fields[805005_2]'] = '';
    }
    if (isset($_POST['step-4'])) {
        $paramsArray['fields[802535_2]'] = $_POST['step-4'];
    } else {
        $paramsArray['fields[802535_2]'] = '';
    }
    if (isset($_POST['step-5'])) {
        $paramsArray['fields[802537_2]'] = $_POST['step-5'];
    } else {
        $paramsArray['fields[802537_2]'] = '';
    }
    

    foreach ($_POST as $key => $value) {
        $paramsArray['fields[note_2]'] .= $key." ".$value."\n";
    };
}
}
   
// вторая форма
else {
    $paramsArray = array(
        'fields[note_2]' => '',
        // This parameters you can find at from publishing section → Wordpress shortcode
        'form_id' => '1182398',
        'hash'    => '4a03846b224c3225803f33b4003528c7'
    ); 

    if (isset($_POST['user_geo'])) {
        $paramsArray['fields[419101_3]'] = $_POST['user_geo'];
    } else {
        $paramsArray['fields[419101_3]'] = '';
    }
    if (isset($_POST['user_tel'])) {
        $paramsArray['fields[419093_3][816111]'] = $_POST['user_tel'];
    } else {
        $paramsArray['fields[419093_3][816111]'] = '';
    }
    if (isset($_POST['salebot'])) {
        $paramsArray['fields[805201_2]'] = $_POST['salebot'];
    } else {
        $paramsArray['fields[805201_2]'] = '';
    }
    

    foreach ($_POST as $key => $value) {
        $paramsArray['fields[note_2]'] .= $key." ".$value."\n";
    };
}
    $vars = http_build_query($paramsArray);

    $options = array(
        'http' => array(
            'method'  => 'POST',
            'header'  => 'Content-type: application/x-www-form-urlencoded',
            'content' => $vars
        )
    );

    $send_counter = 0;

    $context  = stream_context_create($options);
    $amo = file_get_contents('https://forms.amocrm.ru/queue/add', false, $context);
}

if ($config['wirecrm']) {
	//Пример добавления сделки с указанием определенного этапа продажи на PHP
	$apikey = "ВСТАВЬ СЮДА СВОЙ АПИ";
	//Получаем список этапов сделок
	$get_deals_url = "https://wirecrm.com/api/v1/deals/stages";

	$headers = array("X-API-KEY:".$apikey);

	$handle = curl_init();

	curl_setopt($handle, CURLOPT_URL, $get_deals_url);

	curl_setopt($handle, CURLOPT_USERAGENT, "WireCRM Rest API");

	curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);

	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

	curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

	$data = curl_exec($handle);

	curl_close($handle);

	$all_deals_json = json_decode($data);

	$today = date("Y-m-d");

	$description = "";

	foreach ($_POST as $post) {
		if ($post === $_POST['user_name'] || $post === $_POST['user_tel']) break;
			$description .= "{$post}\n\n";
	}

	//Добавляем сделку с первым этапом из списка выше
	$deal = array(
		'name' => $_POST['user_name'],
		'description' => $description,
		'currency' => '1',
		'stage' => $all_deals_json->data[0]->id,
		'd_close' => $today,
		// 'stage' => 0,
	);
	$deal_url = "https://wirecrm.com/api/v1/deals";

	$contact = array(
		'name' => $_POST['user_name'],
		'phone' => $_POST['user_tel'],
		'description' => $description
	);
	$contact_json = json_encode($contact);
	$contact_url = 'https://wirecrm.com/api/v1/contacts';

		// $handle = curl_init();
		// curl_setopt($handle, CURLOPT_URL, $deal_url);
		// curl_setopt($handle, CURLOPT_USERAGENT, "WireCRM Rest API");
		// curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		// curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

		// curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
		// curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
		// curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

		// $data = curl_exec($handle);
		// curl_close($handle);
		// var_dump($data);

	function wirecrm_post($url, $headers, $data) {
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_USERAGENT, "WireCRM Rest API");
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($handle, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

		$data = curl_exec($handle);
		curl_close($handle);

		return json_decode($data);
	}
	function wirecrm_get($url, $headers, $data) {
		$handle = curl_init();
		curl_setopt($handle, CURLOPT_URL, $url);
		curl_setopt($handle, CURLOPT_USERAGENT, "WireCRM Rest API");
		curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

		curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

		$data = curl_exec($handle);
		curl_close($handle);

		return json_decode($data);
	}

	// $deals = wirecrm_get($get_deals_url, $headers, $data);

	$new_contact = wirecrm_post($contact_url, $headers, $contact_json);

	$deal['contact'] = $new_contact->data;
	if (isset($_POST['bundle_price'])) {
		$price = str_replace(' ', '', $_POST['bundle_price']);
		$price = preg_replace('/\D/', ' ', $price);
		$deal['price'] = $price;
	}
	$deal_json = json_encode($deal);

	$new_deal = wirecrm_post($deal_url, $headers, $deal_json);

	print_r('{}');

}
