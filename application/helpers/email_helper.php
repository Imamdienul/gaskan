<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('send_email')) {
    function send_email($to, $subject, $message, $debug = false) {
        $CI =& get_instance();

        $CI->load->library('email');
        $CI->email->initialize();

        $CI->email->from('gas@gisaka.net', 'Gisaka Automation System');
        $CI->email->to($to);
        $CI->email->subject($subject);
        $CI->email->message($message);

        try {
            $result = $CI->email->send();
            if ($debug) {
                return [
                    'success' => $result,
                    'debug' => $CI->email->print_debugger()
                ];
            }
            return $result;
        } catch (Exception $e) {
            log_message('error', 'Email sending error: ' . $e->getMessage());
            if ($debug) {
                return [
                    'success' => false,
                    'debug' => $CI->email->print_debugger(),
                    'error' => $e->getMessage()
                ];
            }
            return false;
        }
    }
}

if (!function_exists('send_activation_email')) {
    function send_activation_email($activation_data, $customer_data) {
        $CI =& get_instance();

        $CI->load->library('email');
        $CI->load->library('pdf');
        $CI->load->model('users_m');
        $users = $CI->users_m->get_users_by_role(13);

        if (empty($users)) {
            log_message('error', 'No users with role 13 found to send activation email');
            return false;
        }

        $pdf_content = generate_activation_pdf($activation_data, $customer_data);
        $filename = 'instalasi_' . $customer_data->nama_lengkap . '_' . date('YmdHis') . '.pdf';
        $file_path = FCPATH . 'uploads/pdff/' . $filename;

        if (!is_dir(FCPATH . 'uploads/pdff/')) {
            mkdir(FCPATH . 'uploads/pdff/', 0777, true);
        }
        file_put_contents($file_path, $pdf_content);

        $CI->email->initialize();

        $CI->email->from('gas@gisaka.net', 'Gisaka Automation System');
        $to_emails = array_map(function($user) {
    return $user->email_user;
}, $users);

$CI->email->to($to_emails);


        $CI->email->subject('Notifikasi Instalasi Pelanggan: ' . $customer_data->nama_lengkap);

        $email_body = '
<html>
<body>
    <p>Dear NOC Gisaka Media</p>
    
    <p>Mohon bantuan create akun PPPOE untuk pelanggan ' . $customer_data->nama_lengkap . '.</p>
    <p>Berikut adalah data installasinya :</p>
    
    <p>Nama Pelanggan : ' . $customer_data->nama_lengkap . '<br>
    Alamat Pasang : ' . $customer_data->alamat_pemasangan . '<br>
    Nomor Hp : +' . $customer_data->whatsapp . '<br>
    Paket : ' . $activation_data->nama_paket . '<br>
    ODP : ' . $odp_data->nama_odp . ' Port : ' . $activation_data->port_odp . ' (' . $activation_data->redaman_pelanggan . ' dBm)<br>
    Panjang Kabel : ' . $activation_data->panjang_kabel . ' Meter | Nomor Roll : ' . $activation_data->nomor_roll_kabel . '<br>
    Redaman Akhir : ' . $activation_data->redaman_pelanggan . ' dBm</p>
    
    <p>MODEM : ' . $activation_data->merk_modem . ' ' . $activation_data->tipe_modem . ' | ' . $activation_data->sn_modem . ' | ' . $activation_data->mac_address . '</p>
    
    <p>Terimakasih.<br>
    Salam,<br>
    ' . $activation_data->nama_teknisi . ' (+' . $activation_data->phone_user . ')</p>
</body>
</html>';

        $CI->email->message($email_body);
        $CI->email->attach($file_path);

        $result = $CI->email->send();

        if (file_exists($file_path)) {
            unlink($file_path);
        }

        if (!$result) {
            log_message('error', 'Failed to send activation email: ' . $CI->email->print_debugger());
        }

        return $result;
    }
}

if (!function_exists('addImageToCell')) {
    function addImageToCell($pdf, $path, $cellX, $cellY, $cellW, $cellH) {
        if (file_exists($path)) {
            list($origW, $origH) = getimagesize($path);
            $ratio = min($cellW / $origW, $cellH / $origH);
            $imgW = $origW * $ratio;
            $imgH = $origH * $ratio;
            $x = $cellX + ($cellW - $imgW) / 2;
            $y = $cellY + ($cellH - $imgH) / 2;
            $pdf->Image($path, $x, $y, $imgW, $imgH);
        } else {
            $pdf->SetXY($cellX + 15, $cellY + ($cellH / 2) - 5);
            $pdf->Cell($cellW - 30, 10, 'FOTO TIDAK TERSEDIA', 0, 0, 'C');
        }
    }
}

