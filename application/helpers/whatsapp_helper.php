<?php
date_default_timezone_set('Asia/Jakarta');


function send_wa($no_wa, $pesan)
{
    $dataSending = array();
    $dataSending["api_key"] = 'HUVICSYRSVNYX7MW';
    $dataSending["number_key"] = '9ZZ5NjGJuQ9gtKOd';
    $dataSending["phone_no"] = $no_wa;
    $dataSending["message"] = $pesan;
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.watzap.id/v1/send_message',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($dataSending),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($response);
    return $data->status;
}

function send_wa_with_image($no_wa, $pesan, $image)
{
    $dataSending = array();
    $dataSending["api_key"] = 'HUVICSYRSVNYX7MW';
    $dataSending["number_key"] = '9ZZ5NjGJuQ9gtKOd';
    $dataSending["phone_no"] = $no_wa;
    $dataSending["message"] = $pesan;
    $dataSending["url"] = "https://gas.gisaka.net/uploads/registrasi/NUGRAHA_AGUNG_PRATAMA_04042024.jpeg";
    $dataSending["separate_caption"] = "0";
    $dataSending["wait_until_send"] = "1"; //This is an optional parameter, if you use this parameter the response will appear after sending the message is complete
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.watzap.id/v1/send_image_url',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode($dataSending),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    echo $response;
}
