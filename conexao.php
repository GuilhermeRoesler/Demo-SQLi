<?php
// Conexão usando PDO (PHP Data Objects) para SQLite
try {
    // O banco será um arquivo chamado 'lab.db' nesta mesma pasta
    $conn = new PDO("sqlite:lab.db");
    
    // Define o modo de erro para que possamos ver os erros (importante para o lab)
    // Usamos WARNING para que ele mostre o erro SQL (como no lab original) sem parar o script
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

} catch (PDOException $e) {
    // Se não conseguir conectar, o script para.
    die("Falha na conexão com o banco SQLite: " . $e->getMessage());
}
?>