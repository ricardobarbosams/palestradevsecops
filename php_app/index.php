<?php
// Ativa a exibição de erros para ajudar no debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Conexão com o banco (PROBLEMA 1: Credencial exposta que o SonarQube vai pegar)
$conexao = mysqli_connect("mysql_container", "root", "SenhaSuperSecretaDoBatman123!", "db_herois");

//$usuario = $_POST['user'] ?? '';
//$senha   = $_POST['pass'] ?? '';
$usuario = mysqli_real_escape_string($conexao, $_POST['user']);
$senha   = mysqli_real_escape_string($conexao, $_POST['pass']);
$logado  = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // PROBLEMA 2: SQL Injection clássico por concatenação direta
    $query = "SELECT * FROM usuarios WHERE usuario = '$usuario'  AND senha = '$senha'";
    ////echo "<BR>" . $query . "<br>";

   
    // Executa a query passando primeiro a conexão, depois a string de consulta
    $resultado = mysqli_query($conexao, $query);
    
    // Se a query falhar por erro de sintaxe, mos0tra na tela
    if (!$resultado) {
        die("Erro no banco de dados: " . mysqli_error($conexao));
    }
    
    // Se retornar qualquer linha, o usuário entra!
    if (mysqli_num_rows($resultado) > 0) {
        $logado = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Portal da Liga da Justiça</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .box { border: 1px solid #ccc; padding: 20px; border-radius: 5px; width: 300px; }
    </style>
</head>
<body>
    <center>
    <?php if (!$logado): ?>
        <div class="box">
            <h2>🔐 Login do Sistema</h2>
            <form method="POST">
                <label>Usuário:</label><br>
                <input type="text" name="user" style="width: 100%;"><br><br>
                <label>Senha:</label><br>
                <input type="password" name="pass" style="width: 100%;"><br><br>
                <button type="submit" style="width: 100%; height: 30px;">Entrar</button>
            </form>
            <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && !$logado) echo "<p style='color:red;'>Acesso negado!</p>"; ?>
        </div>
    <?php else: ?>
        <div style="background-color: #d4edda; color: #155724; padding: 20px; border-radius: 5px;">
            <h1>🎉 Bem-vindo ao Painel Secreto, Herói!</h1>
            <p>Você burlou o sistema de autenticação com sucesso usando SQL Injection.</p>
        </div>
    <?php endif; ?>
    </center>
</body>
</html>