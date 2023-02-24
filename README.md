<p align="center"><img src="https://raw.githubusercontent.com/gabriel2m/portal-ifnmg/master/resources/img/ifnmg-logo.png" width="100"></p>
<h1 align="center">SINPRO</h1>

## Sobre
O SINPRO é um sistema web desenvolvido para o IFNMG Campus Januária voltado para a divulgação dos Serviços, Inovação e Produtos que o campus provê.

## Instalação

**1. Definição .env**
```
cp .env.example .env
```

**2. Execução serviços docker**
```
docker compose up
```

**3. Instalação pacotes composer**
```
docker compose exec app composer install
```

**4. Instalação pacotes npm**
```
docker compose exec app npm install
```

**5. Definição app key**
```
docker compose exec app php artisan key:generate
```

**6. Execução migrations**
```
docker compose exec app php artisan migrate
```

**7. Execução migrations elasticsearch**
```
docker compose exec app php artisan elastic:migrate
```

**8. Alimentação banco de dados (opcional)**
```
docker compose exec app php artisan db:seed
```

**9. Compilação assets**
```
docker compose exec app npm run prod 
```

**10. Liberação acesso imagens**
```
docker compose exec app php artisan storage:link
```

## Testes
```
docker compose exec app php artisan test
```

## Acessos
- **App**: http://127.0.0.1/
- **Emails (MailHog)**: http://127.0.0.1:8025/
- **DB (Adminer)**: http://127.0.0.1:8002/