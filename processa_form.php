<?php
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "corretores_db";
$port = 3306; 

$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $cpf = $_POST["cpf"];
    $creci = $_POST["creci"];

    $sql = "INSERT INTO corretores (name, cpf, creci) VALUES ('$name', '$cpf', '$creci')";

    if ($conn->query($sql) === TRUE) {
        $message = "Novo corretor cadastrado com sucesso!";
    } else {
        $message = "Erro ao cadastrar o corretor: " . $conn->error;
    }
}

$conn->close();

header("Location: form.php?message=" . urlencode($message));
exit();
?>

