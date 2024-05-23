<?php
$yol = __DIR__ . "controller/Sms/SmsApi.php";
echo $yol;
die();
require_once('controller/Sms/SmsApi.php');

$smsApi = new SmsApi("https://panel4.ekomesaj.com/sms/create", "epromnet", "4y8F6lOnuHR4", "9588");

//Default port 9587 istekler http olarak gitmektedir
//https istek atmak için SmsApi("hostAdress", "username", "password", "9588")
//yapılmalıdır

echo "\n***** GetCredit *****\n";
$response = $smsApi->getCredit();

if ($response->err == null) {
    echo "Kredi: " . $response->credit . "\n";
} else {
    echo "Status: " . $response->err->status . "\n";
    echo "Code: " . $response->err->code . "\n";
    echo "Message: " . $response->err->message . "\n";
}


echo "\n***** GetSenders *****\n";
$response = $smsApi->getSenders();

if ($response->err == null) {
    echo "Toplam Kayıt: " . $response->totalRecord . "\n";

    echo "Senders\n";
    $senders = $response->list;
    foreach ($senders as $item) {
        echo "uuid: " . $item->uuid . "\n";
        echo 'status: ' . $item->status . "\n";
        echo 'title: ' . $item->title . "\n";
    }
} else {
    echo "Status: " . $response->err->status . "\n";
    echo "Code: " . $response->err->code . "\n";
    echo "Message: " . $response->err->message . "\n";
}


echo "\n***** Cancel *****\n";
$response = $smsApi->cancel(119);

//CustomID ye göre paket iptal edilmek istenirse
//$response = $smsApi->cancelCustomId("mesajId100");

if ($response->err == null) {
    echo "Durum: " . $response->status . "\n";
} else {
    echo "Status: " . $response->err->status . "\n";
    echo "Code: " . $response->err->code . "\n";
    echo "Message: " . $response->err->message . "\n";
}


echo "\n***** SendSingleSms *****\n";
$request = new SendSingleSms();
$request->title = "Title";
$request->content = "SMS GÖNDERİM TESTİ";
$request->number = 905434921211;
$request->encoding = 0;
$request->sender = "SAMET KABADAYININ TEST SMS'İ";

//Kendi sistemindeki id ‘ler ile eşleştirme yapabilmek için kullanılan parametre
//$request->customID = "mesajId100";

//Ticari gönderimlerde true değeri girilmelidir.
//$request->commercial = true;

//Mesajların AHS sorgusuna sokulması istenmiyorsa true değeri girilmelidir.
//$request->skipAhsQuery = true;

//İleri tarihli gönderim için
//$request->sendingDate = "2021-01-10 13:00";

//Rapor push olarak alınmak isteniyorsa ilgili url girilir
//$request->pushUrl = "https://webhook.site/8d7ed0f7"

$response = $smsApi->sendSingleSms($request);

if ($response->err == null) {
    echo "MessageId: " . $response->pkgID . "\n";
} else {
    echo "Status: " . $response->err->status . "\n";
    echo "Code: " . $response->err->code . "\n";
    echo "Message: " . $response->err->message . "\n";
}


echo "\n***** SendMultiSms *****\n";
$request = new SendMultiSms();
$request->title = "Title";
$request->content = "Multi sms gönderim testi";
$request->numbers = [905006662211, 905006660011];
$request->encoding = 0;
$request->sender = "Gönderen Başlığı";

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


echo "\n***** SendDynamicSms *****\n";
$request = new SendDynamicSms();
$request->title = "Title";
$request->numbers = [
    new SmsItem(905006662211, "Sayın Ali Efe bu bir test mesajıdır"),
    new SmsItem(905006660011, "Sayın Ayse Ak bu bir test mesajıdır")
];
$request->encoding = 0;
$request->sender = "Gönderen Başlığı";

//Kendi sistemindeki id ‘ler ile eşleştirme yapabilmek için kullanılan parametre
//$request->customID = "mesajId102";

//Ticari gönderimlerde true değeri girilmelidir.
//$request->commercial = true;

