# manda-cv
Projeto em php para uma plataforma de envio de currículos 


# Instruções para uso da aplicação após fazer `git clone`

1. Copie o arquivo .env.example para .env usando o comando
   
```sh
cp .env.example .env
```

2. Levante os containers docker usando 

```sh
docker-compose up -d --build
```
3. Em seguida entre no container da aplicação 

```sh
docker exec -it app bash
```
4. Agora dentro dele vamos em busca de nossas dependências 

```sh
composer install
```

6. Para testar se nossa API está funcionando como esperado execute os testes

```sh
php artisan test
```   



