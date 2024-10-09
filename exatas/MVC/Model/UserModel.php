<?php
    
class usuarioModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function criarUser($nome_completo, $nome_usuario, $datadenascimento, $cpf, $genero, $phone, $email, $senha, $tipo_funcionario, $cep, $cidade, $rua, $numero, $complemento, $hora_entrada, $hora_saida, $carga_horaria, $remuneracao, $data_contratacao, $foto_perfil)
    {
        $sql = "INSERT INTO usuarios (nome_completo, nome_usuario, datadenascimento, cpf, genero, phone, email, senha, tipo_funcionario, cep, cidade, rua, numero, complemento, hora_entrada, hora_saida, carga_horaria, remuneracao, data_contratacao, foto_perfil)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome_completo, $nome_usuario, $datadenascimento, $cpf, $genero, $phone, $email, $senha, $tipo_funcionario, $cep, $cidade, $rua, $numero, $complemento, $hora_entrada, $hora_saida, $carga_horaria, $remuneracao, $data_contratacao, $foto_perfil]);
    }



    public function listarUsers()
    {
        $sql = "SELECT * FROM usuarios";    
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchALL(PDO::FETCH_ASSOC);
    }


    public function
    atualizarUser(
    $id_user,
    $nome_completo,
    $nome_usuario,
    $datadenascimento,
    $cpf,
    $genero,
    $phone,
    $email,
    $senha,
    $tipo_funcionario,
    $cep,
    $cidade,
    $rua,
    $numero,
    $complemento,
    $hora_entrada,
    $hora_saida, 
    $carga_horaria, 
    $remuneracao, 
    $data_contratacao,
    $foto_perfil
    ) {
        $sql = "UPDATE usuarios SET nome_completo = ?, nome_usuario = ?, datadenascimento = ?, cpf = ?, genero = ?, phone = ?, email = ?, senha = ?, tipo_funcionario = ?, cep = ?, cidade = ?, rua = ?, numero = ?, complemento = ?, hora_entrada = ?, hora_saida = ?, carga_horaria = ?, remuneracao = ?, data_contratacao = ?, foto_perfil = ?)
    WHERE id_user = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome_completo, $nome_usuario, $datadenascimento, $cpf, $genero, $phone, $email, $senha, $tipo_funcionario, $cep, $cidade, $rua, $numero, $complemento, $hora_entrada, $hora_saida, $carga_horaria, $remuneracao, $data_contratacao, $foto_perfil, $id_user]);
    }


 
    public function deletarUser($id_user)
    {
        $sql = "DELETE FROM usuarios WHERE id_user = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id_user]);
    }
}