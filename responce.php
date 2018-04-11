<?php 
 
 /*   $curl = curl_init();
    // Set some options - we are passing in a useragent too here
    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => "https://api.nexmo.com/v1/calls/1ee7a532-197c-497b-86fb-7a32fe88e904",
        CURLOPT_USERAGENT => 'Codular Sample cURL Request',
        CURLOPT_POST => 1
    ));
    // Send the request & save response to $resp
    $resp = curl_exec($curl);
    // Close request to clear up some resources
    echo  $resp;
    curl_close($curl); */
 $base_url = 'https://rest.nexmo.com';
$action =   '/number/update';

//Change msisdn and country to match your virtual number
$msisdn = '12023502919';
$country = 'US';

$theurl = $base_url . $action . "?" .  http_build_query([
    'api_key' => 'c77ac40e',
    'api_secret' => 'xCfDy0H4zuDOGt5j',
    'country' => $country,
    'msisdn' => $msisdn,
    'voiceCallbackType' =>  'app',
    'voiceCallbackValue' => '82328630-1bc1-49c2-851f-05455a56ce69'

]);

$ch = curl_init($theurl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept: application/json", "Content-Length: 0"));
curl_setopt($ch, CURLOPT_HEADER, array('Content-Type: application/x-www-form-urlencoded'));
curl_setopt($ch, CURLOPT_HEADER, 1);
$response = curl_exec($ch);

$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
$header = substr($response, 0, $header_size);
$body = substr($response, $header_size);
echo $header;
if (strpos($header, '200')){
    echo ("  Success");
}
else {
    $error = json_decode($body, true);
    echo("Your request failed because:\n");
    echo("  " . $error['error-code'] . "  " . $error['error-code-label'] . "\n"  );
}
 
?>