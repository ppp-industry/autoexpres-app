Holomidov Vitalii(DevOps), [13 Sep 2022, 13:54:23]:
Актуальна база в корні
Щоб залити базу
Відкрити корінь проекта в терміналі і написати цю команду:
docker cp ___bk_ticket_09-22__msql.sql db:/root/ && docker exec -it db mysql -u root -p app_db < /root/___bk_ticket_09-22__msql.sql . Ввести потрібно цей пароль: !!!!!!@@@4
Подивитись/змінити доступи до бази можна в файлі .env в корні проекту
Логи Nginx пишуться в папку logs/nginx/

адмінер localhost:8080