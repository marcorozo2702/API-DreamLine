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

    //GETS 
    public function get() {
        $this->db->select(self::table . '.*, tb_jogador.nome AS nome_jogador');
        $this->db->join('tb_jogador', 'tb_jogador.id = tb_pontuacao.cd_jogador', 'inner');
        $query = $this->db->get(self::table);
        return $query->result();
    }

    //------PEGA O ULTIMO ID DA TABELA DE RODADAS
    public function getLastId(){
        $this->db->select('tb_rodada.id');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $query = $this->db->get('tb_rodada');
        return $query->row(0);
    }

    //-------PEGA A PONTUAÇÃO POR USUARIO (PELO TOKEN PASSADO NO CABEÇALHO) DA ULTIMA RODADA
    public function getPontosRodada($token, $lastid){
        $this->db->select('tb_escalacao.cd_rodada, tb_equipe.nomeequipe, SUM(tb_pontuacao.pontos)');
        $this->db->join('tb_jogador','tb_jogador.id = tb_escalacao.cd_jogador', 'inner');
        $this->db->join('tb_equipe','tb_escalacao.cd_equipe = tb_equipe.id', 'inner');
        $this->db->join('tb_pontuacao','tb_jogador.id = tb_pontuacao.cd_jogador', 'inner');
        $this->db->join('tb_usuario','tb_usuario.id = tb_equipe.cd_usuario', 'inner');
        $this->db->join('token','token.cd_usuario = tb_usuario.id', 'inner');
        $this->db->where("token.apikey", $token);
        $this->db->where("tb_escalacao.cd_rodada", $lastid);
        $query = $this->db->get("tb_escalacao");
        return $query->row();
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