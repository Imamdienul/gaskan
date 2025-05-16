<?php
date_default_timezone_set('Asia/Jakarta');
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'IP tidak dikenali';
    return $ipaddress;
}
function get_client_ip_2()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'IP tidak dikenali';
    return $ipaddress;
}
function get_client_browser()
{
    $browser = '';
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Netscape'))
        $browser = 'Netscape';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox'))
        $browser = 'Firefox';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome'))
        $browser = 'Chrome';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera'))
        $browser = 'Opera';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
        $browser = 'Internet Explorer';
    else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari'))
        $browser = 'Safari';
    else
        $browser = 'Other';
    return $browser;
}
function telegram_notif_login($nama)
{
    $nama_user = $nama['nama_user'];
    $time = date("d-m-Y h:i:sa");
    $system = $_SERVER['HTTP_USER_AGENT'];
    $browser = get_client_browser();
    $ip_address = get_client_ip();
    // create curl resource 
    $ch = curl_init();
    $txt = urlencode("LOG : LOGIN\nNAMA : $nama_user \nWAKTU : $time\nSYSTEM : $system \nBROWSER : $browser \nIP ADDRESS : $ip_address");
    $TOKEN = "6259502863:AAEsTD1linSz1FbX4Hs7SH5U238u_ftIRZU";
    $apiURL = "https://api.telegram.org/bot$TOKEN";
    // set url 
    curl_setopt($ch, CURLOPT_URL, $apiURL . "/sendmessage?chat_id=959036270/&text=$txt");
    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $output contains the output string 
    $output = curl_exec($ch);
    // close curl resource to free up system resources 
    curl_close($ch);
}
function telegram_notif_status_kasbon($post, $status, $pesan)
{
    $CI = get_instance();
    $CI->load->model('Kasbon_m');
    $chat_id = $CI->Kasbon_m->get_chat_id_by_id_kasbon(decrypt_url($post['fid_kasbon']));
    $no_dokumen = $post['fno_dokumen'];
    $pic = $CI->session->userdata('nama_user');
    $time = date("d-m-Y h:i:sa");
    $msg = strtoupper($pesan);
    if ($status == 'approved') {
        $stat = 'DISETUJUI';
    } elseif ($status == 'rejected') {
        $stat = 'DITOLAK';
    } else {
        $stat = 'DISELESAIKAN';
    }
    // create curl resource 
    $ch = curl_init();
    $txt = urlencode("LOG : $msg \nNO DOKUMEN : $no_dokumen \n$stat OLEH : $pic \nWAKTU : $time");
    $TOKEN = "6259502863:AAEsTD1linSz1FbX4Hs7SH5U238u_ftIRZU";
    $apiURL = "https://api.telegram.org/bot$TOKEN";
    // set url 
    curl_setopt($ch, CURLOPT_URL, $apiURL . "/sendmessage?chat_id=$chat_id/&text=$txt");
    //return the transfer as a string 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // $output contains the output string 
    $output = curl_exec($ch);
    // close curl resource to free up system resources 
    curl_close($ch);
}
function telegram_notif_pengajuan_keuangan($post)
{
    $CI = get_instance();
    $CI->load->model('Users_m');
    $CI->load->model('Kasbon_m');
    $no_dok = $post['fno_dokumen'];
    $time = date("d-m-Y h:i:sa");
    $kasbon = $CI->Kasbon_m->get_by_no_dokumen($no_dok);
    $admin = $CI->Users_m->get_chat_id_administrator();
    $nominal = rupiah($kasbon->nominal);
    $kategori = strtoupper($kasbon->kategori_keuangan);
    $user = strtoupper($kasbon->nama_user);
    $note = strtoupper($kasbon->note);
    $ch = curl_init();


    $txt = urlencode("LOG : PENGAJUAN KEUANGAN \nNO DOKUMEN : $kasbon->no_dokumen \nCREATED BY : $user \nKATEGORI : $kategori \nNOMINAL : $nominal \nWAKTU : $time \nNOTE : $note \n\n INFO LEBIH LANJUT : https://gas.gisaka.net/");
    $TOKEN = "6259502863:AAEsTD1linSz1FbX4Hs7SH5U238u_ftIRZU";
    $apiURL = "https://api.telegram.org/bot$TOKEN";

    foreach ($admin as $key) {
        curl_setopt($ch, CURLOPT_URL, $apiURL . "/sendmessage?chat_id=$key->chat_id/&text=$txt");
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // close curl resource to free up system resources 
        curl_close($ch);
    }
}
function telegram_notif_registrasi_pelanggan($post)
{
    $CI = get_instance();
    $CI->load->model('Users_m');
    $CI->load->model('Registrasi_m');
    $nomor_identitas = $post['fnomor_identitas'];
    $time = date("d-m-Y h:i:sa");
    $plg = $CI->Registrasi_m->get_by_nomor_identitas($nomor_identitas);
    $admin = $CI->Users_m->get_chat_id_administrator();
    $no_regis = $plg->nomor_registrasi;
    $pelanggan = strtoupper($plg->nama_lengkap);
    $alamat = strtoupper($plg->alamat_identitas);
    $id_regis = encrypt_url($plg->id_registrasi_customer);
    $ch = curl_init();


    $txt = urlencode("LOG : REGISTRASI PELANGGAN \nNO REGISTRASI : $no_regis \nPELANGGAN : $pelanggan  \nNO IDENTITAS : $nomor_identitas \nAlamat : $alamat  \nWAKTU : $time \n\n INFO LEBIH LANJUT : https://gas.gisaka.net/customer/detail_registrasi/$id_regis");
    $TOKEN = "6259502863:AAEsTD1linSz1FbX4Hs7SH5U238u_ftIRZU";
    $apiURL = "https://api.telegram.org/bot$TOKEN";

    foreach ($admin as $key) {
        curl_setopt($ch, CURLOPT_URL, $apiURL . "/sendmessage?chat_id=$key->chat_id/&text=$txt");
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $output contains the output string 
        $output = curl_exec($ch);
        // close curl resource to free up system resources 
        curl_close($ch);
    }
}
