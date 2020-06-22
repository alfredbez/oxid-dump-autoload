# Description

Sometimes it's helpful to have the module-chain which is saved in the oxid database in a simple php file on the disk, e.g. for running static code analysis or to tell your IDE where to find a `*_parent` class. This little Tool allows you to generate a php-file which consinst of all `class_alias` statements used inside the shop.

Could be used for example in `phpstan` like this:
```
$ cat phpstan.neon
parameters:
    level: 0
    autoload_files:
    scanFiles:
    - %currentWorkingDirectory%/source/oxfunctions.php
    - %currentWorkingDirectory%/source/overridablefunctions.php
    bootstrapFiles:
    - %currentWorkingDirectory%/vendor/oxid-esales/oxideshop-ce/source/Core/Model/BaseModel.php
    - %currentWorkingDirectory%/.autoload.oxid.php
```

Make sure to use `bootstrapFiles` since the file contains a list of `class_alias()` statements.

Usage example for `psalm`:
```
$ cat .autoload.php
<?php

require_once 'vendor/autoload.php';
require_once '.autoload.oxid.php';
```
```
$ cat psalm.xml
<?xml version="1.0"?>
<psalm
    errorLevel="6"
    resolveFromConfigFile="true"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xmlns="https://getpsalm.org/schema/config"
    xsi:schemaLocation="https://getpsalm.org/schema/config vendor/vimeo/psalm/config.xsd"
    autoloader=".autoload.php"
>
    <projectFiles>
        <directory name="." />
        <ignoreFiles>
            <directory name="vendor" />
            <file name="metadata.php" />
        </ignoreFiles>
    </projectFiles>
</psalm>
```

# Installation

```
composer require --dev alfredbez/oxid-dump-autoload
```

# Usage

`vendor/bin/oxid-dump-autoload --help` shows you the general usage info.

To generate a `autoload.oxid.php` inside your current working directory add `-p autoload.oxid.php` to the command.


## Options

### Source

The script uses the class-chain from the shop as default, but you can also generate the autoload-files for a module by specifying a path to the `metadata.php`:
```
vendor/bin/oxid-dump-autoload --source path/to/my/module/metadata.php
```

### Filter

You can filter classes from the chain like so:

```
vendor/bin/oxid-dump-autoload --filter oe/,ddoe/
```

### Specifying a shop-id

```
vendor/bin/oxid-dump-autoload --shopid 5
```

### Write to a file instead of STDOUT

```
vendor/bin/oxid-dump-autoload -p .autoload.oxid.php
vendor/bin/oxid-dump-autoload > .autoload.oxid.php # basically the same
```

### Provide path to `bootstrap.php`

If the script is not able to find the shops `bootstrap.php` you can provide the path via the environment variable `BOOTSTRAP_PATH`:
```
BOOTSTRAP_PATH=$(pwd)/source/bootstrap.php vendor/bin/oxid-dump-autoload
```