//Mesajların AHS sorgusuna sokulması istenmiyorsa true değeri girilmelidir.
//$request->skipAhsQuery = true;

//İleri tarihli gönderim için
//$request->sendingDate = "2021-01-10 13:00";

//Rapor push olarak alınmak isteniyorsa ilgili url girilir
//$request->pushUrl = "https://webhook.site/8d7ed0f7"

$response = $smsApi->sendDynamicSms($request);

if ($response->err == null) {
    echo "MessageId: " . $response->pkgID . "\n";
} else {
    echo "Status: " . $response->err->status . "\n";
    echo "Code: " . $response->err->code . "\n";
    echo "Message: " . $response->err->message . "\n";
}


echo "\n***** GetSmsReports *****\n";
$request = new GetSmsReports();
$request->startDate = "2021-01-10 13:00";
$request->finishDate = "2021-06-10 13:00";
$request->pageIndex = 0;
$request->pageSize = 100;

//Eğer paket id sine göre sorgulamak istenirse
//$request->ids = [1110, 1234];

//Eğer kişisel id nize göre sorgulamak yapmak istenirse
//customIDs gönderiminde ids göndermeye gerek yoktur
//$request->customIDs = ["mesajId101","mesajId102"];


$response = $smsApi->getSmsReports($request);

if ($response->err == null) {
    echo "totalRecord: " . $response->totalRecord . "\n";


    echo "Reports\n";
    $reports = $response->list;
    foreach ($reports as $item) {
        echo "id: " . $item->id . "\n";
        echo "uuid: " . $item->uuid . "\n";
        echo "error: " . $item->error . "\n";
        echo "state: " . $item->state . "\n";
        echo "title: " . $item->title . "\n";
        echo "content: " . $item->content . "\n";
        echo "sender: " . $item->sender . "\n";
        echo "encoding: " . $item->encoding . "\n";
        echo "validity: " . $item->validity . "\n";
        echo "customID: " . $item->customID . "\n";
        echo "isScheduled: " . $item->isScheduled . "\n";
        echo "total: " . $item->statistics->credit . "\n";
        echo "credit: " . $item->statistics->total . "\n";
        echo "rCount: " . $item->statistics->rCount . "\n";
        echo "delivered: " . $item->statistics->delivered . "\n";
        echo "undelivered: " . $item->statistics->undelivered . "\n";
        echo "createDate: " . $item->createDate . "\n";
        echo "updateDate: " . $item->updateDate . "\n";
        echo "sendingDate: " . $item->sendingDate . "\n";
        echo "processingDate: " . $item->processingDate . "\n";
    }

} else {
    echo "Status: " . $response->err->status . "\n";
    echo "Code: " . $response->err->code . "\n";
    echo "Message: " . $response->err->message . "\n";
}


echo "\n***** GetSmsReportDetails *****\n";
$request = new GetSmsReportDetails();
$request->pkgID = 78;
$request->pageIndex = 0;
$request->pageSize = 100;

//Eğer kişisel id nize göre sorgulamak yapmak istenirse
//customID gönderiminde pkgID göndermeye gerek yoktur
//$request->customID = "mesajId102";

$response = $smsApi->getSmsReportDetails($request);

if ($response->err == null) {
    echo "totalRecord: " . $response->totalRecord . "\n";

    echo "Reports\n";
    $reports = $response->list;
    foreach ($reports as $item) {
        echo "id: " . $item->id . "\n";
        echo "msg: " . $item->msg . "\n";
        echo "error: " . $item->error . "\n";
        echo "state: " . $item->state . "\n";
        echo "credit: " . $item->credit . "\n";
        echo "sender: " . $item->sender . "\n";
        echo "target: " . $item->target . "\n";
        echo "setState: " . $item->setState . "\n";
        echo "sendingDate: " . $item->sendingDate . "\n";
        echo "deliveryDate: " . $item->deliveryDate . "\n";
        echo "processingDate: " . $item->processingDate . "\n";
    }

} else {
    echo "Status: " . $response->err->status . "\n";
    echo "Code: " . $response->err->code . "\n";
    echo "Message: " . $response->err->message . "\n";
}

?>