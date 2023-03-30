<?php
include_once '../notif_info_msgbox.php';

require_once($_SESSION['raiz'] . '/modules/sections/role-access-admin-editor.php');

$sql = "SELECT COUNT(career) AS total FROM careers";

if ($result = $conexion->query($sql)) {
	if ($row = mysqli_fetch_array($result)) {
		if ($row['total'] == 0) {
			Error('Por favor, crea como mínimo una carrera antes de agregar alumnos.');
			header('Location: /modules/careers');
			exit();
		} else {
			$sql = "SELECT COUNT(user) AS total FROM students";

			if ($result = $conexion->query($sql)) {
				if ($row = mysqli_fetch_array($result)) {
					$tpages = ceil($row['total'] / $max);
				}
			}

			if (!empty($_POST['search'])) {
				$_POST['search'] = trim($_POST['search']);
				$_POST['search'] = mysqli_real_escape_string($conexion, $_POST['search']);

				$_SESSION['user_id'] = array();

				$_SESSION['student_departamento'] = array();


				$_SESSION['student_email'] = array();

				$_SESSION['student_status'] = array();

				$_SESSION['student_jerarquia'] = array();

				$_SESSION['student_name'] = array();
				$_SESSION['student_cedula'] = array();
				$_SESSION['student_date'] = array();
				$_SESSION['student_documentation'] = array();

				$i = 0;

				$sql = "SELECT * FROM students WHERE user LIKE '%" . $_POST['search'] . "%' OR email LIKE '%". $_POST['search'] . "%' OR name LIKE '%" . $_POST['search'] . "%' OR surnames LIKE '%" . $_POST['search'] . "%' OR cedula LIKE '%" . $_POST['search'] . "%' OR admission_date LIKE '%" . $_POST['search'] . "%' OR documentation LIKE '%" . $_POST['search'] . "%' OR estado LIKE '%" . $_POST['search'] . "%' OR jerarquia LIKE '%" . $_POST['search'] . "%' OR departamento LIKE '%" . $_POST['search'] . "%' ORDER BY name";

				if ($result = $conexion->query($sql)) {
					while ($row = mysqli_fetch_array($result)) {
						$_SESSION['user_id'][$i] = $row['user'];
						$_SESSION['student_cedula'][$i] = $row['cedula'];
						$_SESSION['student_name'][$i] = $row['name'] . ' ' . $row['surnames'];
						$_SESSION['student_date'][$i] = $row['admission_date'];
						$_SESSION['student_email'][$i] = $row['email'];
						$_SESSION['student_departamento'][$i] = $row['departamento'];
						$_SESSION['student_documentation'][$i] = $row['documentation'];
						$_SESSION['student_status'][$i] = $row['estado']; 
						$_SESSION['student_jerarquia'][$i] = $row['jerarquia'];



						$i += 1;
					}
				}
				$_SESSION['total_users'] = count($_SESSION['user_id']);
			} else {
				$_SESSION['user_id'] = array();
				$_SESSION['student_name'] = array();
				$_SESSION['student_cedula'] = array();
				$_SESSION['email'] = array();
				$_SESSION['student_departamento'] = array();
				$_SESSION['student_documentation'] = array();
				$_SESSION['student_date'] = array();
				$_SESSION['student_status'] = array();
				$_SESSION['student_jerarquia'] = array();

				$i = 0;

				$sql = "SELECT * FROM students ORDER BY created_at DESC, user, name LIMIT $inicio, $max";

				if ($result = $conexion->query($sql)) {
					while ($row = mysqli_fetch_array($result)) {
						$_SESSION['user_id'][$i] = $row['user'];
						$_SESSION['student_cedula'][$i] = $row['cedula'];
						$_SESSION['student_name'][$i] = $row['name'] . ' ' . $row['surnames'];
						$_SESSION['email'][$i] = $row['email'];
						$_SESSION['student_date'][$i] = $row['admission_date'];
						$_SESSION['student_departamento'][$i] = $row['departamento'];
						$_SESSION['student_documentation'][$i] = $row['documentation'];
						$_SESSION['student_status'][$i] = $row['estado'];
						$_SESSION['student_jerarquia'][$i] = $row['jerarquia'];



						$i += 1;
					}
				}
				$_SESSION['total_users'] = count($_SESSION['user_id']);
			}
		}
	}
}

