<?php

class Jogador_model extends CI_Model {

    const table = 'tb_jogador';

    public function getOne($id){
        if ($id > 0) {
            $this->db->select(self::table . '.*, tb_time.id AS id_time, tb_time.nome AS nome_time');
            $this->db->join('tb_time', 'tb_time.id =' . self::table . '.cd_time', 'inner');
            $this->db->where(self::table . '.id', $id);
            $query = $this->db->get(self::table);
            return $query->row(0);
        } else {
            return false;
        }
    }

    public function get(){
        $this->db->select(self::table . '.*, tb_time.id AS id_time, tb_time.nome AS nome_time');
        $this->db->join('tb_time', 'tb_time.id =' . self::table . '.cd_time', 'inner');
        $query = $this->db->get(self::table);
        return $query->result();
    }

    public function insert($data = array()){
        $this->db->insert(self::table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id){
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
            $this->db->where(self::table . '.id', $id);
            $this->db->update(self::table, $data);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }
}
