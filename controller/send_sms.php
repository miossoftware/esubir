<?php

$yol = __DIR__ . "/Sms/SmsApi.php";
require_once($yol);

$smsApi = new SmsApi("panel4.ekomesaj.com", "epromnet", "4y8F6lOnuHR4", "9588");

$islem = $_GET["islem"];
if ($islem == "tekil_sms_yolla_sql") {

    $request = new SendSingleSms();
    $request->title = "MERHABA BİZ EPROMNETİZ";
    $request->content = "İÇERİK TEST MESAJI";
    $request->number = 905072080262;
    $request->encoding = 0;
    $request->type = 1;
    $request->recipientType = 0;
    $request->sendingType = 0;
    $request->sender = "EKOMESAJ";

    $response = $smsApi->sendSingleSms($request);

    if ($response->err == null) {
        echo "MessageId: " . $response->pkgID . "\n";
    } else {
        echo "Status: " . $response->err->status . "\n";
        echo "Code: " . $response->err->code . "\n";
        echo "Message: " . $response->err->message . "\n";
    }
}
if ($islem == "cogul_mesaj_yolla_sql") {
    $request = new SendMultiSms();
    $request->title = $_POST["baslik"];
    $request->content = $_POST["mesaj_icerigi"];
    $request->numbers = [$_POST["telefonlar"]];
    $request->encoding = 0;
    $request->sender = "EKOMESAJ";

//Kendi sistemindeki id ‘ler ile eşleştirme yapabilmek için kullanılan parametre
//$request->customID = "mesajId101";

//Ticari gönderimlerde true değeri girilmelidir.
//$request->commercial = true;

//Mesajların AHS sorgusuna sokulması istenmiyorsa true değeri girilmelidir.
//$request->skipAhsQuery = true;

//İleri tarihli gönderim için
//$request->sendingDate = "2021-01-10 13:00";

//Rapor push olarak alınmak isteniyorsa ilgili url girilir
//$request->pushUrl = "https://webhook.site/8d7ed0f7"

    $response = $smsApi->sendMultiSms($request);

    if ($response->err == null) {
        echo "MessageId: " . $response->pkgID . "\n";
    } else {
        echo "Status: " . $response->err->status . "\n";
        echo "Code: " . $response->err->code . "\n";
        echo "Message: " . $response->err->message . "\n";
    }
}
