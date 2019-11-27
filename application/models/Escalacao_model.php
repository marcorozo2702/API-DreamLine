<?php

class Escalacao_model extends CI_Model {

    const table = 'tb_escalacao';

    public function getOne($id) {
            if ($id > 0) {
                $this->db->select(self::table . '.*,  tb_equipe.nome AS nomeequipe, tb_jogador.nome AS nomejogador,'
                .' tb_rodada.nome AS nomerodada, tb_rodada.`data` AS datarodada');
                $this->db->join('tb_equipe', 'tb_equipe.id = tb_escalacao.cd_equipe', 'inner');
                $this->db->join('tb_rodada', 'tb_rodada.id = tb_escalacao.cd_rodada', 'inner');
                $this->db->join('tb_jogador', 'tb_jogador.id = tb_escalacao.cd_jogador', 'inner');
                $this->db->where(self::table. ".id", $id);
                $query = $this->db->get(self::table);
                return $query->row(0);
            } else {
                return false;
            }
        
    }

    public function get() {
        $this->db->select(self::table . '.*,  tb_equipe.nomeequipe AS nomeequipe, tb_jogador.nome AS nomejogador,'
        .' tb_rodada.nome AS nomerodada, tb_rodada.`data` AS datarodada');
        $this->db->join('tb_equipe', 'tb_equipe.id = tb_escalacao.cd_equipe', 'inner');
        $this->db->join('tb_rodada', 'tb_rodada.id = tb_escalacao.cd_rodada', 'inner');
        $this->db->join('tb_jogador', 'tb_jogador.id = tb_escalacao.cd_jogador', 'inner');
        $query = $this->db->get(self::table);
        return $query->result();
    }

    public function get_cd_equipe($token) {
        $this->db->select('token.*, tb_usuario.id AS idusuario, tb_equipe.cd_usuario, tb_equipe.id AS idequipe');
        $this->db->join('tb_usuario', 'tb_usuario.id = token.cd_usuario', 'inner');
        $this->db->join('tb_equipe', 'tb_usuario.id=tb_equipe.cd_usuario', 'inner');
        $this->db->where("token.apikey", $token);
        $query = $this->db->get("token");
        return $query->row();
    }

    public function getLastId(){
        $this->db->select('tb_rodada.id');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('tb_rodada');
        return $query->row(0);
    }

    public function insert($data) {
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