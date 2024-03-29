# Encrypted

[![Build Status](https://img.shields.io/travis/crudly/Encrypted/master?style=flat-square)](https://travis-ci.org/crudly/encrypted)
[![Release](https://img.shields.io/github/v/release/crudly/Encrypted?style=flat-square)](https://github.com/crudly/Encrypted/releases/latest)
[![License](https://img.shields.io/packagist/l/crudly/encrypted?style=flat-square)](LICENSE)

> **Note** This package is no longer needed for new projects as [hashing is now](https://github.com/laravel/framework/pull/46947)
> among the native casts and encryption was there for a while already.
> We will probably keep it up to date for a few more years because it usually only takes bumping a version tag.

A custom cast class for Laravel Eloquent that encrypts or hashes your values. Package is small and provides just a few, simple, well tested features.

```php
protected $casts = [
    // hashes the value when assigning to $model->password
    'password' => Password::class,

    // encrypts on write, decrypts on read
    'classified' => Encrypted::class,

    // encrypts on write, decrypts & typecasts on read
    'secret' => Encrypted::class.':integer',
];
```

## Installation

Use composer.

```bash
$ composer require crudly/encrypted
```

## Usage

Mark any column in your model as encrypted.

```php
<?php

namespace App;

use Crudly\Encrypted\Encrypted;
use Illuminate\Database\Eloquent\Model;

class MyModel extends Model
{
	protected $casts = [
		'something_secret' => Encrypted::class,
	];
}
```

You can work with the attribute as you normally would, but it will be encrypted on the database.

```php
$mm = new MyModel;

$mm->someting_secret = 'classified_info';
$mm->save();
```

### Type casting

Encryption serializes the variable and decryption unserializes it, so you get out exactly what you put in. This usually means that no type casting is needed.

But sometimes you want everything casted to some type even if you put something else in. In those cases you can specify types (all of Eloquent's default casts are supported):

```php
<?php

namespace App;

use Crudly\Encrypted\Encrypted;
use Illuminate\Database\Eloquent\Model;

class MyModel extends Model
{
	protected $casts = [
		'encrypted_column' => Encrypted::class,
		'an_integer' => Encrypted::class.':integer',
		'a_string' => Encrypted::class.':string',
		'decimal_with_two_places' => Encrypted::class.':decimal:2',
	];
}
```

### Password hashing

This can also be used to hash a password upon write.

```php
<?php

namespace App;

use Crudly\Encrypted\Password;
use Illuminate\Database\Eloquent\Model;

class MyUser extends Model
{
	protected $casts = [
		'password' => Password::class,
	];
}
```

This hashes the password using `bcrypt`. You can check a string against the hashed password using `Hash` facade.

```php
$mu = new MyUser;
$mu->password = 'secret';

$mu->password; // returns a hash

Hash::check('secret', $mu->password); //returns true
Hash::check('hunter2', $mu->password); //returns false
```

# TODO

Maybe add key and cipher customization via options, i.e. `Encrypted::class.':string,AckfSECXIvnK5r28GVIWUAxmbBSjTsmF'` and `Encrypted::class.':string,AckfSECXIvnK5r28GVIWUAxmbBSjTsmF,AES-128-CBC'`. And password hashing options.
