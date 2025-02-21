<?php
class Api_model extends CI_Model
{

    public function getEmployee() {
        $this->db->select("*");
        $this->db->from("empleados");

        $query = $this->db->get();

        if ($query->num_rows() > 0 ) {
            return $query->result();
        }

        return NULL;
    }
}