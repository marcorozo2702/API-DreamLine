<?php

class Pontuacao_model extends CI_Model {

    const table = 'tb_pontuacao';

    public function getOne($id) {
        if ($id > 0) {
            $this->db->select(self::table . '.*, tb_jogador.nome AS nome_jogador');
            $this->db->join('tb_jogador', 'tb_jogador.id = tb_pontuacao.cd_jogador', 'inner');
            $this->db->where(self::table. ".id", $id);
            $query = $this->db->get(self::table);
            return $query->row(0);
        } else {
            return false;
        }
    }

    public function get() {
        $this->db->select(self::table . '.*, tb_jogador.nome AS nome_jogador');
        $this->db->join('tb_jogador', 'tb_jogador.id = tb_pontuacao.cd_jogador', 'inner');
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

?>