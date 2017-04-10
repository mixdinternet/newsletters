## Newsletters

Pacote inicial de cadastro de newsletters.

## Dependencias
Nenhuma

## Instalação

Adicione no seu composer.json

```js
  "require": {
    "mixdinternet/newsletters": "0.1.*"
  }
```

ou

```js
  composer require mixdinternet/newsletters
```

## Service Provider

Abra o arquivo `config/app.php` e adicione

`Mixdinternet\Newsletters\Providers\NewslettersServiceProvider::class`

## Migrations

```
  php artisan vendor:publish --provider="Mixdinternet\Newsletters\Providers\NewslettersServiceProvider" --tag="migrations"`
  php artisan migrate
```

## Configurações

É possivel a troca de icone e nomenclatura do pacote em `config/mnewsletters.php`

```
  php artisan vendor:publish --provider="Mixdinternet\Newsletters\Providers\NewslettersServiceProvider" --tag="config"`
```