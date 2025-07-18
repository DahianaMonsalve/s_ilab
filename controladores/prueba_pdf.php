<?php
require_once '../vendor/autoload.php';
use Mpdf\Mpdf;

$mpdf = new Mpdf();
$mpdf->WriteHTML('<h1 style="color: #135a72;">¡PDF operativo en Supplies iLab! :D</h1>');
$mpdf->Output();

?>
