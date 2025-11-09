<?php
include 'conexao.php'; // Inclui nossa conexão PDO

// Pega o dado não confiável da URL
$nome_heroi = $_GET['nome'];

// !!! A DEFESA: PREPARED STATEMENTS COM PDO !!!

// 1. PREPARAÇÃO: O "molde" SQL é enviado ao banco. O '?' é o placeholder.
$stmt = $conn->prepare("SELECT id, nome_heroi, poder FROM herois WHERE nome_heroi = ?");

// 2. EXECUÇÃO: Os dados do usuário ($nome_heroi) são enviados SEPARADAMENTE
// dentro do execute(). O PDO trata a string de forma segura.
$stmt->execute([$nome_heroi]);

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado da Busca (Seguro - SQLite)</title>
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

        <p><i>Consulta executada com Prepared Statements (Segura).</i></p>

        <table>
            <tr>
                <th>ID</th>
                <th>Nome do Herói</th>
                <th>Poder</th>
            </tr>
            <?php
            // O $stmt (statement) já contém os resultados após o execute()
            $encontrou = false;
            while ($linha = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $encontrou = true;
                echo "<tr>";
                echo "<td>" . $linha["id"] . "</td>";
                // No PDO, os nomes das colunas são sensíveis ao caso, mas
                // 'nome_heroi' e 'poder' (do SELECT) devem funcionar
                echo "<td>" . (isset($linha["nome_heroi"]) ? $linha["nome_heroi"] : "N/A") . "</td>";
                echo "<td>" . (isset($linha["poder"]) ? $linha["poder"] : "N/A") . "</td>";
                echo "</tr>";
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