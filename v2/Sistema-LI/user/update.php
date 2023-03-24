<?php
include_once '../modules/security.php';
include_once '../modules/conexion.php';
include_once '../modules/notif_info_msgbox.php';

require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$_POST['txtuserid'] = trim($_POST['txtuserid']);

if (empty($_POST['txtuserid'])) {
	header('Location: /');
	exit();
}
if ($_POST['txtuserid'] == '') {
	Error('Ingrese un ID correcto.');
	header('Location: /modules/emprendedor');
	exit();
}

// Codigo para llamar al rol de la tabla users

$sql = "SELECT rol FROM users WHERE user = '" . $_POST['txtuserid'] . "'";
if ($result = $conexion->query($sql)) {
    if ($row = mysqli_fetch_array($result)) {
        $rol = $row['rol'];
    } else {
        Error('Este usuario no existe.');
        header('Location: /user');
        exit();
    }
} else {
    Error('Error al obtener datos del usuario.');
    header('Location: /user');
    exit();
}

//Actualizar emprendedor:

if ($rol == 'empre') { 
    $sql = "SELECT * FROM emprendedor WHERE user = '" . $_POST['txtuserid'] . "'";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		$date = date('Y-m-d H:i:s');
	
		$sql_update = "UPDATE emprendedor SET name = '" . trim($_POST['txtname']) . "', surnames = '" . trim($_POST['txtsurnames']) . "', cedula = '" . trim($_POST['txtcurp']) . "', address = '" . trim($_POST['txtrfc']) . "', date_of_birth = '" . trim($_POST['dateofbirth']) . "', gender = '" . trim($_POST['selectGender']) . "', phone = '" . trim($_POST['txtphone']) . "', email = '" . trim($_POST['txtaddress']) . "', pass = '" . trim($_POST['txtpass']) . "', updated_at = '" . $date . "' WHERE user = '" . trim($_POST['txtuserid']) . "'";

		if (mysqli_query($conexion, $sql_update))
			$sql_update = "UPDATE users SET name = '" . trim($_POST['txtname']) . "', surnames = '" . trim($_POST['txtsurnames']) . "', email = '" . trim($_POST['txtaddress']) . "', pass = '" . trim($_POST['txtpass']) . "' WHERE user = '" . trim($_POST['txtuserid']) . "'";

		if (mysqli_query($conexion, $sql_update)) {
			Info('Emprendedor actualizado.');
		} else {
			Error('Error al actualizar.');
		}
		
		header('Location: /user');
		exit();
	} else {
		Error('Este ID de emprendedor no existe.');
		header('Location: /user');
		exit();
	}

    }


//Actualizar estudiante:

} elseif ($rol == 'student') { 
    $sql = "SELECT * FROM students WHERE user = '" . $_POST['txtuserid'] . "'";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		$date = date('Y-m-d H:i:s');
	
		$sql_update = "UPDATE students SET name = '" . trim($_POST['txtname']) . "', surnames = '" . trim($_POST['txtsurnames']) ."', email = '" . trim($_POST['txtemailupdate']). "', cedula = '" . trim($_POST['txtcedula']) . "', pass = '" . trim($_POST['txtpass']) . "', id = '" . trim($_POST['txtid']) . "', date_of_birth = '" . trim($_POST['dateofbirth']) . "', sede = '" . trim($_POST['selectSede']) . "', phone = '" . trim($_POST['txtphone']) . "', address = '" . trim($_POST['txtaddress']) . "', career = '" . trim($_POST['selectCareer']) . "', documentation = '" . trim($_POST['selectDocumentation']) . "', admission_date = '" . trim($_POST['dateadmission']) . "', updated_at = '" . $date . "' WHERE user = '" . trim($_POST['txtuserid']) . "'";

		if (mysqli_query($conexion, $sql_update))
			$sql_update = "UPDATE users SET name ='" . trim($_POST['txtname']) . "', surnames = '" . trim($_POST['txtsurnames']) ."', email = '" . trim($_POST['txtemailupdate']). "', pass = '" . trim($_POST['txtpass']) . "', updated_at = '" . $date . "' WHERE user = '" . trim($_POST['txtuserid']) . "'";

		if (mysqli_query($conexion, $sql_update)) {
			Info('Alumno actualizado.');
		} else {
			Error('Error al actualizar.');
		}
		
		header('Location: /user');
		exit();
	} else {
		Error('Este ID de alumno no existe.');
		header('Location: /user');
		exit();
	}
}

//Poner teacher, editor y admin:

} else {
    Error('Este usuario no tiene un rol válido.');
    header('Location: /user');
    exit();
}