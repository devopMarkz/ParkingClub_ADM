<?php
// login_usuario.php

// Verifica se os campos foram submetidos via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $email = $_POST["email"]; // Captura o email do formulário
    $senha = $_POST["senha"]; // Captura a senha do formulário

    // Conectar ao banco de dados 
    $servername = "localhost";
    $username = "root";
    $password = "aluno";
    $dbname = "parkingClub";

    // Criar conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }

    // Consulta para buscar o usuário pelo email
    $sql = "SELECT * FROM Usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se o usuário foi encontrado
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        // Verifica a senha
        // LEMBRAR DE IMPLEMENTAR: SE TIPO DE USER FOR CLIENTE COMUM, VAI PRA UMA PÁGINA, SE FOR CLIENTE FUNCIONÁRIO, VAI PRA OUTRA PÁGINA
        if ($senha === $usuario['senha']) {
            // Senha correta - fazer login
            echo "<script>alert('Usuário autenticado com sucesso!');</script>";
            header("Location: http://localhost/seminarioTematico_ParkingClub-ADM/telaCliente/cliente.php?email=$email");
            // echo('<meta http-equiv="refresh" content="0;url=http://parkingclub.com.br/telaCliente/cliente.php">');
            // Aqui você pode redirecionar o usuário para uma página protegida.
        } else {
            // Senha incorreta
            echo "<script>alert('Senha incorreta. Tente novamente!');</script>";
            echo('<meta http-equiv="refresh" content="0;url=index.html">');
        }
    } else {
        // Usuário não encontrado
        echo "<script>alert('Usuário não encontrado!');</script>";
        echo('<meta http-equiv="refresh" content="0;url=index.html">');
    }

    // Fechar conexão
    $stmt->close();
    $conn->close();
}
?>
