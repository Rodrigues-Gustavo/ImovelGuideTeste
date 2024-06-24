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
    $id = $_POST["id"];
    $name = $_POST["name"];
    $cpf = $_POST["cpf"];
    $creci = $_POST["creci"];

    // Query SQL para atualizar os dados do corretor
    $sql = "UPDATE corretores SET name='$name', cpf='$cpf', creci='$creci' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "Registro atualizado com sucesso!";
    } else {
        $message = "Erro ao atualizar o registro: " . $conn->error;
    }
}

$conn->close();

// Redirecionar de volta para a página de listagem com mensagem
header("Location: form.php?message=" . urlencode($message));
exit();
?>

