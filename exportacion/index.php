<?php
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log.txt');
ini_set('max_execution_time', 0);
ini_set("output_buffering", "off"); 
ob_implicit_flush(true);
echo "procesando archivo(espere)...";
error_reporting(E_ERROR);
if ($_GET['passwd'] != 'muymucho') {
    die('Acceso denegado');
}
session_start();
$start_time = microtime(true);
//Incluir la conexión a la base de datos y la biblioteca PHPExcel
require_once 'conexion.php';
require_once 'PHPExcel/Classes/PHPExcel.php';


// Crear nuevo objeto de PHPExcel
$objPHPExcel = new PHPExcel();

// Establecer propiedades
$objPHPExcel->getProperties()
            ->setCreator("Tu nombre")
            ->setLastModifiedBy("Tu nombre")
            ->setTitle("Archivo de Excel de Usuarios")
            ->setSubject("Usuarios")
            ->setDescription("Archivo generado automáticamente con PHP.")
            ->setKeywords("usuarios")
            ->setCategory("Usuarios");

// Establecer los campos que quieres usar
$fields = array('ID','user_login','user_pass','user_nicename','user_email','user_url','user_registered','user_activation_key','user_status','display_name','comecommerce_es');

//Establecer las queries
$query1 = "SELECT DISTINCT IzZCnWcdusers.*, IzZCnWcdusermeta.meta_value as comecommerce_es FROM IzZCnWcdusers LEFT JOIN IzZCnWcdusermeta ON IzZCnWcdusers.ID = IzZCnWcdusermeta.user_id AND IzZCnWcdusermeta.meta_key = 'comecommerce_es' WHERE IzZCnWcdusermeta.meta_value <> 'no'";
$query2 = "SELECT DISTINCT IzZCnWcdusers.*, IzZCnWcdusermeta.meta_value as comecommerce_es FROM IzZCnWcdusers LEFT JOIN IzZCnWcdusermeta ON IzZCnWcdusers.ID = IzZCnWcdusermeta.user_id AND IzZCnWcdusermeta.meta_key = 'comecommerce_es' WHERE IzZCnWcdusermeta.meta_value = 'no'";
$query3 = "SELECT IzZCnWcdusers.* FROM IzZCnWcdusers LEFT JOIN IzZCnWcdusermeta ON IzZCnWcdusers.ID = IzZCnWcdusermeta.user_id AND IzZCnWcdusermeta.meta_key = 'comecommerce_es' WHERE IzZCnWcdusermeta.meta_key IS NULL";

//Establecer el nombre de las hohojas de Excel
$sheet1 = "Comunicaciones SI";
$sheet2 = "Comunicaciones NO";


// Recorrer las hojas y las queries
for ($i = 0; $i < 2; $i++) {
// Seleccionar la hoja activa
echo "Procesando hoja " . ($i + 1) . " de 3. Tiempo transcurrido: " . round($time_elapsed, 2) . " segundos.<br>";
ob_flush();
$objPHPExcel->createSheet();
$objPHPExcel->setActiveSheetIndex($i);
$objPHPExcel->getActiveSheet()->setTitle(${"sheet" . ($i + 1)});
// Establecer los encabezados de las columnas
for ($col = 0; $col < count($fields); $col++) {
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $fields[$col]);
}

// Recorrer los resultados y agregarlos al archivo de Excel
$result = $conn->query(${"query" . ($i + 1)});
$rowNumber = 2;
while ($row = $result->fetch_assoc()) {
for ($col = 0; $col < count($fields); $col++) {
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $rowNumber, $row[$fields[$col]]);
}
$rowNumber++;
}
}
$_SESSION['end_time'] = microtime(true);
//Establecer el nombre del archivo
$filename = "usuarios.xlsx";

//Establecer el directorio donde se guardará el archivo
$filepath = "descargas/";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
//Guardar el archivo en el directorio especificado
$objWriter->save($filepath.$filename);

//Redirigir al usuario a la página de descarga
header("Location: download.php?file=".$filepath.$filename);

?>
