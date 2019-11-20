# Description

Sometimes it's helpful to have the module-chain which is saved in the oxid database in a simple php file on the disk, e.g. for running static code analysis or to tell your IDE where to find a `*_parent` class. This little Tool allows you to generate a php-file which consinst of all `class_alias` statements used inside the shop.

Could be used for example in `phpstan` like this:
```
$ cat phpstan.neon
parameters:
    level: 0
    autoload_files:
    - %currentWorkingDirectory%/vendor/autoload.php
    - %currentWorkingDirectory%/autoload.oxid.php
    - %currentWorkingDirectory%/source/oxfunctions.php
    - %currentWorkingDirectory%/source/modules/functions.php
    - %currentWorkingDirectory%/source/overridablefunctions.php
```

# Installation

```
composer require --dev alfredbez/oxid-dump-autoload
```

# Usage

Run `vendor/bin/oxid-dump-autoload` to generate a `autoload.oxid.php` inside your current working directory.
