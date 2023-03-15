<?php
include('db.php');

require_once __DIR__ . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

if(isset($_SESSION['user_id'])){
    if($_SESSION['user_role'] == 'admin'){
        // $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
        // $date = str_replace(".", "", $date);

        if(isset($_GET['cat'])){
            // Kategori statistik
            $id = $_GET['cat'];

            // Penamaan excel
            switch($id){
                case '1': $namakategori = "html"; break;
                case '2': $namakategori = "php"; break;
                case '3': $namakategori = "javascript"; break;
                case '4': $namakategori = "java"; break;
                case '5': $namakategori = "c"; break;
                case '6': $namakategori = "cplusplus"; break;
                case '7': $namakategori = "csharp"; break;
                case '8': $namakategori = "python"; break;
            }

            // Statistik kategori
            $sql = "SELECT posts.id, users.namalengkap, users.email, users.username,
            (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes,
            (SELECT COUNT(replies.post_id) FROM replies WHERE replies.post_id = posts.id) AS TotalKomentar,
            posts.body
            FROM posts
            LEFT JOIN users ON posts.author = users.username
            WHERE posts.topic_id = $id
            GROUP BY posts.id";
        }else{
            // General statistik
            $sql = "SELECT posts.id, users.namalengkap, users.email, users.username,
            (SELECT COUNT(likes_posts.id) FROM likes_posts WHERE likes_posts.post_id = posts.id) AS TotalLikes,
            (SELECT COUNT(replies.post_id) FROM replies WHERE replies.post_id = posts.id) AS TotalKomentar,
            posts.body
            FROM posts
            LEFT JOIN users ON posts.author = users.username
            GROUP BY posts.id";
        }

        $hasil = $kunci->query($sql);
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $row = 'A';
        $col = 1;
        $header = array('No.', 'Nama Lengkap', 'Email', 'Username', 'Jumlah Like', 'Jumlah Komentar', 'Konten Postingan');

        foreach($header as $value){
            $sheet->setCellValue($row.$col, $value);
            ++$row;
        }

        while($datapost = $hasil->fetch(PDO::FETCH_ASSOC)){ 
            $row = 'A';
            $col++;
            $sheet->setCellValue($row.$col, $col - 1); ++$row;
            $sheet->setCellValue($row.$col, $datapost['namalengkap']); ++$row;
            $sheet->setCellValue($row.$col, $datapost['email']); ++$row;
            $sheet->setCellValue($row.$col, $datapost['username']); ++$row;
            $sheet->setCellValue($row.$col, $datapost['TotalLikes']); ++$row;
            $sheet->setCellValue($row.$col, $datapost['TotalKomentar']); ++$row;
            $sheet->setCellValue($row.$col, $datapost['body']); ++$row;
        }

        $writer = new Xlsx($spreadsheet);

        if(isset($_GET['cat'])){
            $filename = 'Laporanstatistik' . $namakategori . '.xlsx';
            $writer->save($filename);

            $inputFileType = 'Xlsx';
            $inputFileName = __DIR__ . '/laporanstatistik' . $namakategori . '.xlsx';

            $content = file_get_contents($filename);

        }else{
            $filename = 'LaporanStatistikGeneral.xlsx';
            $writer->save($filename);

            $content = file_get_contents($filename);

            $inputFileType = 'Xlsx';
            $inputFileName = __DIR__ . '/LaporanStatistikGeneral.xlsx';
        }

        $reader = IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($inputFileName);
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename='.$filename);
        $writer->save("php://output");
    }
}