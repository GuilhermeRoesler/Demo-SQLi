## 🔬 Roteiro do Laboratório SQLi (Versão SQLite & PHP)

Esta é a versão do laboratório que usa o PHP com SQLite, eliminando a necessidade de instalar o XAMPP ou MySQL.

---

## Fase 1: Configuração do Ambiente (Mais Fácil)

1.  **Baixe o PHP:** Se ainda não o fez, baixe o "zip" do PHP para Windows no site `php.net/downloads.php` e extraia (ex: em `C:\php`).
2.  **Crie a Pasta do Projeto:** Crie uma pasta (ex: `C:\lab-sqli`).
3.  **Salve os Arquivos:** Salve todos os 5 arquivos (`setup_sqlite.php`, `conexao_sqlite.php`, `index_sqlite.html`, `buscar_sqlite.php`, `buscar_seguro_sqlite.php`) dentro desta pasta.
4.  **Inicie o Servidor Embutido:**
    - Abra o Prompt de Comando (cmd).
    - Navegue até a pasta do seu projeto: `cd C:\lab-sqli`
    - Inicie o servidor do PHP: `C:\php\php.exe -S localhost:8000`
      > **Nota:** Se o `php.exe` não for encontrado, use o caminho completo onde você o extraiu.
5.  **Crie o Banco de Dados:**
    - No navegador, acesse: `http://localhost:8000/setup_sqlite.php`
    - Você verá mensagens de "Configuração Concluída!".
    - Verifique sua pasta `C:\lab-sqli`: um novo arquivo chamado `lab.db` deve ter aparecido. Esse é o seu banco de dados.

---

## Fase 2: Explorando a Vulnerabilidade (`buscar_sqlite.php`)

Navegue até a sua aplicação no navegador: `http://localhost:8000/index_sqlite.html`

### Passo 1: Teste Funcional

- **Ação:** Na caixa de busca, digite `Batman` e clique "Buscar".
- **Resultado:** A página mostra a tabela com os dados do Batman.

### Passo 2: Tentativa de Bypass

- **Ação:** Na busca, digite: `' OR '1'='1`
- **Resultado:** A tabela agora mostra **TODOS** os heróis. A injeção funcionou.

### Passo 3: Descoberta (Encontrando o nº de colunas)

- **Ação (Teste 1):** Na busca, digite: `' ORDER BY 3 --`
  > (Nota: O comentário `--` também funciona no SQLite para anular o resto da query)
- **Resultado:** A página carrega normalmente. A coluna 3 existe.

- **Ação (Teste 2):** Na busca, digite: `' ORDER BY 4 --`
- **Resultado:** A página exibe um **ERRO** (algo como "ORDER BY clause should come after... column index 4 is out of range").
- **Conclusão:** O SELECT original tem exatamente **3 colunas**.

### Passo 4: Ataque UNION (Roubando os Dados)

- **Ação:** Na busca, digite: `x' UNION SELECT id, username, password_hash FROM usuarios --`
- **Resultado:** A tabela de "Heróis" agora está preenchida com os dados da tabela `usuarios` (admin, bob, alice).
- **Conclusão:** Sucesso! O ataque funciona da mesma forma contra o SQLite.

---

## Fase 3: Correção e Teste Final (`buscar_seguro_sqlite.php`)

### 1. Altere o Formulário

- Abra o arquivo `index_sqlite.html` no seu editor de código.
- Mude a `action` do formulário de `buscar_sqlite.php` para `buscar_seguro_sqlite.php`.
- Salve o arquivo.

### 2. Tente o Ataque Novamente

- Volte para `http://localhost:8000/index_sqlite.html` (recarregue a página).
- Insira o ataque do Passo 4 novamente: `x' UNION SELECT id, username, password_hash FROM usuarios --`

### 3. Resultado Final

- **O ataque falha.** A página exibe "Nenhum herói encontrado."
  > **Por quê?** Os **Prepared Statements** do PDO (usados no arquivo seguro) trataram a string de ataque como **texto literal**, e não como um comando SQL. A defesa funcionou.
