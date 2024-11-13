ПОРЯДОК РАЗВЕРСТКИ 

1. Клонируйте репозиторий.

2. Выполните `composer install`.

3. Сгенерируйте БД с помощью `create_DB.sql`.

3. Сгенерируйте таблицу БД с помощью `create_tables.sql`.

4. Импортируйте данные:
    php import.php

5. Для экспорта данных, используйте:
    php export_a.php
    php export_b.php

6. Для отображения меню запустите:
    php list_menu.php