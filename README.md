# librocks :metal:

PHP is one of my favorites programming language, after golang and javascript, because WordPress using it. Although PHP community is not progressive like js community, I still write some PHP codes until today. So I made this library just for my collection.

## Function Replace
A Function Replace class to replace existing function within file and replaced with another function. Including it's parameters.

**Class**: ``FunctionReplace``  
**File**: ``class-fn-replace.php``

### Usage
**$from_fn**  
*(string)* (Required) Name of origin function. Default Value: ''

**$to_fn**  
 *(string)* (Required) Name of replace function. Default value: ''

**$replace**  
(boolean) (Optional) Whether you want to rewrite file or just see the output. Default value: `false`

```php
<?php

function old_fn () {
  echo 'Hi, Dev';
}

function new_fn ($str = '', $is_array) {
  if (!$is_array) {
    return $str;
  }
  
  return str_split($str);
}

// Just want to see the output
$fn_replace = new FunctionReplace('old_fn', 'new_fn');
echo $fn_replace->output;

// Replace file
$fn_replace = new FunctionReplace('old_fn', 'new_fn', true);

if ($fn_replace->succeed()) {
  echo 'Succeed';
} else {
  echo 'Noop';
}
```