if (!function_exists('generate_activation_pdf')) {
    function generate_activation_pdf($activation_data, $customer_data) {
        $CI =& get_instance();
        $CI->load->library('pdf');
        $CI->load->model('Instalasi_m');

        $odp_data = $CI->Instalasi_m->get_odp_by_id($activation_data->id_odp);
        $pdf = new Pdf('P', 'mm', 'A4');
        $pdf->AddPage();

        // Header with logo
        $logo_path = FCPATH . 'assets/images/logogisaka.png';
        if (file_exists($logo_path)) {
            $pdf->Image($logo_path, 10, 12, 50);
        }

        // Header text
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetXY(60, 10);
        $pdf->Cell(0, 7, 'REQUEST PPPOE / ACTIVATION', 0, 1, 'L');
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(60, 17);
        $pdf->Cell(0, 7, 'PT. GIANDRA SAKA MEDIA', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(60, 24);
        $pdf->Cell(0, 7, 'GISAKA MEDIA | Listen, Serve and Happy!', 0, 1, 'L');

        $pdf->Ln(5);

        // Main data table
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetX(10);
        $row_height = 8;
        $border = 1;

        $pdf->Cell(45, $row_height, 'TGL PASANG', $border, 0, 'L');
        $pdf->Cell(5, $row_height, ':', $border, 0, 'C');
        $pdf->Cell(140, $row_height, date('d/m/Y H:i:s', strtotime($activation_data->tgl_pasang . ' ' . $activation_data->waktu_pasang)), $border, 1, 'L');

        $pdf->Cell(45, $row_height, 'NAMA PELANGGAN', $border, 0, 'L');
        $pdf->Cell(5, $row_height, ':', $border, 0, 'C');
        $pdf->Cell(140, $row_height, $customer_data->nama_lengkap . ' | (+' . $customer_data->whatsapp . ')', $border, 1, 'L');

        // Modified address section to handle long addresses with two lines
        $pdf->Cell(45, $row_height * 2, 'ALAMAT PASANG', $border, 0, 'L');
        $pdf->Cell(5, $row_height * 2, ':', $border, 0, 'C');
        
        // Calculate the available width for the address text
        $address_width = 140;
        $address_text = $customer_data->alamat_pemasangan;
        
        // Get the current position
        $current_x = $pdf->GetX();
        $current_y = $pdf->GetY();
        
        // Create a cell with two rows height but don't output text yet
        $pdf->Cell(140, $row_height * 2, '', $border, 1, 'L');
        
        // Move back to the beginning of the cell to write the address
        $pdf->SetXY($current_x, $current_y);
        
        // Output the address as a multi-cell within the cell boundaries
        $pdf->MultiCell($address_width, $row_height, $address_text, 0, 'L');
        
        // Move to the position after the address cell
        $pdf->SetY($current_y + ($row_height * 2));

        $pdf->Cell(45, $row_height, 'PAKET', $border, 0, 'L');
        $pdf->Cell(5, $row_height, ':', $border, 0, 'C'); 
        $pdf->Cell(140, $row_height, $activation_data->nama_paket, $border, 1, 'L');

        $pdf->Cell(45, $row_height, 'PANJANG/NOMOR KABEL', $border, 0, 'L');
        $pdf->Cell(5, $row_height, ':', $border, 0, 'C');
        $pdf->Cell(140, $row_height, $activation_data->panjang_kabel . ' M | ' . $activation_data->nomor_roll_kabel, $border, 1, 'L');

        $pdf->Cell(45, $row_height, 'AREA', $border, 0, 'L');
        $pdf->Cell(5, $row_height, ':', $border, 0, 'C');
        $pdf->Cell(140, $row_height, $activation_data->nama_wilayah, $border, 1, 'L');

        $pdf->Cell(45, $row_height, 'MODEM /TIPE/SN/MAC', $border, 0, 'L');
        $pdf->Cell(5, $row_height, ':', $border, 0, 'C');
        $modem_info = $activation_data->merk_modem . ' | ' . $activation_data->tipe_modem . ' | ' . $activation_data->sn_modem . ' | ' . $activation_data->mac_address;
        $pdf->Cell(140, $row_height, $modem_info, $border, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(45, $row_height, 'ODP', $border, 0, 'L');
        $pdf->Cell(5, $row_height, ':', $border, 0, 'C');
        $odp_info = $odp_data->nama_odp . ' | Port ' . $activation_data->port_odp . ' | (' . $activation_data->redaman_pelanggan . ' dBm)';
        $pdf->Cell(140, $row_height, $odp_info, $border, 1, 'L');

        // Image section
        $img_base_path = FCPATH . 'uploads/instalasi/';
        $cell_width = 95;
        $cell_height = 50; // <<< DIKURANGI dari 65 ke 50

        $pdf->SetX(10);
        $y = $pdf->GetY();
        $pdf->Cell($cell_width, $cell_height, '', 1, 0, 'C');
        $pdf->Cell($cell_width, $cell_height, '', 1, 1, 'C');

        $img1 = !empty($activation_data->foto_koneksi_odp) ? $img_base_path . $activation_data->foto_koneksi_odp : null;
        addImageToCell($pdf, $img1, 10, $y, $cell_width, $cell_height);

        $img2 = !empty($activation_data->foto_redaman_pelanggan) ? $img_base_path . $activation_data->foto_redaman_pelanggan : null;
        addImageToCell($pdf, $img2, 10 + $cell_width, $y, $cell_width, $cell_height);

        $pdf->SetY($y + $cell_height);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell($cell_width, 5, 'INTERKONEKSI ODP', 0, 0, 'C');
        $pdf->Cell($cell_width, 5, 'REDAMAN DI RUMAH PELANGGAN -' . $activation_data->redaman_pelanggan . ' dBm', 0, 1, 'C');

        $pdf->Ln(1);

        // Second row of images
        $pdf->SetX(10);
        $y2 = $pdf->GetY();
        $pdf->Cell($cell_width, $cell_height, '', 1, 0, 'C');
        $pdf->Cell($cell_width, $cell_height, '', 1, 1, 'C');

        $img3 = !empty($activation_data->foto_instalasi) ? $img_base_path . $activation_data->foto_instalasi : null;
        addImageToCell($pdf, $img3, 10, $y2, $cell_width, $cell_height);

        $img4 = !empty($activation_data->foto_rumah) ? $img_base_path . $activation_data->foto_rumah : null;
        addImageToCell($pdf, $img4, 10 + $cell_width, $y2, $cell_width, $cell_height);

        $pdf->SetY($y2 + $cell_height);
        $pdf->Cell($cell_width, 5, 'INSTALLASI MODEM/ONT', 0, 0, 'C');
        $pdf->Cell($cell_width, 5, 'RUMAH PELANGGAN', 0, 1, 'C');

        $pdf->Ln(1);

        // Note section
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(190, 8, 'NOTE:', 1, 1, 'L');
        $pdf->SetFont('Arial', '', 9);
        if (!empty($activation_data->catatan)) {
            $pdf->MultiCell(190, 6, $activation_data->catatan, 1);
        } else {
            $pdf->Cell(190, 8, '', 1, 1, 'L');
        }

        // Signature sectionK
        $pdf->SetFont('Arial', 'B', 9);
// Baris header
$pdf->Cell(95, 8, 'NOC:', 1, 0, 'L');
$pdf->Cell(95, 8, 'REQUESTOR:', 1, 1, 'L');

// Simpan posisi sebelum membuat kotak
$yStart = $pdf->GetY();

// Kotak kosong (untuk tanda tangan)
$pdf->Cell(95, 34, '', 1, 0); // NOC
$pdf->Cell(95, 34, '', 1, 1); // Requestor

// Posisi teks di dalam kotak bagian bawah
$pdf->SetFont('Arial', '', 9);
$pdf->SetY($yStart + 22); // Geser ke bagian bawah dalam kotak (sesuaikan angka ini untuk posisi yang pas)

$pdf->Cell(95, 5, '__________________________', 0, 0, 'C'); // Garis tangan NOC
$pdf->Cell(95, 5, $activation_data->nama_teknisi . ' (' . $activation_data->phone_user . ')', 0, 1, 'C');

$pdf->Cell(95, 4, '', 0, 0, 'C');
$pdf->Cell(95, 4, $activation_data->email_user, 0, 1, 'C');


        return $pdf->Output('', 'S');
    }
}