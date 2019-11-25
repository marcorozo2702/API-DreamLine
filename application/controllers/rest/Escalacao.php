<?php
    /** 
    * Implementação da API REST do projeto "DreamLine" usando a biblioteca do link abaixo
    * Essa biblioteca possui quatro arquivos distintos:
    * 1 - REST_Controller na pasta libraries, que altera o comportamento 
    *     padrão das controllers padrões do CodeIgniter
    * 2 - REST_Controller_Definition na pasta lbraries, que trata algumas 
    *     definições para o REST_Controller, trabalha como um arquivo 
    *     de padrões auxiliando o controller principal
    * 3 - Format na pasta libraries, que faz o parsing (conversão) dos
    *     diferentes tipos de dados (JASON, XML, CSV e etc)
    * 4 - rest.php na pasta config, para as configrações desta biblioteca
    *
    *
    * @author       Marco Antonio Rozo
    * @link         https://github.com/chriskacerguis/codeigniter-restserver
    *
    */ 
    use Restserver\Libraries\REST_Controller;
    use Restserver\Libraries\REST_Controller_Definitions;


    require APPPATH . '/libraries/REST_Controller.php';
    require APPPATH . '/libraries/REST_Controller_Definitions.php';
    require APPPATH . '/libraries/Format.php';

    class Escalacao extends REST_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('Escalacao_model');
            //hora padrao definida com o fuso horario de SP
            date_default_timezone_set('America/Sao_Paulo');
        }

        public function index_get() {
            $id = (int) $this->get('id');
            if($id <= 0) {
                $data = $this->Escalacao_model->get();
            } else {
                $data = $this->Escalacao_model->getOne($id);
            }
            $this->set_response($data, REST_Controller_Definitions::HTTP_OK);
        }

        public function index_post() {
            if ((!$this->post('cd_equipe')) || (!$this->post('cd_jogador')) || (!$this->post('cd_rodada'))) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'cd_equipe' => $this->post('cd_equipe'),
                'cd_jogador' => $this->post('cd_jogador'),
                'cd_rodada' => $this->post('cd_rodada'),
                'data_hora' => date('Y-m-d H:i:s')


            );
            if ($this->Escalacao_model->insert($data)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Escalação inserida.'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao inserir escalação'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }

        public function index_delete() {
            $id = (int) $this->get('id');
            if ($id <= 0) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Parâmetros obrigatórios não fornecidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            if ($this->Escalacao_model->delete($id)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Escalação deletada.'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao deletar escalação'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }

        public function index_put() {
            $id = (int) $this->get('id');
            if ((!$this->put('cd_equipe')) || (!$this->put('cd_jogador')) || (!$this->put('cd_rodada')) || ($id <= 0)) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'cd_equipe' => $this->put('cd_equipe'),
                'cd_jogador' => $this->put('cd_jogador'),
                'cd_rodada' => $this->put('cd_rodada'),
                'data_hora' => date('Y-m-d H:i:s')
            );
            if ($this->Escalacao_model->update($id, $data)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Escalação atualizada!'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao atualizar escalação'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }
    
    
    
    
    }