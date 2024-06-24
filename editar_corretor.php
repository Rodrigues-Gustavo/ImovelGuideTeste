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
    $id = $_POST["id"];
    $name = $_POST["name"];
    $cpf = $_POST["cpf"];
    $creci = $_POST["creci"];

    $sql = "UPDATE corretores SET name='$name', cpf='$cpf', creci='$creci' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $message = "Registro atualizado com sucesso!";
    } else {
        $message = "Erro ao atualizar o registro: " . $conn->error;
    }
}

$conn->close();

header("Location: form.php?message=" . urlencode($message));
exit();
?>

