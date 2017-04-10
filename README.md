## Newsletters

[![Total Downloads](https://poser.pugx.org/mixdinternet/newsletters/d/total.svg)](https://packagist.org/packages/mixdinternet/newsletters)
[![Latest Stable Version](https://poser.pugx.org/mixdinternet/newsletters/v/stable.svg)](https://packagist.org/packages/mixdinternet/newsletters)
[![License](https://poser.pugx.org/mixdinternet/newsletters/license.svg)](https://packagist.org/packages/mixdinternet/newsletters)

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

Através deste arquivo é possível habilitar/desabilitar o campo nome no cadastro/listagem de newsletters

```
  php artisan vendor:publish --provider="Mixdinternet\Newsletters\Providers\NewslettersServiceProvider" --tag="config"`
```
