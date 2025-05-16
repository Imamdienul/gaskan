<?php
$pdf = new FPDF('p', 'mm', 'A4');
// membuat halaman baru
$pdf->AddPage();
$pdf->SetTitle("SLIP GAJI BULAN " . strtoupper(bulanindo($bulan)) . ' ' . $tahun . ' - ' . strtoupper($selectedUser->nama_user), 1);

// setting jenis font yang akan digunakan
$pdf->SetFont('Arial', 'B', 10);
// mencetak string 
$pdf->Cell(45, 5, '', 0, 0, 'C');
$pdf->Cell(50, 5, 'SLIP GAJI', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 5, 'NO. ' . $bulan . $tahun . $selectedUser->nik, 0, 1, 'R');
$pdf->Image(base_url() . "assets/images/logogisaka.png", 10, 10, 43, 0, 'PNG');
$pdf->Cell(45, 5, '', 0, 0, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 5, 'PT. GIANDRA SAKA MEDIA', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(100, 5, 'BULAN : ' . strtoupper(bulanindo($bulan)) . ' ' . $tahun, 0, 1, 'R');
$pdf->Cell(45, 5, '', 0, 0, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(29, 5, 'GISAKA MEDIA | ', 0, 0, 'L');
$pdf->SetFont('Arial', 'i', 10);
$pdf->Cell(30, 5, 'Connecting NICE Peoples! ', 0, 1, 'L');
// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10, 10, '', 0, 1);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(35, 6, 'NIK ', 0, 0, 'L');
$pdf->Cell(5, 6, ':', 0, 0, 'L');
$pdf->Cell(5, 6, strtoupper($selectedUser->nik), 0, 1, 'L');
$pdf->Cell(35, 6, 'NAMA KARYAWAN ', 0, 0, 'L');
$pdf->Cell(5, 6, ':', 0, 0, 'L');
$pdf->Cell(5, 6, strtoupper($selectedUser->nama_user), 0, 1, 'L');
$pdf->Cell(35, 6, 'ALAMAT EMAIL ', 0, 0, 'L');
$pdf->Cell(5, 6, ':', 0, 0, 'L');
$pdf->Cell(5, 6, strtoupper($selectedUser->email_user), 0, 1, 'L');
$pdf->Cell(35, 6, 'GROUP ', 0, 0, 'L');
$pdf->Cell(5, 6, ':', 0, 0, 'L');
$pdf->Cell(5, 6, strtoupper($selectedUser->group_user), 0, 1, 'L');


$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(10, 5, '', 0, 1);
$pdf->setFillColor(230, 230, 230);
$pdf->Cell(96, 6, 'INCOME / PENDAPATAN', 1, 0, 'C', TRUE);
$pdf->Cell(96, 6, 'DEDUCTION / POTONGAN', 1, 1, 'C', TRUE);
$pdf->SetFont('Arial', '', 9);
// INCOME
$pdf->SetXY(10, 70);
foreach ($benefit as $key) {
    $pdf->Cell(55, 6, strtoupper($key->nama_benefit), 0, 0, 'l');
    $pdf->Cell(6, 6, 'RP.', 0, 0, 'L');
    $pdf->Cell(35, 6, rupiah_no_rp($key->nominal_benefit), 0, 1, 'R');
}




//DEDUCTION
$pos = 64;
foreach ($kasbon as $key) {
    $pdf->SetXY(106, $pos + 6);
    $pdf->Cell(55, 6, strtoupper($key->kategori_keuangan) . " " . TanggalIndo($key->created_date), 0, 0, 'l');
    $pdf->Cell(6, 6, 'RP.', 0, 0, 'l');
    $pdf->Cell(35, 6, rupiah_no_rp($key->nominal), 0, 1, 'R');
    $pos = $pos + 6;
}

// TOTAL INCOME & DEDUCTION
$pdf->SetXY(10, 110);
$pdf->Cell(55, 6, 'TOTAL PENDAPATAN', 'B,T', 0, 'l');
$pdf->Cell(6, 6, 'RP.', 'B,T', 0, 'L');
$pdf->Cell(35, 6, rupiah_no_rp($total_benefit), 'B,T', 1, 'R');
$pdf->SetXY(106, 110);
$pdf->Cell(55, 6, 'TOTAL POTONGAN', 'B,T', 0, 'l');
$pdf->Cell(6, 6, 'RP.', 'B,T', 0, 'l');
$pdf->Cell(35, 6, rupiah_no_rp($total_kasbon), 'B,T', 1, 'R');
// TAKE HOME
$pdf->setFillColor(
    230,
    230,
    230
);
$pdf->SetFont('Arial', 'B', 9);
$pdf->SetXY(10, 116);
$pdf->Cell(55, 6, '', 'B,T', 0, 'l', TRUE);
$pdf->Cell(6, 6, '', 'B,T', 0, 'L', TRUE);
$pdf->Cell(35, 6, '', 'B,T', 1, 'R', TRUE);
$pdf->SetXY(106, 116);
$pdf->Cell(55, 6, 'TAKE HOME', 'B,T', 0, 'l', TRUE);
$pdf->Cell(6, 6, 'RP.', 'B,T', 0, 'l', TRUE);
$pdf->Cell(35, 6, rupiah_no_rp($total_benefit - $total_kasbon), 'B,T', 1, 'R', TRUE);

// LINE
$pdf->Line(10, 70, 10, 122);
$pdf->Line(106, 70, 106, 116);
$pdf->Line(202, 70, 202, 122);

// NOTE
$pdf->SetXY(10, 123);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(55, 6, '*Dokumen ini dicetak melalui gisaka automation system pada tanggal ' . Date('d/m/Y'), 0, 0, 'l');

$pdf->output('uploads/payslip/' . $bulan . $tahun . $selectedUser->nik . '.pdf', 'F');
$pdf->Output('', "SLIP GAJI BULAN " . strtoupper(bulanindo($bulan)) . ' ' . $tahun . ' - ' . strtoupper($selectedUser->nama_user) . '.pdf');
