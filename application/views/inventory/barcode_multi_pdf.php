<?php
$pdf = new FPDF('l', 'mm', array(30, 20));
// membuat halaman baru
foreach ($data as $key) {
    $pdf->AddPage();
    $pdf->SetTitle("BARCODE ", 1);
    $pdf->SetFont('Arial', 'B', 5);
    $pdf->Text(1, 2.5, $key->nama_tipe);
    $pdf->Text(1, 5, $key->serial_number);
    $pdf->Image(base_url() . "assets/images/logogisaka-90.png", 1,  6, 4, 0, 'PNG');
    require 'vendor/autoload.php';
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    $pdf->Image("data:image/png;base64," . base64_encode($generator->getBarcode($key->nomor_registrasi, $generator::TYPE_EAN_13)), 5, 6, 23.5, 10, 'PNG');
    $pdf->SetFont('Arial', 'B', 7);
    $pdf->Text(9, 18.5, $key->nomor_registrasi);
}

$pdf->Output('', "BARCODE");
