# 📌 Conecta Farma 

Site de consulta de disponibilidade de medicamentos nos postos de saúde na cidade de Salvador 

---

## Dependências

Para executar na sua maquina baixe 

-- [Xamp](https://www.apachefriends.org/pt_br/index.html) (pacote com php, servidor apache e banco mySql)

-- [Composer](https://getcomposer.org/)

## Executar projeto local

Tudo deve ser feito dentro da pasta htdocs do xamp localizada em C:\xampp\htdocs
Lembre de dar start no apache e no mySql antes de qualquer atividade

Crie uma pasta e inicie um repositorio nela 

```bash
git init
```

### Clone o repositorio
```bash
git clone [url]
```

### Entre na pasta do projeto
```bash
cd pasta do projeto
```

### Instale as dependencias 
```bash
composer install
```

### Clone o .env.example e crie um .env  
```bash
cp .env.example .env
```

### Descomente essa sessão no .env e adicione o nome do banco no campo solictado  
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_banco
DB_USERNAME=root
DB_PASSWORD=
```

Vá no navegador e digite http://localhost/phpmyadmin/
ou clique [localphpMyAdmin](http://localhost/phpmyadmin/) 

Crie um banco de dados e anote o nome no campo orientado acima

### No projeto digite o comando da chave de segurança
```bash
php artisan key:generate
```
### Cria as tabelas do banco e insere os dados de teste
```bash
php artisan migrate:fresh --seed
```

### Executar o programa
```bash
php artisan serve
```

---

# 🌳 Como lançar Branches local para a remota

## Define o seu nome de usuário (será exibido no histórico do Git)
```bash
git config --global user.name "Seu Nome Aqui"
```

## Define o seu email
```bash
git config --global user.email "seu.email@exemplo.com"
```

## Mostra o status atual da sua branch e se há arquivos modificados
```bash
git status
```

## Cria uma nova branch chamada 'suaBranch' e muda para ela
```bash
git checkout -b feature/sua-tarefa
```

## Adiciona todos os arquivos modificados e novos ao "staging area"
```bash
git add .
```

## Salva as alterações com uma mensagem descritiva
```bash
git commit -m "feat: Implementação inicial da tela de login"
```

## Envia o branch para o repositório remoto
```bash
git push --set-upstream origin suaBranch
```