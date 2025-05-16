<?php
function get_total_pembelian_by_no_pembelian($no)
{

    $CI = get_instance();
    $CI->load->model('Item_pembelian_m');
    $data = $CI->Item_pembelian_m->total_pembelian_by_no_pembelian($no);
    return $data;
}