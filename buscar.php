<?php
include 'conexao.php'; // Inclui nossa conexão PDO

// Pega o dado diretamente da URL sem sanitização (intencional neste lab)
$nome_heroi = isset($_GET['nome']) ? $_GET['nome'] : '';

// !!! A VULNERABILIDADE ESTÁ AQUI !!!
// Concatenação direta da entrada do usuário ($nome_heroi) na query SQL.
$sql = "SELECT id, nome_heroi, poder FROM herois WHERE nome_heroi = '" . $nome_heroi . "'";

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Busca (Vulnerável)</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif; margin: 20px; background-color: #f4f4f4; color: #333; }
        .container { width: 90%; max-width: 640px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2, h3 { color: #2f4f4f; }
        .badge { display: inline-block; background: #fdecea; color: #8a1f11; padding: 4px 10px; border-radius: 4px; font-size: 0.85rem; font-weight: 600; margin-bottom: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #ccc; }
        th, td { padding: 12px; text-align: left; }
        th { background-color: #2f4f4f; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .codigo { background-color: #eee; padding: 10px; border-radius: 5px; font-family: monospace; border: 1px solid #ddd; overflow-x: auto; }
        a { color: #2f4f4f; text-decoration: none; display: inline-block; margin-top: 20px; margin-right: 16px; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="container">
        <div class="badge">Modo vulnerável — concatenação na SQL</div>
        <h3>Resultados para: "<?php echo htmlspecialchars($nome_heroi, ENT_QUOTES, 'UTF-8'); ?>"</h3>

        <p>SQL montada (observe como a entrada do usuário altera o comando):</p>
        <pre class='codigo'><?php echo htmlspecialchars($sql, ENT_QUOTES, 'UTF-8'); ?></pre>

        <table>
            <tr>
                <th>ID</th>
                <th>Nome do Herói</th>
                <th>Poder</th>
            </tr>
            <?php
            $resultado = $conn->query($sql);

            $encontrou = false;
            if ($resultado) {
                while ($linha = $resultado->fetch(PDO::FETCH_ASSOC)) {
                    $encontrou = true;
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars((string)$linha["id"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars((string)$linha["nome_heroi"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars((string)$linha["poder"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "</tr>";
                }
            }

            if (!$encontrou) {
                 echo "<tr><td colspan='3'>Nenhum herói encontrado.</td></tr>";
            }
            ?>
        </table>
        <a href="index.html">Voltar</a>
        <a href="index.html?modo=seguro">Testar no modo seguro</a>
    </div>
</body>
</html>
