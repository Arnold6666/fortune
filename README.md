# Blog 使用手冊 (花費時間20小時, 練習快速建立)

1. 專案下載： git clone https://github.com/Arnold6666/fortune.git
2. 環境初始化： 
    composer install
    copy .env.example .env
    php artisan key:generate
3. 資料庫建立： php artisan migrate ，如有產生以下警告，回答yes 即可生成名為 Blog 的資料庫
` WARN  The database 'blog' does not exist on the 'mysql' connection. ` 
` Would you like to create it? (yes/no) [no]`
4. 產生假資料： php artisan db:seed --class=DatabaseSeeder
5. 運行專案： php artisan serve
6. 連線網址：http://127.0.0.1:8000
7. 可以透過首頁右上角的註冊，註冊後方可新增修改刪除文章與留言，僅可對於自己的文章與留言編輯與刪除