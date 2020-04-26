# Encrypted

A custom cast class for Laravel Eloquent that encrypts your values.

## Installation

Use composer

```
$ composer require crudly/encrypted
```

## Usage

Mark any column in your model as encrypted

```
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

```
$mm = new MyModel;

$mm->someting_secret = 'classified_info';
$mm->save();
```

### Type casting

Encryption serializes the variable and decryption unserializes it, so you get out exactly what you put in. This usually means that no type casting is needed.

But sometimes you want everything casted to some type even if you put something else in. In those cases you can specify types (all of Eloquent's default casts are supported):

```
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

# TODO

Maybe add key and cipher customization via options, i.e. `Encrypted::class.':string,AckfSECXIvnK5r28GVIWUAxmbBSjTsmF'` and `Encrypted::class.':string,AckfSECXIvnK5r28GVIWUAxmbBSjTsmF,AES-128-CBC'`.