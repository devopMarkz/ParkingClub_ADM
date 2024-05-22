<?php
session_start();
$email = $_SESSION['email'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar ao banco de dados
    $conn = mysqli_connect("localhost", "root", "aluno", "parkingClub");

    // Verificar conexão
    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }

    // Capturar dados do formulário
    $dataInicial = $_POST["data-inicial"];
    $dataFinal = $_POST["data-final"];

    // Formatando as datas no formato correto (YYYY-MM-DD HH:MM:SS)
    $dataInicialFormatada = date('Y-m-d H:i:s', strtotime($dataInicial));
    $dataFinalFormatada = date('Y-m-d H:i:s', strtotime($dataFinal));

    // Consulta SQL para selecionar dados da tabela RegistroEntradaSaida e unir com Usuarios para obter o nome do usuário
    $sql = "SELECT Usuarios.nome, RegistroEntradaSaida.data_entrada, RegistroEntradaSaida.data_saida, RegistroEntradaSaida.valor_pago
            FROM RegistroEntradaSaida
            INNER JOIN Usuarios ON RegistroEntradaSaida.usuario_id = Usuarios.usuario_id
            WHERE RegistroEntradaSaida.data_entrada >= ? AND RegistroEntradaSaida.data_saida <= ?";

    // Preparar a consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $dataInicialFormatada, $dataFinalFormatada);
    $stmt->execute();
    $resultado = $stmt->get_result();

    // Consulta SQL para obter lucro total por mês
    $sqlLucro = "SELECT SUM(valor_pago) AS lucro, MONTH(data_saida) AS mes
            FROM RegistroEntradaSaida
            WHERE data_saida BETWEEN ? AND ?
            GROUP BY MONTH(data_saida)";
    
    // Preparar a consulta de lucro
    $stmtLucro = $conn->prepare($sqlLucro);
    $stmtLucro->bind_param("ss", $dataInicialFormatada, $dataFinalFormatada);
    $stmtLucro->execute();
    $resultadoLucro = $stmtLucro->get_result();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/media.css">
    <link rel="stylesheet" href="./cliente.css">
    <link rel="stylesheet" href="./relatorio.css">
    <title>Relatórios</title>
    <style>
        body {
            color: white;
        }
        .tabela-relatorio th, .tabela-relatorio td {
            color: white;
        }
        canvas {
            background-color: #333;
        }
    </style>
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
                    <a href="http://localhost/seminarioTematico_ParkingClub-ADM/telaCliente/relatorio.php" style="text-decoration: none; color: white;">Reserva</a>
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
        <h1> Relatórios de Entrada e Saída </h1>
        <section>
            <div class="tabela-e-grafico">
                <div class="formulario-e-tabela">
                    <section>
                        <form action="relatorio.php" method="post" class="principal-form">
                            <input type="datetime-local" name="data-inicial" id="data-inicial" class="inputStyle" required style="text-align: center;">
                            <label for="data-inicial" class="labelInput"></label>

                            <input type="datetime-local" name="data-final" id="data-final" class="inputStyle" required style="text-align: center;">
                            <label for="data-final" class="labelInput"></label>

                            <input type="submit" value="Buscar" class="inputStyle">
                        </form>
                    </section>
                    <table class="tabela-relatorio" border="1">
                        <tr>
                            <th>Usuário</th>
                            <th>Data Entrada</th>
                            <th>Data Saída</th>
                            <th>Valor Pago</th>
                        </tr>
                        <?php
                        if (isset($resultado) && mysqli_num_rows($resultado) > 0) {
                            while ($linha = mysqli_fetch_array($resultado)) {
                                echo "
                                <tr>
                                    <td>"  . htmlspecialchars($linha["nome"], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td>"  . htmlspecialchars($linha["data_entrada"], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td>"  . htmlspecialchars($linha["data_saida"], ENT_QUOTES, 'UTF-8') . "</td>
                                    <td>R$ " . htmlspecialchars($linha["valor_pago"], ENT_QUOTES, 'UTF-8') . "</td>
                                </tr>";
                            }
                        } else if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            echo "<tr><td colspan='4'>Nenhum registro encontrado</td></tr>";
                        }
                        ?>
                    </table>
                </div>
                <section>
                    <!-- Gráfico de barras -->
                    <canvas id="myChart" width="400" height="400"></canvas>
                </section>
            </div>
        </section>
    </main>
    <script src="./validarFormularioReservaVaga.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dados para o gráfico
        var meses = [];
        var lucros = [];

        <?php
        if (isset($resultadoLucro) && mysqli_num_rows($resultadoLucro) > 0) {
            while ($linhaLucro = mysqli_fetch_array($resultadoLucro)) {
                echo "meses.push('" . $linhaLucro["mes"] . "');";
                echo "lucros.push(" . $linhaLucro["lucro"] . ");";
            }
        }
        ?>

        // Criando o gráfico
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Lucro por Mês',
                    data: lucros,
                    backgroundColor: 'white',
                    borderColor: 'white',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: 'white' // Cor das labels do eixo Y
                        }
                    },
                    x: {
                        ticks: {
                            color: 'white' // Cor das labels do eixo X
                        }
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            color: 'white' // Cor da legenda
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
