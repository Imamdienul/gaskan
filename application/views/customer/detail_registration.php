<?php

$pdf = new FPDF('p', 'mm', 'legal');
// membuat halaman baru
$pdf->AddPage();
$pdf->SetTitle($data->nomor_registrasi . " - " . strtoupper($data->nama_lengkap) . " - FORMULIR BERLANGGANAN", 1);

// setting jenis font yang akan digunakan
$pdf->SetFont('Arial', 'B', 10);
// mencetak string 
$pdf->SetXY(0, 0);

$pdf->Cell(55, 5, '', 0, 1, 'C');
$pdf->Cell(55, 1, '', 0, 1, 'C');
$pdf->Cell(45, 5, '', 0, 0, 'C');
$pdf->Cell(50, 5, 'FORMULIR BERLANGGANAN', 0, 0, 't');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(97, 5, '', 0, 1, 'R');
$pdf->Image(base_url() . "assets/images/logogisaka.png", 10, 5, 43, 0, 'PNG');
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
$pdf->Cell(72, 5, 'Nomor Registrasi : ' . $data->nomor_registrasi, 0, 1, 'R');
$pdf->SetLineWidth(0.4);
$pdf->Line(10, 22, 205, 22);

// SETTING 
$line_spacing = 5.5; // Reduced from 6
$gap_titik_dua = 7;
$gap_section = 0;
$width_text = 70;
$font_size = 10;
$title_section_height = 5.5; // Reduced from 6
$pdf->Cell(68, 3, '', 0, 1, 'L'); // Reduced space
$pdf->SetFont('Arial', '', $font_size);
$pdf->Cell(70, 7, ' ' . $data->jenis_formulir, 1, 0, 'C');
$pdf->Cell(40, 7, '', 0, 0, 'L');
$pdf->Cell(30, 7, 'Nomor Layanan :', 0, 0, 'L');
$pdf->Cell(55, 7, '', 1, 1, 'L');
$pdf->Cell(68, 2, '', 0, 1, 'L'); // Reduced space

$pdf->SetFont('Arial', 'B', $font_size);

$pdf->SetFillColor(238, 238, 238);
$pdf->Cell(195, $title_section_height, ' DATA PENANGGGUNG JAWAB / PEMBAYAR TAGIHAN', 0, 1, 'L', 'true');
$pdf->SetFont('Arial', '', $font_size);
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'Nama lengkap', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(5, $line_spacing, strtoupper($data->nama_lengkap), 0, 1, 'L');
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'Tanggal Lahir', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(5, $line_spacing, TanggalIndo($data->tgl_lahir), 0, 1, 'L');
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'Jenis Kelamin', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(5, $line_spacing, strtoupper($data->jenkel), 0, 1, 'L');
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'Jenis Identitas', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(5, $line_spacing, strtoupper($data->jenis_identitas), 0, 1, 'L');
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'No. KTP / SIM / Paspor', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(5, $line_spacing, strtoupper($data->nomor_identitas), 0, 1, 'L');
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'Alamat Sesuai KTP / SIM / Paspor', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->MultiCell(115, 4, strtoupper($data->alamat_identitas), 0, 1); // Extended from 100 to 115

