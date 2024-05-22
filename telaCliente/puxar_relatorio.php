<!-- <php ?
// Dados de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "aluno";
$dbname = "parkingClub";

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Dados do formulário
    $cpf = $_POST['cpf'];
    $placa = $_POST['placa'];
    $dataHoraEntrada = $_POST['data-hora'];

    // Conectar ao banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }

    // Verificar se o número máximo de vagas foi alcançado na tabela Estacionamento
    $sql_contagem_vagas = "SELECT COUNT(*) AS total_vagas FROM Estacionamento";
    $result_contagem_vagas = $conn->query($sql_contagem_vagas);
    if ($result_contagem_vagas) {
        $row_contagem_vagas = $result_contagem_vagas->fetch_assoc();
        $total_vagas = $row_contagem_vagas["total_vagas"];
        if ($total_vagas >= 200) {
            // Número máximo de vagas alcançado, impossível reservar
            echo "<script>alert('O estacionamento está lotado. Não é possível realizar a reserva de vaga neste momento.');</script>";
            echo '<meta http-equiv="refresh" content="0;url=http://parkingclub.com.br/telaCliente/reservaVaga.php?email='.$email.'">';
            exit();
        }
    } else {
        // Mensagem de erro na contagem de vagas
        echo "<script>alert('Erro ao contar vagas no estacionamento.');</script>";
        echo '<meta http-equiv="refresh" content="0;url=http://parkingclub.com.br/telaCliente/reservaVaga.php?email='.$email.'">';
        exit();
    }

    // Verificar se a placa já está presente na tabela Estacionamento
    $sql_verificar_placa = "SELECT * FROM Estacionamento INNER JOIN Carros ON Estacionamento.carro_id = Carros.carro_id WHERE Carros.placa = '$placa'";
    $result_verificar_placa = $conn->query($sql_verificar_placa);
    if ($result_verificar_placa->num_rows > 0) {
        // Placa já existe na tabela Estacionamento
        echo "<script>alert('A placa informada já está em uso.');</script>";
        echo '<meta http-equiv="refresh" content="0;url=http://parkingclub.com.br/telaCliente/reservaVaga.php?email='.$email.'">';
        exit();
    } else {
        // Placa não existe na tabela Estacionamento, pode proceder com a reserva
        // Buscar o ID do usuário com base no CPF fornecido
        $sql = "SELECT usuario_id, email FROM Usuarios WHERE cpf = '$cpf'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $usuario_id = $row["usuario_id"];
            $email = $row["email"];

            // Inserir dados na tabela Carros
            $sql_carro = "INSERT INTO Carros (placa) VALUES ('$placa')";
            if ($conn->query($sql_carro) === TRUE) {
                $carro_id = $conn->insert_id;

                // Inserir dados na tabela Estacionamento
                $sql_estacionamento = "INSERT INTO Estacionamento (carro_id, usuario_id, data_entrada) 
                                        VALUES ($carro_id, $usuario_id, '$dataHoraEntrada')";
                if ($conn->query($sql_estacionamento) === TRUE) {
                    // Mensagem de sucesso
                    echo "<script>alert('Reserva de vaga efetuada com sucesso!');</script>";
                    echo '<meta http-equiv="refresh" content="0;url=http://parkingclub.com.br/telaCliente/efetuaPagamento.php?email='.$email.'">';
                    exit();
                } else {
                    // Mensagem de falha
                    echo "<script>alert('Erro ao inserir dados na tabela Estacionamento.');</script>";
                    echo '<meta http-equiv="refresh" content="0;url=http://parkingclub.com.br/telaCliente/reservaVaga.php?email='.$email.'">';
                    exit();
                }
            } else {
                // Mensagem de falha
                echo "<script>alert('Erro ao inserir dados na tabela Carros.');</script>";
                echo '<meta http-equiv="refresh" content="0;url=http://parkingclub.com.br/telaCliente/reservaVaga.php?email='.$email.'">';
                exit();
            }
        } else {
            // Mensagem de falha
            echo "<script>alert('Usuário não encontrado para o CPF informado.');</script>";
            echo '<meta http-equiv="refresh" content="0;url=http://parkingclub.com.br/telaCliente/reservaVaga.php?email='.$email.'">';
        }
    }

    // Fechar conexão com o banco de dados
    $conn->close();
}
?> -->