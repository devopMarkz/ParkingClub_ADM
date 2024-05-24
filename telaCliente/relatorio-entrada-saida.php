<?php
session_start();
$email = $_SESSION['email'];

// Conectar ao banco de dados
$conn = mysqli_connect("localhost", "root", "aluno", "parkingClub");

// Verificar conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Função para deletar uma tupla
if (isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_sql = "DELETE FROM Estacionamento WHERE estacionamento_id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: relatorio-entrada-saida.php");
    exit();
}

// Consulta SQL para selecionar dados da tabela Estacionamento
$sql = "SELECT Estacionamento.estacionamento_id, Carros.placa, Usuarios.cpf, Usuarios.nome, Estacionamento.data_entrada
        FROM Estacionamento
        INNER JOIN Usuarios ON Estacionamento.usuario_id = Usuarios.usuario_id
        INNER JOIN Carros ON Estacionamento.carro_id = Carros.carro_id";
$resultado = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/media.css">
    <link rel="stylesheet" href="./cliente.css">
    <link rel="stylesheet" href="./relatorio.css">
    <title>Relatórios do Estacionamento</title>
</head>
<body>
    <header class="nav-bar">
        <nav class="nav-bar__menu">
            <details>
                <summary style="list-style: none; position: fixed; top: 30px; cursor: pointer;">
                    <img src="../componentes/images/menu-icone-cliente.svg" alt="Ícone de menu do cliente">
                </summary>
                <p style="position: relative; top: 40px; cursor: pointer;"> 
                    <a href="http://localhost/seminarioTematico_ParkingClub-ADM/telaCliente/cliente.php" style="text-decoration: none; color: white;">Menu</a>
                </p>
                <p style="position: relative; top: 45px; cursor: pointer;"> 
                    <a href="http://localhost/seminarioTematico_ParkingClub-ADM/telaCliente/relatorios.php" style="text-decoration: none; color: white;">Relatórios</a>
                </p>
            </details>
        </nav>
        <div class="nav-bar__titulo"> 
            <h1>Parking Club Admin</h1>
        </div>
        <div class="nav-bar__usuario">
            <img src="../componentes/images/user-icon-cliente.png" alt="ícone de usuário do cliente">
            <?php
                echo "<p>$email</p>";
            ?> 
        </div>
    </header>

    <main class="container-principal-adm">
        <h1> Relatórios do Estacionamento </h1>
        <section>
            <div class="tabela-e-grafico">
                <div class="formulario-e-tabela">
                    <table class="tabela-relatorio" border="1">
                        <tr>
                            <th>Placa</th>
                            <th>CPF</th>
                            <th>Nome</th>
                            <th>Data Entrada</th>
                            <th>Ação</th>
                        </tr>
                        <?php
                        if ($resultado->num_rows > 0) {
                            while ($linha = $resultado->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . htmlspecialchars($linha["placa"], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td>" . htmlspecialchars($linha["cpf"], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td>" . htmlspecialchars($linha["nome"], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td>" . htmlspecialchars($linha["data_entrada"], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td>
                                    <form method='post' action='relatorio-entrada-saida.php' style='display:inline;'>
                                    <input type='hidden' name='delete_id' value='" . $linha["estacionamento_id"] . "'>
                                        <button type='submit' style='border:none; background:none; cursor:pointer;'>
                                            <img src='../componentes/images/excluir.svg' alt='Excluir'>
                                        </button>
                                    </form>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Nenhum registro encontrado</td></tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>
        </section>
    </main>
</body>
</html>