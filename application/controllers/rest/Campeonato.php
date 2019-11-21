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


    class Campeonato extends REST_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('Campeonato_model');
        }

        public function index_get() {
            $id = (int) $this->get('id');
            if($id <= 0) {
                $data = $this->Campeonato_model->get();
            } else {
                $data = $this->Campeonato_model->getOne($id);
            }
            $this->set_response($data, REST_Controller_Definitions::HTTP_OK);
        }

        public function index_post() {
            if ((!$this->post('nome')) || (!$this->post('data'))) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'nome' => $this->post('nome'),
                'data' => $this->post('data')
            );
            if ($this->Campeonato_model->insert($data)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Campeonato cadastrado.'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao cadastrar campeonato'
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
            if ($this->Campeonato_model->delete($id)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Campeonato cancelado.'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao cancelar campeonato.'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }

        public function index_put() {
            $id = (int) $this->get('id');
            if ((!$this->put('nome')) || (!$this->put('data')) || ($id <= 0)) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'nome' => $this->put('nome'),
                'data' => $this->put('data')
            );
            if ($this->Campeonato_model->update($id, $data)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Campeonato atualizado.'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao atualizar campeonato.'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }



    }
    
    
    
    
    
    ?>