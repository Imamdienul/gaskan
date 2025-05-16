<?php

function rupiah($angka)
{

    $hasil_rupiah = "Rp. " . number_format($angka == null ? 0 : $angka, 0, ',', '.');
    return $hasil_rupiah;
}
function rupiah_no_rp($angka)
{

    $hasil_rupiah = number_format($angka, 0, ',', '.');
    return $hasil_rupiah;
}