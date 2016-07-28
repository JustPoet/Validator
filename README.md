# Validator
一个简洁的校验器,通过传入数组参数和校验规则,即可得出其中的问题字段

使用

```php
<?php
use Andy\Validator\Validator;

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

