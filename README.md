## _API Rest de Tarefas Simples permite gerenciar tarefas através dos métodos HTTP._
___
## Endpoints:

#### GET /tasks
Retorna todas as tarefas existentes no arquivo tasks.json

```json
    "0": {
        "id": 1,
        "name": "Comprar alimentos para a semana",
        "description": "Lista de compras"
    },
    "1": {
        "id": 2,
        "name": "Limpar a casa",
        "description": "Limpar a cozinha e o banheiro"
    },
    "2": {
        "id": 3,
        "name": "Estudar para a prova",
        "description": "Revisar o conteúdo da disciplina"
    }
```

#### GET /tasks/{id}
Retorna uma tarefa específica pelo ID.
```json
    "2": {
        "id": 3,
        "name": "Estudar para a prova",
        "description": "Revisar o conteúdo da disciplina"
    }
```

#### POST /tasks
Cria uma nova tarefa.
```json
{
  "name": "Nova tarefa",
  "description": "Nova descrição"
}
```

#### PUT /tasks/{id}
Atualiza uma tarefa existente pelo ID.
```json
{
  "name": "Nova tarefa atualizado",
  "description": "Nova descrição atualizada"
}
```

#### DELETE /tasks/{id}
Exclui uma tarefa existente pelo ID.
```json
{
  "name": "Tarefa deletada",
  "description": "Descrição deletada"
}
```

## Como usar
Para utilizar a API Rest de Tarefas, basta realizar as requisições HTTP utilizando um software ou extensão de sua preferência, como o Postman por exemplo.
Faça o clone do repositório e inicie o servidor embutido do PHP usando o comando:

```terminal
php -S localhost:8000
```
