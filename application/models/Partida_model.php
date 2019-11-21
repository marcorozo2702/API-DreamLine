<?php

class Partida_model extends CI_Model {

    const table = 'tb_partida';

    public function getOne($id) {
        if ($id > 0) {
            $this->db->select(self::table . '.*, tb_rodada.nome AS nome_rodada');
            $this->db->join('tb_rodada', 'tb_rodada.id = tb_partida.cd_rodada', 'inner');
            $this->db->where(self::table. ".id", $id);
            $query = $this->db->get(self::table);
            return $query->row(0);
        } else {
            return false;
        }
    }

    public function get() {
        $this->db->select(self::table . '.*,  tb_rodada.nome AS nome_rodada');
        $this->db->join('tb_rodada', 'tb_rodada.id = tb_partida.cd_rodada', 'inner');
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

            $this->db->where(self::table. '.id', $id);
            $this->db->update(self::table, $data);
            return $this->db->affected_rows();
        } else {
            return false;
        }
    }


}