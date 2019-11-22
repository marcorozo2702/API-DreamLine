<?php

class Login_model extends CI_Model {
    
    const table = 'tb_usuario';
    public function insert($fields) {
        $this->db->insert(self::table, $fields);
        return $this->db->insert_id();
    }
    
    public function insertApiKey($fields) {
        $this->db->insert('token', $fields);
        return $this->db->affected_rows();
    }
    
   public function get($params) {
        $this->db->select(self::table . '.*, tb_usuario.id,tb_equipe.nome as nomeequipe, token.apikey ');
        $this->db->join('token', 'token.cd_usuario=' . self::table . '.id');
        $this->db->join('tb_equipe', 'tb_equipe.cd_usuario=' . self::table . '.id');
        $query = $this->db->get_where(self::table, $params);
        return $query->row();
    }
    
    
}

?>