<?php
function cek_status_kasbon($no_dokumen)
{
    // Get a reference to the controller object
    $CI = get_instance();

    // You may need to load the model if it hasn't been pre-loaded
    $CI->load->model('Status_kasbon_m');

    // Call a function of the model
    $data = $CI->Status_kasbon_m->cek_status($no_dokumen);

    if ($data > 1) {
        return 0;
    } else {
        return 1;
    }
}
function cek_status_terakhir_kasbon($no_dokumen)
{
    // Get a reference to the controller object
    $CI = get_instance();

    // You may need to load the model if it hasn't been pre-loaded
    $CI->load->model('Status_kasbon_m');

    // Call a function of the model
    $data = $CI->Status_kasbon_m->cek_status_terkahir($no_dokumen);
    return $data;
}