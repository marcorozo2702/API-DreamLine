<?php

class Equipe_model extends CI_Model {

    const table = 'tb_equipe';

    public function getOne($id) {
        if ($id > 0) {
            $this->db->select(self::table . '.*, tb_usuario.id AS id_usuario');
            $this->db->join('tb_usuario', 'tb_usuario.id = tb_equipe.cd_usuario', 'inner');
            $this->db->where(self::table. '.cd_usuario', $id);
            $query = $this->db->get(self::table);
            return $query->row(0);
        } else {
            return false;
        }
    }


    public function get() {
        $this->db->select('tb_equipe.id as id_equipe,tb_equipe.nome as nome_equipe, tb_equipe.cd_usuario, tb_usuario.nome as nome_usuario ');
        $this->db->join('tb_usuario', 'tb_usuario.id = tb_equipe.cd_usuario', 'inner');
        $query = $this->db->get(self::table);
        return $query->result();
    }
    
    public function insert($data = array()) {
        $this->db->insert(self::table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        if ($id > 0) {
            $this->db->where('id', $id);
            $this->db->delete(self::table);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

    public function update($id, $data = array()) {
        if ($id > 0) {

            $this->db->where(self::table. '.cd_usuario', $id);
            $this->db->update(self::table, $data);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }

}



?>