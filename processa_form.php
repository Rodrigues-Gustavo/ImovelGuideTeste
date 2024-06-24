<?php
// Configurações de conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = ""; // Senha vazia para XAMPP
$dbname = "corretores_db";
$port = 3306; // Porta padrão ou a porta configurada no XAMPP

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $cpf = $_POST["cpf"];
    $creci = $_POST["creci"];

    // Query SQL para inserir um novo corretor
    $sql = "INSERT INTO corretores (name, cpf, creci) VALUES ('$name', '$cpf', '$creci')";

    if ($conn->query($sql) === TRUE) {
        $message = "Novo corretor cadastrado com sucesso!";
    } else {
        $message = "Erro ao cadastrar o corretor: " . $conn->error;
    }
}

$conn->close();

// Redirecionar de volta para a página de listagem com mensagem
header("Location: form.php?message=" . urlencode($message));
exit();
?>

