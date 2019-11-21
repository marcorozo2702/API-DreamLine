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

    class Usuario extends REST_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('Usuario_model');
        }

        public function index_get() {
            $id = (int) $this->get('id');
            if($id <= 0) {
                $data = $this->Usuario_model->get();
            } else {
                $data = $this->Usuario_model->getOne($id);
            }
            $this->set_response($data, REST_Controller_Definitions::HTTP_OK);
        }

        

        public function index_post() {
            if ((!$this->post('nome')) || (!$this->post('email')) || (!$this->post('senha'))) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'nome' => $this->post('nome'),
                'email' => $this->post('email'),
                'senha' => $this->post('senha')
            );
            if ($this->Usuario_model->insert($data)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Usuário inserido!'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao inserir Usuário'
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
            if ($this->Usuario_model->delete($id)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Usuário deletado!'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao deletar Usuário'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }

        public function index_put() {
            $id = (int) $this->get('id');
            if ((!$this->put('nome')) || (!$this->put('email')) || (!$this->put('senha')) || ($id <= 0)) {
                $this->set_response([
                    'status' => false,
                    'error' => 'Campo não preenchidos'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                return;
            }
            $data = array(
                'nome' => $this->put('nome'),
                'email' => $this->put('email'),
                'senha' => $this->put('senha')
            );
            if ($this->Usuario_model->update($id, $data)) {
                $this->set_response([
                    'status' => true,
                    'message' => 'Usuaário alterado!'
                        ], REST_Controller_Definitions::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => false,
                    'error' => 'Falha ao alterar Usuário'
                        ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
            }
        }
    }
?>