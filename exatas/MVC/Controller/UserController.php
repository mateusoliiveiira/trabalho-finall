<?php
require_once 'C:\xampp\htdocs\trabalho-finall\exatas\MVC\Model\UserModel.php';

class usuarioController
{
    private $usermodel;

    public function __construct($pdo)
    {
        $this->usermodel = new usuarioModel($pdo);
    }

    public function criarUser($nome_completo, $nome_usuario, $datadenascimento, $cpf, $genero, $phone, $email, $senha, $tipo_funcionario, $cep, $cidade, $rua, $numero, $complemento, $hora_entrada, $hora_saida, $carga_horaria, $remuneracao, $data_contratacao, $foto_perfil)
    {
        $this->usermodel->criarUser($nome_completo, $nome_usuario, $datadenascimento, $cpf, $genero, $phone, $email, $senha, $tipo_funcionario, $cep, $cidade, $rua, $numero, $complemento, $hora_entrada, $hora_saida, $carga_horaria, $remuneracao, $data_contratacao, $foto_perfil);
    }

    public function listarUsers()
    {
        return $this->usermodel->listarUsers();
    }

    public function exibirListausers()
    {
        $users = $this->usermodel->listarusers();
        include 'C:\xampp\htdocs\gestao_bikes\GB\MVC\Views\UserViews.php';
    }

    public function atualizarUser($id_user, $nome_completo,  $nome_usuario, $datadenascimento, $cpf, $genero, $phone, $email, $senha, $tipo_funcionario, $cep, $cidade, $rua, $numero, $complemento, $hora_entrada, $hora_saida, $carga_horaria, $remuneracao, $data_contratacao, $foto_perfil)
    {
        $this->usermodel->atualizarUser($id_user, $nome_completo, $nome_usuario, $datadenascimento, $cpf, $genero, $phone, $email, $senha, $tipo_funcionario, $cep, $cidade, $rua, $numero, $complemento, $hora_entrada, $hora_saida, $carga_horaria, $remuneracao, $data_contratacao, $foto_perfil);
    }

    public function deletarUser($id_user)
    {
        $this->usermodel->deletarUser($id_user);
    }
}