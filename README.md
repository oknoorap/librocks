# librocks :metal:

PHP is one of my favorites programming language, because WordPress still use it. But php community is not solid like Javascript. So I made this library collection for my needs.

## Function Replacer
A Function Replace class for replace existing function within file replaced with another function. Including it's parameters.

### Usage
**$from_fn**  
*(string)* (Required) Name of the script. Should be unique. Default Value: ''

**$src**  
 *(string)* (Required) Full URL of the script, or path of the script relative to the WordPress root directory. Default value: ''

**$replace**  
(boolean) (Optional) Whether you want to replace function's file.

```php
<?php

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
