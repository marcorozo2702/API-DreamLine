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

    class Jogador extends REST_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('Jogador_model');
            $this->load->model('Time_model');

        }

        public function index_get() {
            $id = (int) $this->get('id');
            if($id <= 0) {
                $data = $this->Jogador_model->get();
            } else {
                $data = $this->Jogador_model->getOne($id);
            }
            $this->set_response($data, REST_Controller_Definitions::HTTP_OK);
        }

        public function index_post() {
            if ((!$this->post('nome')) || (!$this->post('rating')) || (!$this->post('kill')) || (!$this->post('death')) || (!$this->post('cd_time'))) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'nome' => $this->post('nome'),
                'rating' => $this->post('rating'),
                'kill' => $this->post('kill'),
                'death' => $this->post('death'),
                'cd_time' => $this->post('cd_time')
            );
            if ($this->Jogador_model->insert($data)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Jogador inserido!'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao inserir Jogador'
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
            if ($this->Jogador_model->delete($id)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Jogador deletado!'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao deletar Jogador'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }

        public function index_put() {
            $id = (int) $this->get('id');
            if ((!$this->put('nome')) || (!$this->put('rating')) || (!$this->put('kill')) || (!$this->put('death')) || (!$this->put('cd_time')) || ($id <= 0)) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'nome' => $this->put('nome'),
                'rating' => $this->put('rating'),
                'kill' => $this->put('kill'),
                'death' => $this->put('death'),
                'cd_time' => $this->put('cd_time')
            );
            if ($this->Jogador_model->update($id, $data)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Jogador alterado!'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao alterar Jogador'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }



    }