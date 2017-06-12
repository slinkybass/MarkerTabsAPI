# MarkerTabs

MarkerTabs is a intuitive and powerful HomePage for faster and easier web navigation, created by [Slinkybass](http://www.garaballu.com).

To get started, check out the Documentation

## Table of contents

- [Install](#install)
- [Creators](#creators)
- [Copyright and license](#copyright-and-license)

## Install

* Install [KnpPaginatorBundle](https://github.com/KnpLabs/KnpPaginatorBundle) and [PHP-JWT](https://github.com/firebase/php-jwt)

* [Download the latest release](https://github.com/slinkybass/MarkerTabsBundle/archive/master.zip) and copy the Bundle in /src

* Modify config.yml, routing.yml, parameters.yml and AppKernel.php:

```yml
# app/config/config.yml
imports:
    - { resource: "@MarkerTabsBundle/Resources/config/resources.yml" }
```

```yml
# app/config/routing.yml
markertabs:
    resource: "@MarkerTabsBundle/Resources/config/routing.yml"
```

```yml
# app/config/parameters.yml
parameters:
    database_name: YourDatabaseName
```

```php
# app/AppKernel.php
	new MarkerTabsBundle\MarkerTabsBundle()
```


* Run
```sh
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
```

## Creators

**Garaballú (slinkybass)**

- <https://twitter.com/slinkybass>
- <https://github.com/slinkybass>


## Copyright and license

Code and documentation Copyright 2016. [MarkerTabsBundle Authors](https://github.com/slinkybass/MarkerTabsBundle/graphs/contributors) and [Garaballú](http://www.garaballu.com).

Code released under the [MIT License](https://github.com/slinkybass/MarkerTabsBundle/blob/master/LICENSE).