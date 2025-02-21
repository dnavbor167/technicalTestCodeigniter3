<?php
class Site_model extends CI_Model
{

    public function loginUser($data)
    {
        $this->db->select("*");
        $this->db->from("admins");
        $this->db->where("usuario", $data["username"]);
        $this->db->where("password", md5($data["password"]));

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        //Si no encuentra usuarios, retornará null
        return NULL;
    }

    public function getEmpleados()
    {
        $this->db->select("*");
        $this->db->from("empleados");
        $this->db->where("is_deleted", 0);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
        return NULL;
    }

    public function insertEmpleado()
    {
        $array = array(
            "nombre" => $this->input->post("nombre_empleado"),
            "apellido1" => $this->input->post("apellido1_empleado"),
            "apellido2" => $this->input->post("apellido2_empleado"),
            "direccion" => $this->input->post("direccion_empleado")
        );
        $this->db->insert("empleados", $array);
    }

    public function deleteEmpleado($id)
    {
        $array = array(
            "is_deleted" => 1
        );

        $this->db->where("id_empleado", $id);
        $this->db->update("empleados", $array);
    }

    public function getEmpleado($id)
    {
        return $this->db->get_where("empleados", ["id_empleado" => $id])->row();

    }

    public function updateEmpleado($id)
    {
        //Guardamos el empleado en una variable y posteriormente mirarmeos si el input se ha pasado
        //vacío, si está vacío dejaremos los datos anteriores
        $empleado = $this->db->get_where("empleados", ["id_empleado", $id])->row();

        $array = array(
            "nombre" => $this->input->post("nombre_empleado"),
            "apellido1" => $this->input->post("apellido1_empleado"),
            "apellido2" => $this->input->post("apellido2_empleado"),
            "direccion" => $this->input->post("direccion_empleado")
        );
        print_r($array);

        $this->db->where("id_empleado", $id);
        $this->db->update("empleados", $array);

        print_r($this->db->last_query());
    }
}