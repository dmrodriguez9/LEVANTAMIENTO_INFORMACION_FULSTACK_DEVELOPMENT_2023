<?php
include_once '../security.php';
include_once '../conexion.php';
include_once '../notif_info_msgbox.php';


require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');


$sql_delete = "DELETE FROM infoq WHERE archivopdf = '" . $_POST['txtuserid'] . "'";

if (mysqli_query($conexion, $sql_delete)) {
	$sql_delete = "DELETE FROM infoq WHERE archivopdf = '" . $_POST['txtuserid'] . "'";

	if (mysqli_query($conexion, $sql_delete)) {
		Error('Alumno eliminado.');
	} else {
		Error('Error al eliminar.');
	}
} else {
	Error('Error al eliminar.');
}

$nombreArchivo = $_POST['txtuserid'];
$nombreArchivoEvidencia = $_POST['txtevidencefile'];

if (!empty($_POST['txtuserid'])) {

    //Elimina de la base
    $sql_delete = "DELETE FROM infoq WHERE archivopdf = '" . $nombreArchivo . "'";
    //Verifica si se borro
    if (mysqli_query($conexion, $sql_delete)) {
        Info('Entrada eliminada de la base de datos.');
    } else {
        Error('Error al eliminar la entrada de la base de datos.');
    }
    //Contruye la ruta del repo del usuario students
    $rutaArchivo = 'informesquincenalespdf/' . $_SESSION["user"] . '/' . $nombreArchivo;

    //Verifica si el archivo existe y borra 
    if (file_exists($rutaArchivo) && unlink($rutaArchivo)) {
        Info('Archivo del usuario eliminado.');
    } else {
        Error('No se pudo eliminar el archivo de evidencia en la ruta: ' . $rutaArchivo);
    }
}

    //Borra archivo y rgistro del editor
    if (!empty($_POST['txtevidencefile'])) {
        //Contruye la ruta del repo del usuario editor
        $rutaArchivoEvidencia = '../edit_send_one/informesquincenalespdf/' . $_SESSION["user"] . '/' . $nombreArchivoEvidencia;
        if (file_exists($rutaArchivoEvidencia) && unlink($rutaArchivoEvidencia)) {
            Info('Archivo del usuario eliminado.');
        } else {
            Error('No se pudo eliminar el archivo de evidencia en la ruta: ' . $rutaArchivoEvidencia);
        }
    }

header('Location: /modules/Informes_Quincenales');
exit();