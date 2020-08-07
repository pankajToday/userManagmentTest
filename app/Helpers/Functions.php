<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

function enc($string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = env('ENC_SEC_KEY');
    $secret_iv = env('ENC_SECRET_IV');;
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
    return base64_encode($output);
}

function dnc($string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = env('ENC_SEC_KEY');
    $secret_iv = env('ENC_SECRET_IV');
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    return openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
}

function is_FileExist($url)
{
    if (@file_get_contents($url)) {
        return true;
    }
    return false;
}

function uploadFile($file, $path) {
    $binary_data = base64_decode($file);
    Storage::disk('s3')->put($path, $binary_data, 'public');
    return 1;
}

function getDateFormat($date, $time = true) {
    if($time)
        return Carbon::parse($date)->format('d-m-Y h:i A');
    
    return Carbon::parse($date)->format('d-m-Y');
}

function callThirdPartyPostAPI( $url,$postField   )
{
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL =>$url,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_RETURNTRANSFER=> true,
        CURLOPT_POSTFIELDS => json_encode($postField,true),
    ));

    $response = json_decode(curl_exec($curl),true);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        return ["status"=>"cURL Error #:" . $err];
    } else {
        return $response;
    }
}

