<h1>Obalor тестовое</h1>
<p>
    <ol>
        <li>Развернул докер (postgres+php+nginx)</li>
        <li>настройки в env-е для соединения с БД:
            <p>DB_CONNECTION=pgsql</p>
            <p>DB_HOST=pg</p>
            <p>DB_PORT=5432</p>
            <p>DB_DATABASE=obalor_db</p>
            <p>DB_USERNAME=root</p>
            <p>DB_PASSWORD=root</p>
        </li>
        <li>для старта докера стандартное - docker-compose up</li>
        <li>для входа в php контейнер можно использовать команду из makefile: make php_container</li>
        <li>Установил свежий ларавель через композер</li>
        <li>Выполнил стандартные миграции: php artisan migrate:install и php artisan migrate</li>
        <li>
        создал миграцию и модель под сущность "customers" - 
        php artisan make:migration create_customers_table -m
        </li>
        <li>Расписал поля в миграции по заданию - далее промигрировал php artisan migrate </li>
        <li>Под импорт сделал сервис ImportCustomerService в app/Services</li>
        <li>Файл импорта сложил в /storage/app/import/random.csv. Для гита - продублировал в корень</li>
        <li>Далее работа в ImportCustomerService. Получение данных из хранилища, 
        приведение данных к нужному виду через метод matchFields. 
        Затем наполнение объекта Customer и сохранение в БД
        </li>
        <li>Для избежания проблемы с mass assignment в моделях установил $guarded = []</li>
        <li>Для проверки условий перед сохранением использовал мутации в модели Customer</li>
        <li>
            Для проверки страны выкачал с интернетов json файл world.json. Сложил его в /storage/app/import/world.json
        </li>
        <li>Для этого файла создал таблицу countries через миграцию</li>
        <li>Написал импорт из файла - осуществил через сервис ImportCountriesService в app/Services</li>
        <li>Записи прошедшие проверку в мутациях попадают в БД. Непрошедшие идут на экспорт</li>
        <li>Как конструктор экспорта выступает файл ImportCustomersErrorExport в app/Exports</li>
        <li>Экспорт сделал через библиотеку maatwebsite/excel</li>
        <li>Файл экспорта попадает в /storage/app/customers_import_error/ с названием customers_error.xlsx</li>
    </ol>
