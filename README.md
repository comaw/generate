Generate product descriptions
====================================


Для работы скрипта нужен php 5.4+ и mysql 5.5+ (можно 5.4+)
Скрипт испоьзует функцию eval - она должна быть разрешена на хостинге!

Документакя по фунции http://php.net/manual/ru/function.eval.php 

Функция позволяет вносить в код другие функции php например number_format


Для подключения к DB в файл
- db/config.php - нужно вписать данные подключения к MySql

Рабочий файл 
- GenerateDescription.php

тут происходит выззов скрипта (остальные файлы подключатся самостоятельно, 
их не нужно делат include)

Пример взова находится в файле
- index.php

в new GenerateDescription() может быть передано один или два параметра. 
Первый - id продукта, второй (не обезательный) - id template (если нет необходимости 
искать по категориям)


Варианты замен и правила
================================

1. варианты замен между собой разделяются через "|" - то есть пример: Текст 1|Текст 2| Текст 3
2. исполняемый код (функции и переменные) - записуются в {{ }} - 
ВНИМАНИЕ - перед и после {{ и }} ОБЕЗАТЕЛЬНО идет пробел!!! - Прмиер {{ $attribute->'Широкоформатный' }}
3. тексты шаблонов не могут содержать такие вещи как `<?php` и `?>` (`<?=` и `?>` или `<?%` и `?>`)
4. Для работы с таблицами product, product_description, manufacturer, category_description - 
нужно просто вызывать поля как обьект соответствущей переменной
* product == $product (напрмиер $product->price - выведет цену продукта)
* product_description == $description (напрмиер $description->name - выведет имя продукта)
* manufacturer == $manufacturer (напрмиер $manufacturer->name - выведет имя производителя)
* category_description == $category (напрмиер $category->name - выведет имя категории)
5. Для работы с атребутами товаров нужно использовать конструкцию вида:
* `$attribute->'Широкоформатный'` - то есть передаем имя атребуту. 
Если у товара есть такой аттребут - будет выведенно его название, если нет - просто пустое место
6. В шаблонах можно использовать php конструкции, например:
* `($product->price > 1) ? 'тест' : 'тест 2'`
* функции - `number_format($price, 0, '.', ' ')`

Если код выдает ошибку - в template допущена ошибка синтаксиса.




