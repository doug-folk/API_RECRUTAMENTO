# API de Recrutamento

## Descrição
API para gerenciamento de vagas, candidatos e candidaturas, desenvolvida seguindo os padrões de projeto MVC, Singleton, PDO e DAO.

## Estrutura do Projeto

```
/api
  /config
    Database.php (Singleton para conexão PDO)
    config.php (Configurações gerais)
  /models
    Vaga.php
    Pessoa.php
    Candidatura.php
  /dao
    IDAO.php (Interface genérica)
    VagaDAO.php
    PessoaDAO.php
    CandidaturaDAO.php
  /controllers
    VagaController.php
    PessoaController.php
    CandidaturaController.php
  /utils
    Validator.php (Validação de dados)
    DistanceCalculator.php (Cálculo de distâncias)
    ScoreCalculator.php (Cálculo de score)
  index.php (Ponto de entrada da API)
  .htaccess (Configuração para roteamento)
```

## Requisitos

- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web com suporte a mod_rewrite (Apache, Nginx, etc.)

## Instalação

1. Clone o repositório:
```
git clone https://github.com/seu-usuario/recrutamento-api.git
```

2. Importe o esquema do banco de dados:
```
mysql -u root -p < database_schema.sql
```

3. Configure o acesso ao banco de dados em `api/config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'recrutamento_api');
define('DB_USER', 'seu_usuario');
define('DB_PASS', 'sua_senha');
```

4. Configure o servidor web para apontar para o diretório `api`.

## Endpoints da API

### POST /vagas
Cria uma nova vaga.

**Requisição:**
```json
{
  "id": "550e8400-e29b-41d4-a716-446655440000",
  "empresa": "Empresa Teste",
  "titulo": "Desenvolvedor PHP",
  "descricao": "Vaga para desenvolvedor PHP com experiência em MVC e PDO",
  "localizacao": "A",
  "nivel": 3
}
```

**Respostas:**
- 201 Created: Vaga criada com sucesso
- 400 Bad Request: JSON inválido
- 422 Unprocessable Entity: Dados inválidos ou vaga duplicada

### POST /pessoas
Cria uma nova pessoa.

**Requisição:**
```json
{
  "id": "550e8400-e29b-41d4-a716-446655440010",
  "nome": "João Silva",
  "profissao": "Desenvolvedor PHP",
  "localizacao": "B",
  "nivel": 3
}
```

**Respostas:**
- 201 Created: Pessoa criada com sucesso
- 400 Bad Request: JSON inválido
- 422 Unprocessable Entity: Dados inválidos ou pessoa duplicada

### POST /candidaturas
Cria uma nova candidatura.

**Requisição:**
```json
{
  "id": "550e8400-e29b-41d4-a716-446655440020",
  "id_vaga": "550e8400-e29b-41d4-a716-446655440000",
  "id_pessoa": "550e8400-e29b-41d4-a716-446655440010"
}
```

**Respostas:**
- 201 Created: Candidatura criada com sucesso
- 400 Bad Request: JSON inválido ou candidatura duplicada
- 404 Not Found: Vaga ou pessoa não encontrada

### GET /vagas/{id}/candidaturas/ranking
Retorna o ranking de candidatos para uma vaga.

**Resposta:**
```json
{
  "candidaturas": [
    {
      "nome": "João Silva",
      "profissao": "Desenvolvedor PHP",
      "localizacao": "B",
      "nivel": 3,
      "score": 87
    },
    {
      "nome": "Maria Santos",
      "profissao": "Desenvolvedora PHP",
      "localizacao": "C",
      "nivel": 4,
      "score": 75
    }
  ]
}
```

**Respostas:**
- 200 OK: Ranking obtido com sucesso
- 404 Not Found: Vaga não encontrada

## Cálculo do Score

O score de um candidato é calculado com base na seguinte fórmula:

```
Score = (N + D) / 2
```

Onde:

- **N** é definido por: `N = 100 - 25 × |NV - NC|`
  - NV é o nível de experiência esperado para a vaga
  - NC é o nível de experiência do candidato

- **D** é definido com base na menor distância entre o candidato e a vaga:
  - 0 até 5: 100
  - maiores que 5 até 10: 75
  - maiores que 10 até 15: 50
  - maiores que 15 até 20: 25
  - maiores que 20: 0

Desenvolvido como parte do desafio da disciplina de backend.

