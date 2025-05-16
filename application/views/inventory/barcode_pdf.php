<?php
$pdf = new FPDF('l', 'mm', array(50, 20));
// membuat halaman baru
$pdf->AddPage();
$pdf->SetTitle("BARCODE ", 1);

// setting jenis font yang akan digunakan
// mencetak string 
$pdf->SetFont('Arial', 'B', 8);
$pdf->Text(10, 4, $data->nama_tipe);
$pdf->Image(base_url() . "assets/images/logogisaka-90.png", 2, 1.5, 7, 0, 'PNG');
require 'vendor/autoload.php';
$generator = new Picqer\Barcode\BarcodeGeneratorPNG();
$pdf->Image("data:image/png;base64," . base64_encode($generator->getBarcode($id, $generator::TYPE_EAN_13)), 10, 5, 37, 10, 'PNG');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Text(10, 18, $id);
$pdf->Output('', "BARCODE");
