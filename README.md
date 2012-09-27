# MopHugbearBundle

This is a little gimmick i wrote. It adds hugbears to your Symfony2 project!

To get an idea of what it is doing:

![My image](http://m0ppers.github.com/MopHugbearBundle/hugbears.png)

[![Build Status](https://secure.travis-ci.org/m0ppers/MopHugbearBundle.png?branch=master)](http://travis-ci.org/m0ppers/MopHugbearBundle)

## Installation

### 1. Install using composer

composer.json:

``` js
{
    "require": {
        "mop/hugbearbundle": "*"
    }
}
```

``` bash
$ php composer.phar update mop/hugbearbundle
```

### 2. Enable the bundle

Preferably you add the bundle to your development environment. Otherwise the listener will add the bears even in the production environment (they won't activate though).

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    // ...
    if (in_array($this->getEnvironment(), array('dev', 'test'))) {
        // ...
        $bundles[] = new Mop\HugbearBundle\MopHugbearBundle();
        // ...
    }
    // ..
}
```

### 3. Install assets

``` bash
$ php app/console assets:install
```

### 4. Enjoy!

Open your application in the development environment. A hugbear should appear in your profilerbar. Click it and enjoy!
