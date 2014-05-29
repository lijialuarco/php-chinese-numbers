php-chinese-numbers
===================

PHP implementation of a ChineseNumber object and derivative stack designed to complement Mandarin Chinese translation services

## GETTING STARTED

This is a reference implementation. Feel free to fork it and add your personal touch or local flavor. It's [FLOSS](#license).

Helpful Resources:
+ This library uses PHP: http://www.php.net/
+ Code and documenetation use Pffy idioms: https://github.com/pffy/idioms#chinese-text-processing
+ http://en.wikipedia.org/wiki/Chinese_numerals


## CHINESE NUMBER CONVERSION

Expression numbers in any language helps you communicate useful information. 

If you are developing Chinese lexical knowledgebase or search engine (for example), you may want to complement text search results with number conversion and translation.

The possibilities for this [open source](#license) stack include (but are not limited to):

+ Improving accuracy or clarity of Mandarin Chinese translations.
+ Adding more control over local or colloquial expressions for numbers.
+ Avoiding dependency on external operating system or platform locale developers.
+ Avoiding misinterpetation or confusion, especially in [high-context communication](https://www.google.com/search?q=high%20context%20communication).
+ Adding granular control for age-specific content in a supervised education context.
+ Developing apps for your organization with 100% free, libre and open source software is frictionless.


## CLASSES AND DEPENDENCIES

+ Abacus
+ Digits

+ ChineseInteger
  - Abacus
  - Digits

+ ChineseFraction
  - ChineseInteger

+ ChinesePercent
  - ChineseInteger

+ ChineseNumber (wrapper class)

## DEMO

```php

<?php

# pffy class autoloader
require_once 'src/pffygo.php';

# [88|0,0,0,8,8]
echo (new Abacus(88));

# 八十八万八千八百八十八
echo (new ChineseInteger());

# 八十八万八千八百八十八
echo (new ChineseInteger(8888));

# 八十八万八千八百八十八
echo (new ChineseInteger(888888));

# 八分之三
echo (new ChineseFraction(3, 8)); 

# 百分之八十八
echo (new ChinesePercent(88)); 

# 八五八八五八
echo (new ChineseDigits(858858));
?>
```

## LICENSE

```
This is free and unencumbered software released into the public domain.

Anyone is free to copy, modify, publish, use, compile, sell, or
distribute this software, either in source code form or as a compiled
binary, for any purpose, commercial or non-commercial, and by any
means.

In jurisdictions that recognize copyright laws, the author or authors
of this software dedicate any and all copyright interest in the
software to the public domain. We make this dedication for the benefit
of the public at large and to the detriment of our heirs and
successors. We intend this dedication to be an overt act of
relinquishment in perpetuity of all present and future rights to this
software under copyright law.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

For more information, please refer to <http://unlicense.org/>
```
