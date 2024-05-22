<?php
// Variável para controlar o redirecionamento da página
$redirect = '';

// Verifica se o formulário foi submetido usando o método POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados enviados pelo formulário
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confirmaSenha = $_POST['confirmaSenha'];
    $tipoDeUsuario = $_POST['tipo_de_usuario'];

    // Configurações de conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "aluno";
    $dbname = "parkingClub";

    // Cria a conexão com o banco de dados usando MySQLi
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão com o banco de dados
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Verifica se o CPF ou e-mail já existem na tabela Usuarios
    $query = "SELECT cpf, email FROM Usuarios WHERE cpf = ? OR email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $cpf, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o CPF ou e-mail já estão cadastrados
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['cpf'] === $cpf) {
            // Alerta caso CPF já esteja cadastrado
            $redirect = "<script>alert('CPF já cadastrado. Tente novamente!'); window.location.href = 'http://parkingclub.com.br/cadastroUsuario.html';</script>";
        } elseif ($row['email'] === $email) {
            // Alerta caso E-mail já esteja cadastrado
            $redirect = "<script>alert('E-mail já cadastrado. Tente novamente!'); window.location.href = 'http://parkingclub.com.br/cadastroUsuario.html';</script>";
        }
    } elseif ($senha !== $confirmaSenha) {
        // Alerta se a senha e confirmação de senha não coincidirem
        $redirect = "<script>alert('Senha incorreta. Tente novamente!');</script>";
    } else {
        // Insere os dados na tabela Usuarios
        $sql = "INSERT INTO Usuarios (nome, cpf, email, senha, tipo_de_usuario) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $nome, $cpf, $email, $senha, $tipoDeUsuario);

        // Executa a query de inserção
        if ($stmt->execute()) {
            // Redireciona para a página de sucesso após cadastro
            $redirect = "<script>alert('Usuário Cadastrado com Sucesso!'); window.location.href = 'index.html';</script>";
        } else {
            // Mensagem de erro em caso de falha ao cadastrar usuário
            $redirect = "<script>alert('Erro ao cadastrar usuário. Por favor, tente novamente mais tarde.'); window.location.href = 'http://parkingclub.com.br/cadastroUsuario.html';</script>";
        }
    }

    // Fecha as operações preparadas e a conexão com o banco de dados
    $stmt->close();
    $conn->close();
} else {
    // Redireciona para o formulário de cadastro se o método de requisição não for POST
    $redirect = "<script>alert('Erro de requisição. Por favor, tente novamente.'); window.location.href = 'http://parkingclub.com.br/cadastroUsuario.html';</script>";
}

// Exibe o redirecionamento ou alerta correspondente
echo $redirect;
?>