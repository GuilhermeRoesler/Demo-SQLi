<?php
// Este script cria e popula o banco de dados SQLite.
// Execute-o UMA VEZ acessando-o pelo navegador.

try {
    // 1. Cria ou abre a conexão com o banco
    $conn = new PDO("sqlite:lab.db");
    
    // 2. Define o modo de erro para lançar exceções
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Conexão com lab.db estabelecida.<br>";

    // 3. Remove tabelas antigas, se existirem (para poder rodar de novo)
    $conn->exec("DROP TABLE IF EXISTS herois");
    $conn->exec("DROP TABLE IF EXISTS usuarios");
    echo "Tabelas antigas removidas (se existiam).<br>";

    // 4. Cria as tabelas
    // (AUTOINCREMENT é o equivalente SQLite de AUTO_INCREMENT do MySQL)
    $conn->exec("CREATE TABLE herois (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    nome_heroi VARCHAR(100),
                    poder VARCHAR(255)
                 )");

    $conn->exec("CREATE TABLE usuarios (
                    id INTEGER PRIMARY KEY AUTOINCREMENT,
                    username VARCHAR(100),
                    password_hash VARCHAR(255)
                 )");
    echo "Tabelas 'herois' e 'usuarios' criadas.<br>";
    
    // 5. Insere os dados
    $conn->exec("INSERT INTO herois (nome_heroi, poder) VALUES
                    ('Superman', 'Voar, Super Força'),
                    ('Batman', 'Inteligência, Dinheiro'),
                    ('Mulher Maravilha', 'Super Força, Laço da Verdade')");

    $conn->exec("INSERT INTO usuarios (username, password_hash) VALUES
                    ('admin', 'sha1\$98f6bcd4\$1\$23...'),
                    ('bob', 'md5\$e10adc39...'),
                    ('alice', 'bcrypt\$2y\$10\$N9...')");

    echo "Dados inseridos com sucesso.<br>";
    echo "<h2>Configuração Concluída!</h2>";
    echo "<p>O banco 'lab.db' está pronto.</p>";
    echo "<a href='index_sqlite.html'>Ir para o Laboratório</a>";

} catch (PDOException $e) {
    echo "Erro na configuração do banco: " . $e->getMessage();
}
?>