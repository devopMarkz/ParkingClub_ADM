<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/media.css">
    <link rel="stylesheet" href="./cliente.css">
    <link rel="stylesheet" href="./suporte.css">
    <title>Suoprte ao Cliente</title>
</head>
<body>
    <header class="nav-bar">

        <nav class="nav-bar__menu">
            <details>
                    <summary style="list-style: none; position: fixed; top: 30px; cursor: pointer;"><img src="../componentes/images/menu-icone-cliente.svg" alt="Ícone de menu do cliente"></summary>
                    <p style="position: relative; top: 40px"> 
                    <?php
                    // Captura o email passado como parâmetro GET na página de login e manda para a página de cliente.php
                    if (isset($_GET['email'])) {
                        $email = $_GET['email'];
                        echo "<a href='http://parkingclub.com.br/telaCliente/cliente.php?email=$email' style='text-decoration: none; color: white;'>Menu</a>";
                    }
                    ?>
                    </p>
                    <p style="position: relative; top: 45px"> 
                    <?php
                    // Captura o email passado como parâmetro GET na página de login e manda para a página de reservaVaga.php
                    if (isset($_GET['email'])) {
                        $email = $_GET['email'];
                        echo "<a href='http://parkingclub.com.br/telaCliente/reservaVaga.php?email=$email' style='text-decoration: none; color: white;'>Reserva</a>";
                    }
                    ?>
                    </p>
            </details>
        </nav>

        <div class="nav-bar__titulo"> 
            <h1>Parking Club Client</h1>
        </div>

        <div class="nav-bar__usuario">
            <img src="../componentes/images/user-icon-cliente.png" alt="" srcset="">
            <?php
            // Captura o email passado como parâmetro GET na página de login
            if (isset($_GET['email'])) {
                $email = $_GET['email'];
                echo "<p>$email</p>";
            } else {
                // Se o email não foi passado, exibir uma mensagem padrão
                echo "<p>Email não encontrado</p>";
            }
            ?> 
        </div>

    </header>

    <main class="container-principal-cliente">
        <div class="container-principal-cliente__fundo-cards suporte-videos">
            <div class="card-iframe">
                <p> Como utilizar nosso sistema </p>
                <iframe width="460" height="315" src="https://www.youtube.com/embed/xLpG6Yfr-Mo?si=uXToPMUAj6BUP4y9" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>            
            </div>
            <div class="card-iframe">
                <p> Como reservar sua vaga </p>
                <iframe width="460" height="315" src="https://www.youtube.com/embed/jcnmN1YAJiY?si=UyAdt3u1uoxI6Nx7" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>            </div>
            <div class="card-iframe">
                <p> Onde pagar sua saída </p>
                <iframe width="460" height="315" src="https://www.youtube.com/embed/FnzpP2Iwnxc?si=WOswoVmiEjkWpJts" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>            </div>

            <div class="card-iframe">
                <p> Como efetuar seu pagamento </p>
                <iframe width="460" height="315" src="https://www.youtube.com/embed/c_mUqEhSJCA" title="Saiba como pagar o Estacionamento Digital com Pix" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>               </div>
        </div>
    </main>

</body>
</html>