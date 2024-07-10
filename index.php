<?php
// Detalhes da conexão com o banco de dados (substitua com suas credenciais reais)
$servername = "localhost";
$username = "root";
$password = "Lf01vi02";
$dbname = "numemory";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Função para incrementar o contador de downloads
function incrementDownloadCount($conn) {
  $sql = "UPDATE acessos SET numero = numero + 1 WHERE id = 1";

  if ($conn->query($sql) === TRUE) {
    return true;
  } else {
    return false;
  }
}

// Função para obter o contador de downloads
function getDownloadCount($conn) {
  $sql = "SELECT numero FROM acessos WHERE id = 1";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    return $row['numero'];
  } else {
    return 0;
  }
}

// Verifica se o botão de download foi clicado
if (isset($_GET["download"]) && $_GET["download"] == "true") {
  if (incrementDownloadCount($conn)) {
    // Fecha a conexão
    $conn->close();

    // Redireciona para o link de download (substitua com seu caminho real de download)
    header("Location: programa/Numemory.exe");
    exit();
  } else {
    echo "Erro ao incrementar o contador de downloads.";
  }
}

// Obtém o contador de downloads
$downloadCount = getDownloadCount($conn);

// Fecha a conexão
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="Logo-removebg-preview.png" type="png">
    
    <title>Numemory</title>
    <style>
      /* style.css */
      body {
          justify-content: center;
          align-items: center;
          height: 100vh;
          margin: 0;
          font-family: Arial, sans-serif;
          background-color: white;
      }

      .download-container {
          text-align: center;
      }

      .download-link {
          display: inline;
          padding: 20px 40px;
          font-size: 30px;
          width: 30vw;
          color: #fff;
          background-color: #007bff;
          text-decoration: none;
          border-radius: 10px;
          transition: background-color 0.3s ease;
      }

      .download-link:hover {
          background-color: #0056b3;
      }

      img{
        display: block;
        margin: auto;
        width: 15vw;
        text-align: center;
      }
      p{
        font-size: 1vw;
        padding: 25px;
        width: 25vw;
        padding-bottom: 15vh;
        text-align: center;
        margin: auto;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
      }
      p:nth-child(1){
        padding-top: 10vh;
        color: #FF1200;
        text-decoration: underline;
      }
    </style>
</head>
<body>
  <img src="Logo.png" alt="">
  <p>Bem-vindo ao Numemory, o app que facilita a memorização de números, seja para aprender idiomas, estudar para provas ou aprimorar sua memória!
  </p>
    <div class="download-container">
        <a href="#" class="download-link" id="download-link">BAIXAR</a>
    </div>
    <div id="download-count">
        <!-- O número de downloads será mostrado aqui -->
        <?php echo "<p>Total de downloads: $downloadCount</p>"; ?>
    </div>

    <script>
        document.getElementById('download-link').addEventListener('click', function(event) {
            event.preventDefault();
            window.location.href = '?download=true';
        });
    </script>
</body>
</html>
