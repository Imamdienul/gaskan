<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//membuat format tanggal Indonesia
function TanggalIndo($date)
{
    // $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $BulanIndo = array("01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12");

    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl = substr($date, 8, 2);

    $result = $tgl . "/" . $BulanIndo[(int) $bulan - 1] . "/" . $tahun;
    return ($result);
}

//Iki helper bulan indo to SQL
function bulanindoSQL($month)
{

    $indo_month = array(
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    );

    //return $indo_month[$month];
    return array_search($month, $indo_month);
}
function bulanRomawi($month)
{
    $indo_month = array(
        'I' => '01',
        'II' => '02',
        'III' => '03',
        'IV' => '04',
        'V' => '05',
        'VI' => '06',
        'VII' => '07',
        'VIII' => '08',
        'IX' => '09',
        'X' => '10',
        'XI' => '11',
        'XII' => '12'
    );

    //return $indo_month[$month];
    return array_search($month, $indo_month);
}
function bulanindo($month)
{

    $indo_month = array(
        'Januari' => '01',
        'Februari' => '02',
        'Maret' => '03',
        'April' => '04',
        'Mei' => '05',
        'Juni' => '06',
        'Juli' => '07',
        'Agustus' => '08',
        'September' => '09',
        'Oktober' => '10',
        'November' => '11',
        'Desember' => '12'
    );

    //return $indo_month[$month];
    return array_search($month, $indo_month);
}

//Iki helper import data gae konvert format (TGL indo 24 Januari 2014 > SQL YYYY-MM-DD)
function indoSQL($date)
{
    $hari = substr($date, 0, 2);
    //$bulan = substr($date, 3, -4);
    $tahun = substr($date, -4);

    $Array_bulan = explode(" ", $date);
    $bulan = ucwords(strtolower($Array_bulan[1]));

    return $tahun . '-' . bulanindoSQL($bulan) . '-' . $hari;
}