$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell(20, $line_spacing, 'Kode Pos', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(50, $line_spacing, strtoupper($data->kode_pos), 0, 1, 'L');
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell(20, $line_spacing, 'Whatsapp', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(50, $line_spacing, strtoupper($data->whatsapp), 0, 0, 'L');
$pdf->Cell(20, $line_spacing, 'Faksimili', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(50, $line_spacing, strtoupper($data->faksimili), 0, 1, 'L');
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell(20, $line_spacing, 'Seluler', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(50, $line_spacing, strtoupper($data->seluler), 0, 0, 'L');
$pdf->Cell(20, $line_spacing, 'Email', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(50, $line_spacing, strtoupper($data->email), 0, 1, 'L');
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell(20, $line_spacing, 'NPWP', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(50, $line_spacing, $data->nomor_npwp == null ? '-' : strtoupper($data->nomor_npwp), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $font_size);
$pdf->Cell(68, $gap_section, '', 0, 1, 'L');
$pdf->Cell(195, $title_section_height, ' KEBUTUHAN BANDWIDTH', 0, 1, 'L', 'true');
$pdf->SetFont('Arial', '', $font_size);
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'Jenis Layanan', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(5, $line_spacing, strtoupper($data->jenis_layanan), 0, 1, 'L');
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'Kebutuhan Bandwidth', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(30, $line_spacing, strtoupper($data->bandwidth), 0, 0, 'L');
$pdf->Cell(30, $line_spacing, 'Lainnya', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(5, $line_spacing, $data->bandwidth_lainnya == null ? '-' : strtoupper($data->bandwidth_lainnya), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $font_size);
$pdf->Cell(68, $gap_section, '', 0, 1, 'L');
$pdf->Cell(195, $title_section_height, ' LOKASI PEMASANGAN', 0, 1, 'L', 'true');
$pdf->SetFont('Arial', '', $font_size);
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'Alamat Pemasangan', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->MultiCell(115, 4, strtoupper($data->alamat_pemasangan), 0, 1); // Extended from 100 to 115

$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell(10, $line_spacing, 'RT', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(18, $line_spacing, strtoupper($data->rt), 0, 0, 'L');
$pdf->Cell(35, $line_spacing, 'Desa / Kelurahan', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(50, $line_spacing, strtoupper($data->desa), 0, 0, 'L');
$pdf->Cell(20, $line_spacing, 'Kecamatan', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(50, $line_spacing, strtoupper($data->kecamatan), 0, 1, 'L');

$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell(10, $line_spacing, 'RW', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(18, $line_spacing, strtoupper($data->rw), 0, 0, 'L');
$pdf->Cell(35, $line_spacing, 'Kode Pos', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(50, $line_spacing, strtoupper($data->kode_pos_pemasangan), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $font_size);
$pdf->Cell(68, $gap_section, '', 0, 1, 'L');
$pdf->Cell(195, $title_section_height, ' JANGKA WAKTU BERLANGGANAN', 0, 1, 'L', 'true');
$pdf->SetFont('Arial', '', $font_size);
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'Jangka Waktu Berlangganan', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(30, 7, strtoupper($data->jangka_waktu_berlangganan), 0, 0);

$pdf->Cell(30, $line_spacing, 'Lainnya', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(50, 7, $data->jangka_waktu_berlangganan_lainnya == null ? '-' : strtoupper($data->jangka_waktu_berlangganan_lainnya), 0, 1);
$pdf->Cell(7, $line_spacing, '', 0, 0, 'L');
$pdf->Cell($width_text, $line_spacing, 'Tanggal Pemasangan', 0, 0, 'L');
$pdf->Cell($gap_titik_dua, $line_spacing, ':', 0, 0, 'L');
$pdf->Cell(100, 7, TanggalIndo($data->tgl_pemasangan), 0, 1);
$pdf->SetFont('Arial', 'B', $font_size);
$pdf->Cell(68, $gap_section, '', 0, 1, 'L');
$pdf->Cell(195, $title_section_height, ' BIAYA SATU KALI BAYAR', 0, 1, 'L', 'true');
// SETTING TABEL
$wdeskripsi = 90;
$wbiaya = 40;
$wketerangan = 65;
$row_height = 5;
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(2, 2, '', 0, 1, 'L');
$pdf->Cell($wdeskripsi, $row_height, 'Deskripsi', 1, 0, 'C');
$pdf->Cell($wbiaya, $row_height, 'Biaya', 1, 0, 'C');
$pdf->Cell($wketerangan, $row_height, 'Keterangan', 1, 1, 'C');

$pdf->Cell($wdeskripsi, $row_height, 'Registrasi', 1, 0, 'L');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C');

$pdf->Cell($wdeskripsi, $row_height, 'Lainnya : ', 1, 0, 'L');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C');

$pdf->Cell($wdeskripsi, $row_height, 'SUB TOTAL (Rp)', 1, 0, 'L', 'true');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C', 'true');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C', 'true');

$pdf->Cell($wdeskripsi, $row_height, 'PPN 11%', 1, 0, 'L');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C');

$pdf->Cell($wdeskripsi, $row_height, 'TOTAL (Rp)', 1, 0, 'L', 'true');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C', 'true');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C', 'true');

$pdf->Cell(68, 4, '', 0, 1, 'L');
$pdf->Cell(195, $title_section_height, ' BIAYA BULANAN', 0, 1, 'L', 'true');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(2, 2, '', 0, 1, 'L');
$pdf->Cell($wdeskripsi, $row_height, 'Deskripsi', 1, 0, 'C');
$pdf->Cell($wbiaya, $row_height, 'Biaya', 1, 0, 'C');
$pdf->Cell($wketerangan, $row_height, 'Keterangan', 1, 1, 'C');

$pdf->Cell($wdeskripsi, $row_height, 'Internet Port : ', 1, 0, 'L');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C');

$pdf->Cell($wdeskripsi, $row_height, 'Akses Lokal : ', 1, 0, 'L');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C');

$pdf->Cell($wdeskripsi, $row_height, 'Lainnya : ', 1, 0, 'L');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C');

$pdf->Cell($wdeskripsi, $row_height, 'SUB TOTAL (Rp)', 1, 0, 'L', 'true');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C', 'true');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C', 'true');

$pdf->Cell($wdeskripsi, $row_height, 'PPN 11%', 1, 0, 'L');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C');

$pdf->Cell($wdeskripsi, $row_height, 'TOTAL (Rp)', 1, 0, 'L', 'true');
$pdf->Cell($wbiaya, $row_height, '', 1, 0, 'C', 'true');
$pdf->Cell($wketerangan, $row_height, '', 1, 1, 'C', 'true');
$pdf->SetFont('Arial', '', 9);

$pdf->Cell($wdeskripsi + $wbiaya + $wketerangan, $row_height, '*Biaya bulan pertama dihitung berdasarkan tanggal aktivasi', 1, 1, 'L',);
$pdf->Cell(0, 3, '', 0, 1, 'L',);
$pdf->MultiCell(195, 5, 'Dengan menandatangani formulir berlangganan ini, kami menyatakan bahwa informasi yang kami berikan adalah benar adanya dan bersedia mematuhi ketentuan dan syarat berlangganan Gisaka Media. Kami setuju untuk mengikuti Kontrak Berlangganan yang menjadi satu kesatuan dengan Formulir Pendaftaran ini. Jika pelanggan berhenti berlangganan sebelum masa kontrak habis maka akan dikenakan biaya denda/finalty sebesar nilai biaya bulanan dikalikan dengan sisa masa kontrak.', 1, 1);
$pdf->Cell(195, 5, '', 0, 1, 'L',);

$pdf->SetFont('Arial', 'B', $font_size);
$pdf->Cell(95, 3, 'Pemohon,', 0, 0, 'C',);
$pdf->Cell(5, 3, '', 0, 0, 'L',);
$pdf->Cell(95, 3, 'Gisaka Media,', 0, 1, 'C',);

$pdf->SetFont('Arial', '', 7);
$pdf->Cell(95, 18, 'Materai', 0, 0, 'C',);
$pdf->Cell(5, 18, '', 0, 0, 'L',);
$pdf->Cell(95, 18, '', 0, 1, 'C',);

$pdf->Cell(23, 4, '', 0, 0, 'C',);
$pdf->Cell(50, 4, '', 'T', 0, 'C',);
$pdf->Cell(50, 4, '', 0, 0, 'L',);
$pdf->Cell(50, 4, '', 'T', 1, 'C',);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(130, $row_height, 'DIISI OLEH PETUGAS GISAKA MEDIA', 1, 0, 'C', 'true');
$pdf->Cell(65, $row_height, 'NOTE', 1, 1, 'C', 'true');
$pdf->Cell(43, $row_height, 'PETUGAS IKR', 1, 0, 'C', 'true');
$pdf->Cell(43, $row_height, 'SALES', 1, 0, 'C', 'true');
$pdf->Cell(44, $row_height, 'KEUANGAN', 1, 0, 'C', 'true');
$pdf->Cell(65, $row_height, '', 'LR', 1, 'C');

$pdf->Cell(43, 12, '', 1, 0, 'C');
$pdf->Cell(43, 12, '', 1, 0, 'C');
$pdf->Cell(44, 12, '', 1, 0, 'C');
$pdf->Cell(65, 12, '', 'LR', 1, 'C');
$pdf->SetFont('Arial', '', 8);

$pdf->Cell(43, 5, 'Tanggal :', 1, 0, 'L');
$pdf->Cell(43, 5, 'Tanggal :', 1, 0, 'L');
$pdf->Cell(44, 5, 'Tanggal :', 1, 0, 'L');
$pdf->Cell(65, 5, '', 'LRB', 1, 'C');

$pdf->AddPage();
$pdf->SetFont('Arial', 'B', $font_size);
$pdf->Cell(68, 5, '', 0, 1, 'L');
$pdf->Cell(100, $title_section_height, ' FOTO IDENTITAS KTP / SIM / PASPOR', 0, 0, 'L', 'true');
$pdf->Cell(95, $title_section_height, 'Nomor Registrasi : ' . $data->nomor_registrasi, 0, 1, 'R', 'true');
$pdf->Image(base_url() . "uploads/registrasi/" . $data->foto_identitas, 10, 30, 100, 0);

$pdf->Output('', $data->nomor_registrasi . " - " . strtoupper($data->nama_lengkap) . " - FORMULIR BERLANGGANAN.pdf", $data->nomor_registrasi . " - " . strtoupper($data->nama_lengkap) . " - FORMULIR BERLANGGANAN.pdf");