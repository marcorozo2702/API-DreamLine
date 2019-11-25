<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
use Restserver\Libraries\REST_Controller_Definitions;

require APPPATH . '/libraries/REST_Controller.php';
require APPPATH . '/libraries/REST_Controller_Definitions.php';
require APPPATH . '/libraries/Format.php';

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Login_model', 'login');
        $this->load->model('Equipe_model');

    }

    public function index() {

        $post = json_decode(file_get_contents("php://input"));

        if (empty($post->email) || empty($post->senha)) {
            $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(array('status' => false, 'error' => 'Preencha todos os camposaaaaaaa'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } else {
            $login = $this->login->get(array('email' => $post->email, 'senha' => $post->senha));
            if ($login) {
                $this->output
                        ->set_status_header(200)
                        ->set_output(json_encode(array('id' => $login->id, 'nome' => $login->nome, 'email' => $login->email,'token'=>$login->apikey, 'nomeequipe' => $login->nomeequipe), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            } else {
                $this->output
                        ->set_status_header(400)
                        ->set_output(json_encode(array('status' => false, 'error' => 'Usuário não encontrado'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }

    public function cadastro() {
        $post = json_decode(file_get_contents("php://input"));
        if (empty($post->email) || empty($post->senha) || empty($post->nome)) {
            $this->output
                    ->set_status_header(400)
                    ->set_output(json_encode(array('status' => false, 'error' => 'Preencha todos os campos'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        } else {
            $insert = $this->login->insert(array('email' => $post->email, 'senha' => $post->senha, 'nome' => $post->nome));
            if ($insert > 0) {
                $newToken = md5('salt'.$insert);
                $this->login->insertApiKey(array('cd_usuario' => $insert, 'apikey' =>$newToken));
                $this->output->set_status_header(200) ->set_output(json_encode(
                             array(
                                    'id' => '$insert',
                                    'email' => $post->email,
                                    'nome' => $post->nome,
                                    'token' =>$newToken
                                ))
                            );  

                            // if(($this->$post('nomeequipe'))){
                            //     // $this->set_response([
                            //     //         'status' => false,
                            //     //         'error' => 'Campo não preenchido'
                            //     //     ], REST_Controller_Definitions::HTTP_BAD_REQUEST);
                            //     //     return;
                            //     $this->output
                            //     ->set_status_header(400)
                            //      ->set_output(json_encode(array('status' => false, 'error' => 'Preencha todos os campos'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
        
                            // }
                            if (empty($post->nomeequipe)) {
                                $this->output
                                        ->set_status_header(400)
                                        ->set_output(json_encode(array('status' => false, 'error' => 'Preencha todos os campos'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                            }
                            $data= array(
                                'cd_usuario' => "$insert",
                                'nomeequipe' => $post->nomeequipe
                            ); 
                        if($this->Equipe_model->insert($data)){
                            $this->output
                            ->set_status_header(200)
                            ->set_output(json_encode(array('status' => true, 'error' => 'Dados de "equipe" inseridoso'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                        } else {
                            $this->output
                            ->set_status_header(400)
                            ->set_output(json_encode(array('status' => false, 'error' => 'Preencha todos os campos'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
                        }
            } else {
                $this->output
                        ->set_status_header(400)
                        ->set_output(json_encode(array('status' => false, 'error' => 'Falha no cadastro'), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            }
        }
    }

}

?>