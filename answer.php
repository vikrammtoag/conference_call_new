<?php

$method = $_SERVER['REQUEST_METHOD'];
$request = array_merge($_GET, $_POST);

switch ($method) {
  case 'GET':

    //Retrieve with the parameters in this request
    $to = $request['to']; //The endpoint being called
    $from = $request['from']; //The endpoint you are calling from
    $uuid = $request['uuid']; //The unique ID for this Conversation

    //Send the header
    header('Content-Type: application/json');

    //For more advanced Conversations you use the paramaters to personalize the NCCO
    //Dynamically create the NCCO to run a moderated conversation from your virtual number
    if( $from == "12023502919")
      $ncco='[
              {
                "action": "conversation",
                "name": "nexmo-conference-moderated",
                "endOnExit": "true",
                "record": "true"
              }
             ]';
    else
      $ncco='[
        {
          "action": "talk",
          "text": "Welcome to a Nexmo moderated conference",
          "voiceName": "Amy"
        },
        {
          "action": "conversation",
          "name": "nexmo-conference-moderated",
          "startOnEnter": "false",
          "musicOnHoldUrl": ["https://nexmo-community.github.io/ncco-examples/assets/voice_api_audio_streaming.mp3"]
        }
      ]';

    echo $ncco;
    break;
  default:
    //Handle your errors
    handle_error($request);
    break;
}
?>