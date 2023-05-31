<?php
session_start();
$time_elapsed = $_SESSION['end_time'] - $_SESSION['start_time'];
echo "Proceso finalizado en " . round($time_elapsed, 2) . " segundos.<br>";
//echo "<a href='archivo.xlsx'>Descargar archivo</a>"
  $file = $_GET['file'];
    header("Content-Disposition: attachment; filename=".$file);
    readfile("archivos/".$file);
?>