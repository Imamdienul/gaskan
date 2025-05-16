<?php


$pdf = new FPDF('p', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetTitle("SPK PELANGGAN " . $data->id_customer . " " . $data->fullname, 1);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(45, 2, '', 0, 1, 'C');
$pdf->Cell(45, 5, '', 0, 0, 'C');
$pdf->Cell(50, 5, 'SURAT PERINTAH KERJA', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(97, 5, '', 0, 1, 'R');
$pdf->Image(base_url() . "assets/images/logogisaka.png", 10, 10, 43, 0, 'PNG');
$pdf->Cell(45, 5, '', 0, 0, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 5, 'PT. GIANDRA SAKA MEDIA', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45, 5, '', 0, 0, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(29, 5, 'GISAKA MEDIA | ', 0, 0, 'L');
$pdf->SetFont('Arial', 'i', 10);
$pdf->Cell(50, 5, 'Connecting NICE Peoples! ', 0, 0, 'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(68, 5, 'NO. ' . $data->no_spk, 0, 1, 'R');
$pdf->SetLineWidth(0.4);
$pdf->Line(10, 28, 202, 28);

$pdf->Cell(68, 10, '', 0, 1, 'L');
$pdf->SetFont('Arial', '', 11);
$pdf->Cell(68, 7, 'Diberikan kepada :', 0, 1, 'L');
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 7, 'Nama lengkap', 0, 0, 'L');
$pdf->Cell(7, 7, ':', 0, 0, 'L');
$pdf->Cell(5, 7, strtoupper($data->nama_user), 0, 1, 'L');
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 7, 'No. Handphone', 0, 0, 'L');
$pdf->Cell(7, 7, ':', 0, 0, 'L');
$pdf->Cell(5, 7, strtoupper($data->phone_user), 0, 1, 'L');
$pdf->Cell(68, 5, '', 0, 1, 'L');
$pdf->Cell(68, 7, 'Untuk melaksanakan tugas sebagai berikut : ', 0, 1, 'L');
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 7, 'Jenis pekerjaan', 0, 0, 'L');
$pdf->Cell(7, 7, ':', 0, 0, 'L');
$pdf->Cell(5, 7, strtoupper($data->jenis_pekerjaan), 0, 1, 'L');
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 7, 'Tanggal ', 0, 0, 'L');
$pdf->Cell(7, 7, ':', 0, 0, 'L');
$pdf->Cell(5, 7, TanggalIndo($data->tgl_spk), 0, 1, 'L');
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 7, 'ID Pelanggan ', 0, 0, 'L');
$pdf->Cell(7, 7, ':', 0, 0, 'L');
$pdf->Cell(5, 7, strtoupper($data->id_customer), 0, 1, 'L');
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 7, 'Nama Pelanggan ', 0, 0, 'L');
$pdf->Cell(7, 7, ':', 0, 0, 'L');
$pdf->Cell(5, 7, strtoupper($data->fullname), 0, 1, 'L');
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 7, 'No. Layanan ', 0, 0, 'L');
$pdf->Cell(7, 7, ':', 0, 0, 'L');
$pdf->Cell(5, 7, strtoupper($data->no_layanan), 0, 1, 'L');
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 7, 'PIC site ', 0, 0, 'L');
$pdf->Cell(7, 7, ':', 0, 0, 'L');
$pdf->Cell(5, 7, strtoupper($data->pic_site), 0, 1, 'L');
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 7, 'No. Handphone PIC ', 0, 0, 'L');
$pdf->Cell(7, 7, ':', 0, 0, 'L');
$pdf->Cell(5, 7, strtoupper($data->telepon_pic_site), 0, 1, 'L');
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 7, 'Alamat site ', 0, 0, 'L');
$pdf->Cell(7, 7, ':', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(150, 9, strtoupper($data->alamat_site), 0, 'L');

$pdf->Cell(68, 7, 'Rincian pekerjaan : ', 0, 1, 'L');
$pdf->SetLineWidth(0.1);
$pdf->Cell(7, 7, '', 0, 0, 'L');
$pdf->Cell(40, 9, 'Uraian pekerjaan ', 0, 0, 'L');
$pdf->Cell(7, 9, ':', 0, 0, 'L');
$pdf->Cell(136, 9, '', 'B', 1, 'L');
$pdf->Cell(7, 9, '', 0, 0, 'L');
$pdf->Cell(40, 9, ' ', 0, 0, 'L');
$pdf->Cell(7, 9, '', 0, 0, 'L');
$pdf->Cell(136, 9, '', 'B', 1, 'L');

$pdf->Cell(7, 9, '', 0, 0, 'L');
$pdf->Cell(40, 9, 'Analisis ', 0, 0, 'L');
$pdf->Cell(7, 9, ':', 0, 0, 'L');
$pdf->Cell(136, 9, '', 'B', 1, 'L');

$pdf->Cell(7, 9, '', 0, 0, 'L');
$pdf->Cell(40, 9, 'Tindakan', 0, 0, 'L');
$pdf->Cell(7, 9, ':', 0, 0, 'L');
$pdf->Cell(136, 9, '', 'B', 1, 'L');

$pdf->Cell(7, 5, '', 0, 0, 'L');
$pdf->Cell(40, 5, '', 0, 0, 'L');
$pdf->Cell(7, 5, '', 0, 0, 'L');
$pdf->Cell(5, 5, '', 0, 1, 'L');

$pdf->Cell(7, 5, '', 0, 0, 'L');
$pdf->Cell(40, 5, 'Status pekerjaan', 0, 0, 'L');
$pdf->Cell(7, 5, ':', 0, 0, 'L');
$pdf->Cell(5, 5, '', 1, 0, 'L');
$pdf->Cell(20, 5, 'Selesai', 0, 0, 'L');
$pdf->Cell(5, 5, '', 1, 0, 'L');
$pdf->Cell(20, 5, 'Belum Selesai', 0, 1, 'L');
$h = $pdf->getY() + $pdf->getX();
$descriptionHeight = $h - 6;
$LineHeight = $h / 2;
if ($h - 145 < 43) {
    $ttd = $h - 145;
} else {
    $ttd = $h - 153;
}
$pdf->Cell(68, 5, '', 0, 1, 'L');
$pdf->Cell(2, 9, '', 0, 0, 'L');
$pdf->Cell(68, 7, 'Catatan :', 0, 1, 'L');
$pdf->SetLineWidth(0.1);
$pdf->Line(10, $descriptionHeight, 202, $descriptionHeight);
$pdf->Line(10, $descriptionHeight, 10, $h + 40);
$pdf->Line(10, $h + 40, 202, $h + 40);
$pdf->Line(202, $descriptionHeight, 202, $h + 40);

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(68, $ttd, '', 0, 1, 'L');
$pdf->Cell(48, 7, 'Yang memerintahkan, ', 1, 0, 'C');
$pdf->Cell(48, 7, 'Mengetahui, ', 1, 0, 'C');
$pdf->Cell(48, 7, 'Pelaksana, ', 1, 0, 'C');
$pdf->Cell(48, 7, 'Pelanggan / PIC,', 1, 1, 'C');
$pdf->Cell(48, 21, '', 1, 0, 'C');
$pdf->Cell(48, 21, '', 1, 0, 'C');
$pdf->Cell(48, 21, '', 1, 0, 'C');
$pdf->Cell(48, 21, '', 1, 1, 'C');
$pdf->SetFont('Arial', '', 8.5);
$pdf->Cell(48, 7, strtoupper(get_project_manager($data->id_project)), 1, 0, 'C');
$pdf->Cell(48, 7, '', 1, 0, 'C');
$pdf->Cell(48, 7, strtoupper($data->nama_user), 1, 0, 'C');
$pdf->Cell(48, 7, '', 1, 0, 'C');

$pdf->Output('', "SPK.pdf", 'SPK.pdf');

