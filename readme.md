# Implementação de uma aplicação PHP CLI sem usar libs

## Para levantar o container 
```
docker-compose up -d
```

## Para instalar as dependencias;
```
docker-compose exec php composer install
```

## Efetuando testes na apliação

```
 - docker-compose exec php bash
 - php src/index capital-gains
```


## Se tiver problemas com arquivo php não encontrado

```
composer dump-autoload
```
