<?php
if (isset($_POST['id'])) {
    $id = $_POST['id'];

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

    // Query SQL para excluir o corretor
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

// Redirecionar de volta para a página de listagem com mensagem
header("Location: form.php?message=" . urlencode($message));
exit();
?>


