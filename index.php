<?php
//require_once __DIR__ . '/../config.php'; 
require_once __DIR__ . '/autoload.php';
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
  
// Building Blocks
// 1. Make a Phone Call
// 2. Play Text-to-Speech/ e0a8533a-8712-46db-b808-ce98fa16f7b7
 

 
//Connection information
$base_url = 'https://api.nexmo.com' ;
$version = '/v1';
$action = '/calls';

//User and application information
$application_id = "82328630-1bcdsds1-49c2-851f-054dd55a56ce69";//this is demo application id

//Mint your JWT
$keyfile="private.key";

$jwt = generate_jwt($application_id, 'private.key'); 

//Add the JWT to the request headers
$headers =  array('Content-Type: application/json', "Authorization: Bearer " . $jwt ) ;

//Change the to parameter to the number you want to call
$payload = '{
    "to":[{
        "type": "phone",
        "number": "919828305699"
    }],
    "from": {
        "type": "phone",
        "number": "1202350291149"
    },
    "answer_url": ["http://visionfoundation.info/vendor/answer.php"]
}';


//Create the request
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $base_url . $version . $action);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

$response = curl_exec($ch);

echo $response;


function generate_jwt( $application_id, $keyfile) {

    $jwt = false;
    date_default_timezone_set('UTC');    //Set the time for UTC + 0
    $key = file_get_contents($keyfile);  //Retrieve your private key
    $signer = new Sha256();
    $privateKey = new Key($key);

    $jwt = (new Builder())->setIssuedAt(time() - date('Z')) // Time token was generated in UTC+0
        ->set('application_id', $application_id) // ID for the application you are working with
        ->setId( base64_encode( mt_rand (  )), true)
        ->sign($signer,  $privateKey) // Create a signature using your private key
        ->getToken(); // Retrieves the JWT

    return $jwt;
}
?>
