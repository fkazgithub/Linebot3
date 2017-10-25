<?php
 
date_default_timezone_set('Asia/Tokyo');
$week = [
  '日', //0
  '月', //1
  '火', //2
  '水', //3
  '木', //4
  '金', //5
  '土', //6
];
$time = date('i');
$time2= date('w');
$weekday=$week[$time2];
require_once __DIR__ . '/vendor/autoload.php';
$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient(getenv('CHANNEL_ACCESS_TOKEN'));
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => getenv('CHANNEL_SECRET')]);



$signature = $_SERVER["HTTP_" . \LINE\LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
try {
  $events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);
} catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
  error_log("parseEventRequest failed. InvalidSignatureException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
  error_log("parseEventRequest failed. UnknownEventTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
  error_log("parseEventRequest failed. UnknownMessageTypeException => ".var_export($e, true));
} catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
  error_log("parseEventRequest failed. InvalidEventRequestException => ".var_export($e, true));
}
foreach ($events as $event) {

if ($event instanceof \LINE\LINEBot\Event\JoinEvent) {
    
$message = "寺子屋ラボ連絡用LineBotです";
  $bot->replyMessage($event->getReplyToken(),
    (new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder())
      ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message))
      
  );

    
    continue;
  }


  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent)) {
    error_log('Non message event has come');
    continue;
  }
  if (!($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
    error_log('Non text message has come');
    continue;
  }



  $mes=($event->getText());
  
 #$profile = $bot->getProfile($event->getUserId())->getJSONDecodedBody();
  #$message = $profile["displayName"] . "さん、おはようございます！今日も頑張りましょう！";
  #$message2 = "今は".$time."今日の天気は雨です。傘を持っていきましょう！";


if ($mes=="シフト情報"){
  $message4 ="シフト→"."https://docs.google.com/spreadsheets/d/1j2XKE1vSKnM5Zk_WQPU9yzKkvXqO-zImNW7TL1633KE/htmlview#";
$bot->replymessage($event->getReplyToken(),
    (new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder())
      ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message4))
);

}


// if ($mes=="各校舎"){


// function replyButtonsTemplate($bot, $replyToken, $alternativeText, $imageUrl, $title, $text, ...$actions) {
//   $actionArray = array();
//   foreach($actions as $value) {
//     array_push($actionArray, $value);
//   }
//   $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(
//     $alternativeText,
//     new \LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder ($title, $text, $imageUrl, $actionArray)
//   );
//   $response = $bot->replyMessage($replyToken, $builder);
//   if (!$response->isSucceeded()) {
//     error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
//   }
// }


// replyButtonsTemplate($bot,
//     $event->getReplyToken(),
//     "醍醐寺お知らせ - 醍醐寺校です",
//     "https://" . $_SERVER["HTTP_HOST"] . "/imgs/template.jpg",
//     "醍醐寺",
//     "醍醐寺校の情報です",
//     new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
//       "生徒座席情報", "https://docs.google.com/spreadsheets/d/1cPZLDwnp1hQkVR4RS_XWynXX8HnNd9d0eMbEavz06rw/edit#gid=0"),
//     new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
//       "生徒情報(IDと電話番号)", "https://docs.google.com/spreadsheets/d/1p7lIi8ZwZIA8RioETENjyUTvay_KQBLphhXbzl-ouEQ/edit#gid=47939296"),
//     new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
//       "連絡事項", "https://docs.google.com/document/d/14XNIJyTG1kZB5vP6-d7lfRmLkEJeYR_Bm0Rg1sKKeto/edit")

//     );


