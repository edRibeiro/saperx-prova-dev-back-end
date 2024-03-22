## API REST para Agenda Telefônica

A API de Agenda Telefônica foi criada para fornecer uma solução simples e eficiente para gerenciar contatos telefônicos. Com esta API, os usuários podem armazenar e recuperar informações de contato, como nomes, números de telefone e datas de nascimento, facilitando o acesso rápido e organizado aos seus contatos.

A seguir, são apresentadas algumas das principais características e funcionalidades da API:

Criação de Contatos: Os usuários podem adicionar novos contatos à sua agenda telefônica, fornecendo informações como nome, endereço de e-mail, número(s) de telefone e data de nascimento.

Leitura de Contatos: A API permite aos usuários visualizar todos os contatos armazenados em sua agenda telefônica, bem como recuperar informações detalhadas de um contato específico com base no seu ID.

Atualização de Contatos: Os usuários têm a capacidade de atualizar as informações de contato existentes, como nome, e-mail, número(s) de telefone e data de nascimento.

Exclusão de Contatos: Além disso, os usuários podem excluir contatos da sua agenda telefônica, removendo permanentemente suas informações da base de dados.

Esta API foi projetada visando a simplicidade de uso, desempenho e segurança dos dados dos usuários. Com uma documentação clara e bem definida, é fácil integrar a API em aplicativos web, móveis ou qualquer outro sistema que necessite de funcionalidades de agenda telefônica.

No restante deste documento, serão apresentadas instruções sobre como instalar e configurar a API de Agenda Telefônica, juntamente com exemplos de uso de suas principais funcionalidades.
###### Pré-requisitos
- Docker
- Docker Compose

#### Instalação
1. Clone o repositório para sua máquina local:

```
git clone https://github.com/edRibeiro/saperx-prova-dev-back-end 
```

2. Navegue até o diretório raiz do projeto:
```
cd <diretorio-do-projeto>
```

3. Instale as dependencias:
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

4. Inicie os containers Docker:
```
./vendor/bin/sail up -d

```

5. Execute as migrações:

```./vendor/bin/sail artisan migrate```

6. Popule o banco de dados com os produtos de celular:

```./vendor/bin/sail artisan db:seed --class=ProductSeeder```

###### Uso
- Acesse a documentação da API em http://localhost/api/documentation para obter detalhes sobre os endpoints disponíveis, parâmetros necessários e exemplos de solicitações e respostas.
- Importe a coleção para o Postman disponível no arquivo ```collections.yml``` do projeto para explorar os endpoints da API de forma interativa.

###### Contribuição
Contribuições são bem-vindas! Sinta-se à vontade para abrir uma issue ou enviar um pull request.

###### Licença
Este projeto está licenciado sob a MIT License.