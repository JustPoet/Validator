# Validator
A very simplify php validate tool

### Install

```shell
composer require zean/validator
```

### Usage


```php
<?php
use Zean\Validator\Validator;

$rules = [
    'name' => 'required|length:2,5',
    'date' => function($value){
        return strtotime($value) > time();
    }
];

$data = [
    'name' => 'andy',
    'date'=>'2015-07-29'
];

$result = Validator::validate($data, $rules);
```

array(2) {
  'name' =>
  bool(true)
  'date' =>
  bool(false)
}

