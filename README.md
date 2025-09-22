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
