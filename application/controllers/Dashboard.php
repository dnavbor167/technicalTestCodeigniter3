<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function index()
	{
		//Si pasa mas de 5 minutos la sesión se cerrará
		$tiempo = time() - $_SESSION["login_tmp"];
		if (isset($_SESSION["usuario"]) && $tiempo < 300) {
			$this->session->set_userdata("login_tmp", time());
			$data['empleados'] = $this->Site_model->getEmpleados();
		} else {
			$this->session->sess_destroy();
			redirect(base_url("DashBoard/login"));
		}

		$this->loadViews("home", $data);
	}

	public function login()
	{
		if ($_POST["username"] && $_POST["password"]) {
			$login = $this->Site_model->loginUser($_POST);

			if ($login) {
				$array = array(
					"usuario" => $login[0]->usuario,
					"login_tmp" => time()
				);
				$this->session->set_userdata($array);
			}
		}
		$this->loadViews("login");
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url("DashBoard/login"));
	}

	public function eliminarEmpleado()
	{
		if (isset($_POST["idEmpleado"])) {
			$this->Site_model->deleteEmpleado($_POST["idEmpleado"]);
		}
	}

	public function agregarEmpleado()
	{

		//verificamos si se ha pasado el tiempo
		$tiempo = time() - $_SESSION["login_tmp"];
		if (!isset($_SESSION['usuario']) || $tiempo >= 300) {
			$this->session->sess_destroy();
			echo json_encode(['status' => 'error', 'message' => "Sesión Expirada"]);
			return;
		}
		//Cargamos la librería form_validation
		$this->load->library("form_validation");

		if ($_POST) {
			//Cargamos las validaciones del formulario, en este caso es que tiene que ser requerido
			$this->form_validation->set_rules('nombre_empleado', 'Nombre', 'required');
			$this->form_validation->set_rules('apellido1_empleado', 'Apellido 1', 'required');
			$this->form_validation->set_rules('apellido2_empleado', 'Apellido 2', 'required');
			$this->form_validation->set_rules('direccion_empleado', 'Dirección', 'required');

			if ($this->form_validation->run() == false) {
				echo json_encode(['status' => 'error', 'message' => validation_errors()]);
			} else {
				$this->Site_model->insertEmpleado();
				echo json_encode(['status' => 'success', 'message' => 'Empleado agregado correctamente']);
			}
		}
	}

	public function obtenerEmpleado()
	{
		if (isset($_POST["idEmpleado"])) {
			$empleado = $this->Site_model->getEmpleado($_POST["idEmpleado"]);
			if ($empleado) {
				echo json_encode(["empleado" => $empleado]);
			} else {
				echo json_encode(["error" => "Empleado no encontrado"]);
			}
		}
	}

	public function actualizarEmpleado()
	{
		//verificamos si se ha pasado el tiempo
		$tiempo = time() - $_SESSION["login_tmp"];
		if (!isset($_SESSION['usuario']) || $tiempo >= 300) {
			$this->session->sess_destroy();
			echo json_encode(['status' => 'error', 'message' => "Sesión Expirada"]);
			return;
		}

		if ($_POST) {
			$this->Site_model->updateEmpleado($_POST["idEmpleadoUpdate"]);
			echo json_encode(['status' => 'success', 'message' => "Actualizado"]);
			redirect(base_url("DashBoard"));
		} else {
			echo json_encode(['status' => 'error', 'message' => "Sin id"]);
		}
	}


	public function loadViews($view, $data = null)
	{
		//Si tenemos sessión creada
		if ($_SESSION['usuario']) {
			//si la vista es login se redirige a la home
			if ($view == "login") {
				redirect(base_url() . "DashBoard", "location");
			}
			//si es una vista cualquiera se carga
			$this->load->view('includes/header');
			$this->load->view('includes/sidebar');
			$this->load->view($view, $data);
			$this->load->view('includes/footer');
			//si no tenemos iniciada sessión
		} else {
			//si la vista es login se carga
			if ($view == "login") {
				$this->load->view($view);
				//si la vista es otra cualquiera se redirige a login
			} else {
				redirect(base_url("DashBoard/login"));
			}
		}
	}
}
