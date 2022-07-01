<?php

// use PhpOffice\PhpSpreadsheet\Writer\Pdf\Dompdf;
// use Dompdf\Dompdf;

require FCPATH . 'vendor/tcpdf/tcpdf.php';
$pdf = new \TCPDF();


$pdf->setPrintHeader(false);
$pdf->SetAutoPageBreak(false, 0);

// set image 1
$pdf->AddPage('P');


// -- set new background ---

// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();

$html = '<p style="font-size:12;">PENGAJUAN KEIKUTSERTAAN PEMBELAJARAN</p><br>';
$pdf->writeHTMLCell(0, 0, 10, 25, $html, 0, 0, 0, true, 'C');
$html = '<p style="font-size:12;">AGAMA KHONGHUCU</p><br>';
$pdf->writeHTMLCell(0, 0, 10, 32, $html, 0, 0, 0, true, 'C');
$htmls = '<p style="font-size:12;">KBMK UNIVERSITAS GUNADARMA</p><br>';
$pdf->writeHTMLCell(0, 0, 10, 39, $htmls, 0, 0, 0, true, 'C');

$html = '<p style="font-size:12;">Kepada Yth.</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 60, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Ketua Pengurus</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 65, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Keluarga Besar Mahasiswa Khonghucu</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 70, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Universitas Gunadarma</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 75, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Dengan hormat, saya yang bertanda tangan dibawah ini : </p><br>';
$pdf->writeHTMLCell(0, 0, 15, 85, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Nama</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 95, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Kelas</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 102, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">NPM</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 109, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">No. Telp (WA)</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 116, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Fakultas / Jurusan</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 123, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Semester</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 130, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Tahun Angkatan</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 137, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Region Kampus</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 144, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">Dengan ini mengajukan diri untuk dapat mengikuti pembelajaran Agama Khonghucu pada</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 159, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">semester terkait dengan tujuan agar dapat memenuhi kewajiban nilai pendidikan agama</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 164, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">berdasarkan <b>KRS</b> yang telah diambil. Demikian surat pengajuan ini dibuat, atas perhatian dan</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 169, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">bantuannya saya ucapkan terimakasih.</p><br>';
$pdf->writeHTMLCell(0, 0, 15, 174, $html, 0, 0, 0, true, 'L');


$html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . 'RONI' . '</p><br>';
$pdf->writeHTMLCell(0, 0, 55, 95, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . '4204' . '</p><br>';
$pdf->writeHTMLCell(0, 0, 55, 102, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . '5424124' . '</p><br>';
$pdf->writeHTMLCell(0, 0, 55, 109, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . '081614584684' . '</p><br>';
$pdf->writeHTMLCell(0, 0, 55, 116, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . 'TEKNOLOGI' . ' / ' . 'INFORMATIKA' . '</p><br>';
$pdf->writeHTMLCell(0, 0, 55, 123, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . '6' . '</p><br>';
$pdf->writeHTMLCell(0, 0, 55, 130, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . '2022' . '</p><br>';
$pdf->writeHTMLCell(0, 0, 55, 137, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">&nbsp;&nbsp; : &nbsp;&nbsp; ' . 'DEPOK' . '</p><br>';
$pdf->writeHTMLCell(0, 0, 55, 144, $html, 0, 0, 0, true, 'L');

$html = '<p style="font-size:12;">' . 'Depok, 21 June 2022' . '</p><br>';
$pdf->writeHTMLCell(100, 5, 138, 193, $html, 0, 0, 0, true, 'L');

$html = '<img src="assets/template/img/test.jpeg" width="150px" height="150px" alt="" srcset="">';
$pdf->writeHTMLCell(100, 5, 130, 200, $html, 0, 0, 0, true, 'L');


$pdf_name = '5498646' . '_' . 'RONI' . '.pdf';
$pdf->Output($pdf_name);
// $pdf->Output(FCPATH.'assets/file/pdf/'.$pdf_name.'.pdf');
// $pdf->Output(FCPATH . 'assets/PDF/' . $pdf_name . '.pdf', 'F');
return $pdf_name . '.pdf';
