ideal2
<?php
# Setup API URL
$strUrl = 'https://rest-api.pay.nl/v7/Transaction/start/json';
 
# Add arguments
$arrArguments['token'] = 'test_apitoken12345';
$arrArguments['serviceId'] = 'SL-7378-6230';
$arrArguments['amount'] = 3500;
$arrArguments['finishUrl'] = 'https://www.pay.nl/demo_ppt/finish_url';
$arrArguments['paymentOptionId'] = 10;
$arrArguments['transaction']['description'] = 'Description';
 
# Prepare and call API URL
$strUrl .= http_build_query($arrArguments);
var_dump( $strUrl );
$jsonResult = @file_get_contents($strUrl);

var_dump($jsonResult);
$jsonResult = json_decode($jsonResult);
echo $jsonResult;
?>