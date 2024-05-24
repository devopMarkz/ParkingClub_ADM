<?php 
    session_start();
    $email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/media.css">
    <link rel="stylesheet" href="./cliente.css">
    <link rel="stylesheet" href="./relatorio.css">
    <title>Relatórios</title>
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
                    <a href="http://localhost/seminarioTematico_ParkingClub-ADM/telaCliente/relatorios.php" style="text-decoration: none; color: white;">Relatorios</a>
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
    
    <main class="container-principal-cliente">
            <div class="container-principal-cliente__fundo-cards">

                <a href="http://localhost/seminarioTematico_ParkingClub-ADM/telaCliente/relatorio.php" class="container-principal-cliente__fundo-cards__card">
                    <img src="../componentes/images/relatorio_icon.png" alt="" srcset="" style="width: 80px; height: 80px"> 
                    <p> RELATÓRIOS ENTRADA/SAÍDA </p>
                </a>

                <a href="http://localhost/seminarioTematico_ParkingClub-ADM/telaCliente/relatorio-entrada-saida.php" class="container-principal-cliente__fundo-cards__card">
                    <img src="../componentes/images/camera_icon.png" alt="" srcset="" style="width: 80px; height: 80px">
                    <p> RELATÓRIO ESTACIONAMENTO </p>
                </a>

                <a href="#" class="container-principal-cliente__fundo-cards__card">
                    <img src="../componentes/images/suporte_icon.png" alt="" srcset="" style="width: 80px; height: 80px">
                    <p> ### </p>
                </a>
                
                <a href="#" class="container-principal-cliente__fundo-cards__card">
                    <img src="../componentes/images/config_icon.png" alt="" srcset="" style="width: 80px; height: 80px">
                    <p> ### </p>
                </a>
            </div>
    </main>
    
</body>
</html>