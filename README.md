# librocks :metal:

PHP is one of my favorites programming language, because WordPress use it. Although PHP community is not solid like Javascript, I'm still developing some of PHP codes until today. So I made this library collection for my needs.

## Function Replace
A Function Replace class for replace existing function within file replaced with another function. Including it's parameters.

### Usage
**Class Name**: ``FunctionReplace``  
**File Name**: ``class-fn-replace.php``

**$from_fn**  
*(string)* (Required) Name of the script. Should be unique. Default Value: ''

**$to_fn**  
 *(string)* (Required) Full URL of the script, or path of the script relative to the WordPress root directory. Default value: ''

**$replace**  
(boolean) (Optional) Whether you want to replace function's file.

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

if ($fn_replace->status()) {
  echo 'Succeed';
} else {
  echo 'Noop';
}
```
