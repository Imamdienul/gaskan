<?php
function cek_status_pembelian($no_pembelian, $status)
{
    $CI = get_instance();
    $CI->load->model('Status_pembelian_m');
    $data = $CI->Status_pembelian_m->cek_status($no_pembelian, $status);
    if (!$data) {
        return 0;
    } else {
        return 1;
    }
}

function cek_status_terakhir_pembelian($no_pembelian)
{
    // Get a reference to the controller object
    $CI = get_instance();

    // You may need to load the model if it hasn't been pre-loaded
    $CI->load->model('Status_pembelian_m');

    // Call a function of the model
    $data = $CI->Status_pembelian_m->cek_status_terkahir($no_pembelian);
    return $data;
}
