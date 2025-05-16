<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Telegram extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('string');
        $this->load->model('Users_m');
        $this->load->model('Kasbon_m');

    }
    function test()
    {
        // $data = $this->Users_m->get_chat_id_administrator();
        // echo json_encode($data);

        // foreach ($data as $key) {
        //     echo $key->chat_id;
        // }
        $no_dok = '0002/KBN/2/2023';
        $data = $this->Kasbon_m->get_by_no_dokumen($no_dok);
        echo json_encode($data);
    }

    // function verify($id_kasbon, $pesan)
    // {

    //     $CI = get_instance();
    //     $CI->load->model('Kasbon_m');
    //     $chat_id = $CI->Kasbon_m->get_chat_id_by_id_kasbon($id_kasbon);
    //     // create curl resource 
    //     $ch = curl_init();
    //     $txt = urlencode("LOG : $pesan \n");
    //     $TOKEN = "6259502863:AAEsTD1linSz1FbX4Hs7SH5U238u_ftIRZU";
    //     $apiURL = "https://api.telegram.org/bot$TOKEN";
    //     // set url 
    //     curl_setopt($ch, CURLOPT_URL, $apiURL . "/sendmessage?chat_id=$chat_id/&text=$txt");
    //     //return the transfer as a string 
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     // $output contains the output string 
    //     $output = curl_exec($ch);
    //     // close curl resource to free up system resources 
    //     curl_close($ch);
    // }

    // public function index()
    // {
    //     $content = file_get_contents("php://input");
    //     $TOKEN = "6259502863:AAEsTD1linSz1FbX4Hs7SH5U238u_ftIRZU";
    //     $apiURL = "https://api.telegram.org/bot$TOKEN";
    //     $update = json_decode($content, TRUE);
    //     // $chatID = $update["message"]["chat"]["id"];
    //     $chatID_ade = 959036270;
    //     $message = $update["message"]["text"];
    //     $txtok = urlencode("SELAMAT DATANG DI GISAKA AUTOMATION SYSTEM");
    //     file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID_ade . "&text=$txtok.&parse_mode=HTML");
    //     if ($message) {
    //         $txtok = urlencode("SELAMAT DATANG DI GISAKA AUTOMATION SYSTEM");
    //         file_get_contents($apiURL . "/sendmessage?chat_id=" . $chatID_ade . "&text=$txtok.&parse_mode=HTML");
    //     }

    // }
    // public function send()
    // {
    //     // create curl resource 
    //     $ch = curl_init();
    //     $txt = urlencode("Pesan otomatis (setiap 1 menit) dari GAS Notification");
    //     $TOKEN = "6259502863:AAEsTD1linSz1FbX4Hs7SH5U238u_ftIRZU";
    //     $apiURL = "https://api.telegram.org/bot$TOKEN";
    //     // set url 
    //     curl_setopt($ch, CURLOPT_URL, $apiURL . "/sendmessage?chat_id=959036270/&text=$txt");
    //     //return the transfer as a string 
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    //     // $output contains the output string 
    //     $output = curl_exec($ch);
    //     // close curl resource to free up system resources 
    //     curl_close($ch);
    // }

}

/* End of file Telegram.php */