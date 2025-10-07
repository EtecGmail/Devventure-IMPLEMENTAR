# Devventure TCC — Guia de Execução

## Visão geral
Aplicação Laravel + Vite destinada ao projeto Devventure TCC. Este guia explica como clonar, configurar e executar o projeto nas principais plataformas.

## Pré-requisitos
- **Git** instalado e acessível no terminal.
- **Variáveis de ambiente** definidas em um arquivo `.env` (ver seção correspondente).
- **Stack principal:** PHP ^8.0.2, Composer, Node.js ^16 (ou compatível com Vite 3), npm, e Docker (para execução containerizada).

## Clonagem do repositório
1. Escolha uma pasta de destino: `<PASTA_DESTINO>`.
2. Clone o repositório e acesse a pasta do projeto.
3. Copie o arquivo de variáveis de ambiente base.

```bash
cd <PASTA_DESTINO>
git clone <URL_DO_REPOSITORIO> devventure-tcc
cd devventure-tcc
cp .env.example .env
```
> Em sistemas Windows (PowerShell), substitua `cp` por `Copy-Item` (ver seção de plataformas).

## Execução com Docker (recomendado)
> **Observação:** o Docker não é suportado nativamente no Termux. Utilize a execução nativa para Android/Termux.

1. Certifique-se de que o Docker Desktop (Windows/macOS) ou Docker Engine (Linux) esteja ativo.
2. Construa e inicialize os contêineres com Sail.
3. Acesse a aplicação em `http://localhost:<PORTA_APP>` após a subida completa.

```bash
./vendor/bin/sail up --build
```

Para parar os serviços:
```bash
./vendor/bin/sail down
```

## Execução nativa (sem Docker)
1. Instale dependências PHP e JavaScript.
2. Gere a chave da aplicação e execute as migrações, se necessário.
3. Inicie o servidor de desenvolvimento Laravel e o bundler Vite em terminais separados.

```bash
composer install
npm install
php artisan key:generate
php artisan migrate # opcional, se o banco estiver configurado
php artisan serve --host=0.0.0.0 --port=<PORTA_APP>
npm run dev
```

## Instruções por plataforma
### Windows (PowerShell)
```powershell
cd <PASTA_DESTINO>
git clone <URL_DO_REPOSITORIO> devventure-tcc
cd devventure-tcc
Copy-Item .env.example .env
# Docker
vendor\bin\sail up --build
# Nativo
composer install
npm install
php artisan key:generate
php artisan serve --host=0.0.0.0 --port=<PORTA_APP>
npm run dev
```
> Execute `vendor\bin\sail` dentro do PowerShell; o primeiro uso pode solicitar a habilitação do WSL2/Docker Desktop.

### Ubuntu/Linux (bash)
```bash
cd <PASTA_DESTINO>
git clone <URL_DO_REPOSITORIO> devventure-tcc
cd devventure-tcc
cp .env.example .env
# Docker
./vendor/bin/sail up --build
# Nativo
composer install
npm install
php artisan key:generate
php artisan serve --host=0.0.0.0 --port=<PORTA_APP>
npm run dev
```

### macOS (bash/zsh)
```bash
cd <PASTA_DESTINO>
git clone <URL_DO_REPOSITORIO> devventure-tcc
cd devventure-tcc
cp .env.example .env
# Docker
./vendor/bin/sail up --build
# Nativo
composer install
npm install
php artisan key:generate
php artisan serve --host=0.0.0.0 --port=<PORTA_APP>
npm run dev
```

### Termux (Android) (bash)
> Não há suporte para Docker; execute apenas de forma nativa.
```bash
pkg update && pkg upgrade
pkg install git php composer nodejs-lts
cd <PASTA_DESTINO>
git clone <URL_DO_REPOSITORIO> devventure-tcc
cd devventure-tcc
cp .env.example .env
composer install --no-interaction --prefer-dist
npm install
php artisan key:generate
php artisan serve --host=0.0.0.0 --port=<PORTA_APP>
npm run dev
```
> Caso `cp` não esteja disponível, utilize `cat .env.example > .env`.

## Variáveis de ambiente
Edite o arquivo `.env` conforme a infraestrutura desejada. Exemplos de placeholders:
```
APP_NAME=<NOME_DA_APLICACAO>
APP_ENV=<local|production>
APP_KEY=<CHAVE_GENERADA>
APP_DEBUG=<true|false>
APP_URL=http://localhost:<PORTA_APP>
DB_CONNECTION=<mysql|pgsql|sqlite>
DB_HOST=<HOST_DB>
DB_PORT=<PORTA_DB>
DB_DATABASE=<NOME_DB>
DB_USERNAME=<USUARIO_DB>
DB_PASSWORD=<SENHA_DB>
```
Execute `php artisan key:generate` após ajustar o arquivo para garantir uma chave válida.

## Testes
Execute os testes automatizados sempre que fizer alterações relevantes:
```bash
php artisan test
npm run build
```

## Solução de problemas
- **Porta `<PORTA_APP>` já em uso:** identifique o processo (`lsof -i :<PORTA_APP>` ou `netstat -ano | findstr <PORTA_APP>`) e finalize-o, ou altere a porta no comando `php artisan serve` e no `.env`.
- **Permissões em `storage/` ou `bootstrap/cache`:** aplique `chmod -R 775 storage bootstrap/cache` (Linux/macOS/Termux) ou ajuste permissões no Explorador/PowerShell (`icacls`).
- **Docker não inicia (Windows/Linux):** confirme se o serviço Docker Desktop/Engine está ativo; em Windows, habilite o WSL2 e reinicie o Docker; em Linux, verifique `sudo systemctl status docker` e reinicie com `sudo systemctl restart docker`.
- **Erro de dependências Node:** delete `node_modules` e `package-lock.json`, depois rode `npm install` novamente.

## Comandos rápidos
```bash
# Clonar
cd <PASTA_DESTINO> && git clone <URL_DO_REPOSITORIO> devventure-tcc && cd devventure-tcc && cp .env.example .env
# Docker (Linux/macOS)
./vendor/bin/sail up --build
# Docker (Windows PowerShell)
vendor\bin\sail up --build
# Execução nativa
composer install && npm install && php artisan key:generate && php artisan serve --host=0.0.0.0 --port=<PORTA_APP>
```

---
Mantenha este README atualizado sempre que houver mudanças na stack, processos ou dependências do projeto.
