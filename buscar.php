<?php
include 'conexao.php'; // Inclui nossa conexão PDO

// Pega o dado diretamente da URL sem qualquer tratamento
$nome_heroi = $_GET['nome'];

// !!! A VULNERABILIDADE ESTÁ AQUI !!!
// Concatenação direta da entrada do usuário ($nome_heroi) na query SQL.
$sql = "SELECT id, nome_heroi, poder FROM herois WHERE nome_heroi = '" . $nome_heroi . "'";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Busca (SQLite)</title>
    <style>
        /* (Estilos copiados do index para consistência) */
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { width: 90%; max-width: 600px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2, h3 { color: #2f4f4f; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 12px; text-align: left; }
        th { background-color: #2f4f4f; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .codigo { background-color: #eee; padding: 10px; border-radius: 5px; font-family: monospace; border: 1px solid #ddd; overflow-x: auto; }
        a { color: #2f4f4f; text-decoration: none; display: inline-block; margin-top: 20px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <h3>Resultados para: "<?php echo htmlspecialchars($nome_heroi); ?>"</h3>

        <p>Executando SQL:</p>
        <pre class='codigo'><?php echo htmlspecialchars($sql); ?></pre>

        <table>
            <tr>
                <th>ID</th>
                <th>Nome do Herói</th>
                <th>Poder</th>
            </tr>
            <?php
            // Executa a query vulnerável com PDO
            $resultado = $conn->query($sql);
            
            $encontrou = false;
            if ($resultado) {
                // PDO::FETCH_ASSOC é o equivalente a fetch_assoc() do mysqli
                while ($linha = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    $encontrou = true;
                    echo "<tr>";
                    echo "<td>" . $linha["id"] . "</td>";
                    echo "<td>" . $linha["nome_heroi"] . "</td>";
                    echo "<td>" . $linha["poder"] . "</td>";
                    echo "</tr>";
                }
            }
            
            if (!$encontrou) {
                 echo "<tr><td colspan='3'>Nenhum herói encontrado.</td></tr>";
            }
            ?>
        </table>
        <a href="index_sqlite.html">Voltar</a>
    </div>
</body>
</html>