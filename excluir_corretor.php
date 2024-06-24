<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $servername = "localhost";
    $username = "root";
    $password = ""; 
    $dbname = "corretores_db";
    $port = 3306; 

    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "DELETE FROM corretores WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $message = "Corretor excluído com sucesso.";
    } else {
        $message = "Erro ao excluir corretor: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    $message = "ID do corretor não fornecido.";
}

header("Location: form.php?message=" . urlencode($message));
exit();
?>