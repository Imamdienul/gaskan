<?php
class PDF_MC_Table extends FPDF
{
    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x, $y, $w, $h);
            // Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            // Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        // Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if (!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', (string)$txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}


$pdf = new PDF_MC_Table('l');
$pdf->AddPage();
// membuat halaman baru
$pdf->SetTitle("REKAP PENGAJUAN KEUANGAN", 1);

// setting jenis font yang akan digunakan
$pdf->SetFont('Arial', 'B', 10);
// mencetak string 

$pdf->Cell(45, 5, '', 0, 0, 'C');
$pdf->Cell(50, 5, 'REKAP PENGAJUAN KEUANGAN', 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(97, 5, '', 0, 1, 'R');
$pdf->Image(base_url() . "assets/images/logogisaka.png", 10, 8, 43, 0, 'PNG');
$pdf->Cell(45, 5, '', 0, 0, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(50, 5, 'PT. GIANDRA SAKA MEDIA', 0, 1, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(45, 5, '', 0, 0, 'C');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(29, 5, 'GISAKA MEDIA | ', 0, 0, 'L');
$pdf->SetFont('Arial', 'i', 10);
$pdf->Cell(50, 5, 'Connecting NICE Peoples! ', 0, 0, 'L');
$pdf->SetFont('Arial', '', 7);
$pdf->Cell(152, 5, 'TGL CETAK ' . date('d/m/Y'), 0, 1, 'R');
$pdf->SetLineWidth(0.4);
$pdf->Line(10, 26, 285, 26);

// WIDTH TABLE SETTING
$no = 10;
$no_dokumen = 25;
$nama = 55;
$kategori = 55;
$nominal = 25;
$tgl = 20;
$note = 65;
$status = 20;

// // TABLE HEAD
$pdf->Cell(100, 5, '', 0, 1, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(186, 6, 'KARYAWAN : ' . strtoupper($karyawan), 'TL', 0, 'L');
$pdf->Cell(89, 6, '', 'TR', 1, 'L');
$pdf->Cell(186, 6, 'PERIODE : ' . TanggalIndo($tgl_awal) . '-' . TanggalIndo($tgl_akhir), 'L', 0, 'L');
$pdf->Cell(89, 6, '', 'R', 1, 'L');
$pdf->Cell(186, 6, 'PROJECT : ' . strtoupper($project), 'LB', 0, 'L');
$pdf->Cell(89, 6, '', 'BR', 1, 'L');
$pdf->Cell(45, 5, '', 0, 1, 'C');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell($no, 8, 'NO.', 1, 0, 'C');
$pdf->Cell($no_dokumen, 8, 'NO DOKUMEN', 1, 0, 'C');
$pdf->Cell($nama, 8, 'NAMA LENGKAP', 1, 0, 'C');
$pdf->Cell($kategori, 8, 'KATEGORI', 1, 0, 'C');
$pdf->Cell($nominal, 8, 'NOMINAL', 1, 0, 'C');
$pdf->Cell($tgl, 8, 'TANGGAL', 1, 0, 'C');
$pdf->Cell($note, 8, 'NOTE', 1, 0, 'C');
$pdf->Cell($status, 8, 'STATUS', 1, 1, 'C');
$pdf->SetWidths(array($no, $no_dokumen, $nama, $kategori, $nominal, $tgl, $note, $status));
$pdf->SetFont('Arial', '', 8);



// //TABLE BODY
$nomor = 1;
foreach ($data as $key) {
    $pdf->Row(array($nomor++, strtoupper($key->no_dokumen), strtoupper($key->nama_user), strtoupper($key->kategori_keuangan), rupiah($key->nominal), TanggalIndo($key->created_date), strtoupper($key->note), strtoupper($key->status_terakhir)));
}
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell($no + $no_dokumen + $nama + $kategori, 8, 'TOTAL PENGAJUAN :', 1, 0, 'C');
$pdf->Cell($nominal + $tgl + $note + $status, 8, rupiah($total), 1, 0, 'L');


$pdf->Output('', "Rekap_pengajuan_keuangan.pdf", 'Rekap_pengajuan_keuangan.pdf');
