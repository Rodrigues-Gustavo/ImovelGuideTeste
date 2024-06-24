<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Corretor</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Caixinha de mensagem -->
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['message']); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Formulário de Cadastro de Corretor -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card p-4 shadow">
                    <h1 class="text-center mb-4" id="form-title">Cadastro de Corretor</h1>
                    <form id="corretorForm" action="processa_form.php" method="post">
                        <input type="hidden" id="corretorId" name="id">
                        <div class="form-group">
                            <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite seu CPF" required pattern="\d{11}" title="O CPF deve conter exatamente 11 dígitos" maxlength="11">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="creci" name="creci" placeholder="Digite seu Creci" required minlength="2" title="O Creci deve conter pelo menos 2 caracteres">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Digite seu nome" required minlength="2" title="O Nome deve conter pelo menos 2 caracteres">
                        </div>
                        <button type="submit" class="btn btn-dark btn-block" id="submitBtn">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Fim do Formulário de Cadastro de Corretor -->

        <!-- Tabela de Corretores Cadastrados -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-dark text-white">
                        <h3 class="text-center">Lista de Corretores Cadastrados</h3>
                    </div>
                    <div class="card-body">
                        <table id="tabelaCorretores" class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>CPF</th>
                                    <th>CRECI</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- PHP para listar os corretores cadastrados -->
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

                                // Query SQL para buscar todos os corretores cadastrados
                                $sql = "SELECT id, name, cpf, creci FROM corretores";
                                $result = $conn->query($sql);

                                // Exibir os resultados da consulta
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["id"] . "</td>";
                                        echo "<td>" . $row["name"] . "</td>";
                                        echo "<td>" . $row["cpf"] . "</td>";
                                        echo "<td>" . $row["creci"] . "</td>";
                                        echo "<td>";
                                        echo "<button class='btn btn-primary btn-sm mr-2 editar-btn' data-id='" . $row["id"] . "' data-name='" . $row["name"] . "' data-cpf='" . $row["cpf"] . "' data-creci='" . $row["creci"] . "'>Editar</button>";
                                        
                                        // Substituição para exclusão via POST
                                        echo "<form method='post' action='excluir_corretor.php' style='display:inline;'>";
                                        echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                                        echo "<button type='submit' class='btn btn-danger btn-sm excluir-btn'>Excluir</button>";
                                        echo "</form>";

                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>Nenhum corretor cadastrado ainda.</td></tr>";
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Fim da Tabela de Corretores Cadastrados -->
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Preencher o formulário com os dados do corretor a ser editado
        $(document).ready(function() {
            $('.editar-btn').on('click', function() {
                var id = $(this).data('id');
                var name = $(this).data('name');
                var cpf = $(this).data('cpf');
                var creci = $(this).data('creci');
                
                $('#corretorId').val(id);
                $('#name').val(name);
                $('#cpf').val(cpf);
                $('#creci').val(creci);
                
                $('#form-title').text('Editar Corretor');
                $('#submitBtn').text('Salvar');
                $('#corretorForm').attr('action', 'editar_corretor.php');
            });

            // Resetar o formulário para modo de cadastro
            $('#corretorForm').on('reset', function() {
                $('#form-title').text('Cadastro de Corretor');
                $('#submitBtn').text('Enviar');
                $('#corretorForm').attr('action', 'processa_form.php');
            });
        });
    </script>
</body>
</html>





