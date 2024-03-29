<?php
function expatAPI($url, $postData = NULL)
{
    $token = "4adf13f385783d126bde52d1087ff3e64c04866a";

    $ch     = curl_init($url);
    $headers    = array(
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    );

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    // $result = json_decode(curl_exec($ch));
    $result = (object) array(
        'result'        => json_decode(curl_exec($ch)),
        'status'        => curl_getinfo($ch)['http_code']
    );
    curl_close($ch);
    return $result;
}

function mobileAPI($url, $postData = NULL, $token = NULL)
{

    // $token = 'bbe287cf3a3bf23306bb175c8461ce86a16f6a75';

    $ch     = curl_init($url);
    $headers    = array(
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    );

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    // $result = json_decode(curl_exec($ch));
    $result = (object) array(
        'result'        => json_decode(curl_exec($ch)),
        'status'        => curl_getinfo($ch)['http_code']
    );
    curl_close($ch);
    return $result;
}



function getToken()
{
    $email = 'yanari0797@gmail.com';
    $pass = '40bd001563085fc35165329ea1ff5c5ecbdbbeef';

    $token = sha1($email . $pass);

    return $token;


}