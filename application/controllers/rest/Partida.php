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

    class Partida extends REST_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('Partida_model');
        }

        public function index_get() {
            $id = (int) $this->get('id');
            if($id <= 0) {
                $data = $this->Partida_model->get();
            } else {
                $data = $this->Partida_model->getOne($id);
            }
            $this->set_response($data, REST_Controller_Definitions::HTTP_OK);
        }

        public function index_post() {
            if ((!$this->post('data')) || (!$this->post('cd_time1')) || (!$this->post('cd_time2')) || (!$this->post('cd_rodada'))) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'data' => $this->post('data'),
                'cd_time1' => $this->post('cd_time1'),
                'cd_time2' => $this->post('cd_time2'),
                'cd_rodada' => $this->post('cd_rodada'),


            );
            if ($this->Partida_model->insert($data)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Partida inserida.'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao inserir partida'
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
            if ($this->Partida_model->delete($id)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Partida cancelada!'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao deletar Partida'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }

        public function index_put() {
            $id = (int) $this->get('id');
            if ((!$this->put('data')) || (!$this->put('cd_time1')) || (!$this->put('cd_time2')) || (!$this->put('cd_rodada')) || ($id <= 0)) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'data' => $this->put('data'),
                'cd_time1' => $this->put('cd_time1'),
                'cd_time2' => $this->put('cd_time2'),
                'cd_rodada' => $this->put('cd_rodada'),


            );
            if ($this->Partida_model->update($id, $data)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Partida atualizada!'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao atualizar Partida'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }
    
    
    
    }


    ?>