//  }

 if ($mes=="京都各校舎情報"){


function replyCarouselTemplate($bot, $replyToken, $alternativeText, $columnArray) {
  $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(
  $alternativeText,
  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder (
   $columnArray)
  );
  $response = $bot->replyMessage($replyToken, $builder);
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

$columnArray = array();
   



    $actionArray = array();
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒座席情報", "https://docs.google.com/spreadsheets/d/1cPZLDwnp1hQkVR4RS_XWynXX8HnNd9d0eMbEavz06rw/edit#gid=0"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒情報(IDと電話番号)", "https://docs.google.com/spreadsheets/d/1p7lIi8ZwZIA8RioETENjyUTvay_KQBLphhXbzl-ouEQ/edit#gid=47939296"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder ("連絡事項", "https://docs.google.com/document/d/14XNIJyTG1kZB5vP6-d7lfRmLkEJeYR_Bm0Rg1sKKeto/edit"));
    $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder (
      "醍醐寺校の情報です",
      "醍醐寺校",
      "https://" . $_SERVER["HTTP_HOST"] .  "/imgs/template.jpg",
      $actionArray
    );
    array_push($columnArray, $column);



 $actionArray = array();
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒座席情報", "https://docs.google.com/spreadsheets/d/1cPZLDwnp1hQkVR4RS_XWynXX8HnNd9d0eMbEavz06rw/edit#gid=0"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒情報(IDと電話番号)", "https://docs.google.com/spreadsheets/d/1p7lIi8ZwZIA8RioETENjyUTvay_KQBLphhXbzl-ouEQ/edit#gid=47939296"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder ("連絡事項", "https://docs.google.com/document/d/14XNIJyTG1kZB5vP6-d7lfRmLkEJeYR_Bm0Rg1sKKeto/edit"));
    $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder (
      "法華寺校の情報です",
      "法華寺校",
      "https://" . $_SERVER["HTTP_HOST"] .  "/imgs/t3.jpg",
      $actionArray
    );
    array_push($columnArray, $column);





    $actionArray = array();
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒座席情報", "https://docs.google.com/spreadsheets/d/1cPZLDwnp1hQkVR4RS_XWynXX8HnNd9d0eMbEavz06rw/edit#gid=0"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒情報(IDと電話番号)", "https://docs.google.com/spreadsheets/d/1p7lIi8ZwZIA8RioETENjyUTvay_KQBLphhXbzl-ouEQ/edit#gid=47939296"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder ("連絡事項", "https://docs.google.com/document/d/14XNIJyTG1kZB5vP6-d7lfRmLkEJeYR_Bm0Rg1sKKeto/edit"));
    $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder (
      "大泉寺校の情報です",
      "大泉寺校",
      "https://" . $_SERVER["HTTP_HOST"] .  "/imgs/t4.jpg",
      $actionArray
    );
    array_push($columnArray, $column);




  
  replyCarouselTemplate($bot, $event->getReplyToken(),"各校舎の情報", $columnArray);

 }






if ($mes=="大阪各校舎情報"){


function replyCarouselTemplate($bot, $replyToken, $alternativeText, $columnArray) {
  $builder = new \LINE\LINEBot\MessageBuilder\TemplateMessageBuilder(
  $alternativeText,
  new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder (
   $columnArray)
  );
  $response = $bot->replyMessage($replyToken, $builder);
  if (!$response->isSucceeded()) {
    error_log('Failed!'. $response->getHTTPStatus . ' ' . $response->getRawBody());
  }
}

$columnArray = array();
   



    $actionArray = array();
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒座席情報", "https://docs.google.com/spreadsheets/d/1cPZLDwnp1hQkVR4RS_XWynXX8HnNd9d0eMbEavz06rw/edit#gid=0"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒情報(IDと電話番号)", "https://docs.google.com/spreadsheets/d/1p7lIi8ZwZIA8RioETENjyUTvay_KQBLphhXbzl-ouEQ/edit#gid=47939296"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder ("連絡事項", "https://docs.google.com/document/d/14XNIJyTG1kZB5vP6-d7lfRmLkEJeYR_Bm0Rg1sKKeto/edit"));
    $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder (
      "豊中不動尊校の情報です",
      "豊中不動尊校",
      "https://" . $_SERVER["HTTP_HOST"] .  "/imgs/t2.jpg",
      $actionArray
    );
    array_push($columnArray, $column);



 $actionArray = array();
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒座席情報", "https://docs.google.com/spreadsheets/d/1cPZLDwnp1hQkVR4RS_XWynXX8HnNd9d0eMbEavz06rw/edit#gid=0"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒情報(IDと電話番号)", "https://docs.google.com/spreadsheets/d/1p7lIi8ZwZIA8RioETENjyUTvay_KQBLphhXbzl-ouEQ/edit#gid=47939296"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder ("連絡事項", "https://docs.google.com/document/d/14XNIJyTG1kZB5vP6-d7lfRmLkEJeYR_Bm0Rg1sKKeto/edit"));
    $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder (
      "調御寺校の情報です",
      "調御寺校",
      "https://" . $_SERVER["HTTP_HOST"] .  "/imgs/t5.jpg",
      $actionArray
    );
    array_push($columnArray, $column);





    $actionArray = array();
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒座席情報", "https://docs.google.com/spreadsheets/d/1cPZLDwnp1hQkVR4RS_XWynXX8HnNd9d0eMbEavz06rw/edit#gid=0"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder (
      "生徒情報(IDと電話番号)", "https://docs.google.com/spreadsheets/d/1p7lIi8ZwZIA8RioETENjyUTvay_KQBLphhXbzl-ouEQ/edit#gid=47939296"));
    array_push($actionArray, new LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder ("連絡事項", "https://docs.google.com/document/d/14XNIJyTG1kZB5vP6-d7lfRmLkEJeYR_Bm0Rg1sKKeto/edit"));
    $column = new \LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder (
      "常福寺校の情報です",
      "常福寺校",
      "https://" . $_SERVER["HTTP_HOST"] .  "/imgs/t6.jpg",
      $actionArray
    );
    array_push($columnArray, $column);




  
  replyCarouselTemplate($bot, $event->getReplyToken(),"各校舎の情報", $columnArray);

 }





  if ($mes=="業務終了"){
  $profile = $bot->getProfile($event->getUserId())->getJSONDecodedBody();
 $message = $profile["displayName"] ."さん、".$weekday."曜日の"."講師、アシスタント業務お疲れ様でした。\n"."アシスタント業務担当の方は以下のシートにFacebook宣伝用の写真及びコメントを\n"."\n".
 "講師の方は授業の振り返りを以下のFacebookグループにシェアお願いします。\n".
 "また出勤届けの方も記入よろしくお願いします。";
 $message2 ="アシスタント業務→"."https://docs.google.com/document/d/1SUia-WNrSVfvykKgY5UPqdtaAaOF8PJv7iyLtL1wo2E/edit#heading=h.pj92656i2uw8";
 $message3 = "講師の方→"."https://www.facebook.com/groups/1888814174735503/";

  $bot->replymessage($event->getReplyToken(),
    (new \LINE\LINEBot\MessageBuilder\MultiMessageBuilder())
      ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message))
      ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message2))
       ->add(new \LINE\LINEBot\MessageBuilder\TextMessageBuilder($message3))
  );
}
}
 ?>