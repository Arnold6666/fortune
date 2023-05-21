# fortune 使用手冊
Test for Interview

1. 專案下載： git clone https://github.com/Arnold6666/fortune.git
2. 環境初始化： 
composer install
copy .env.example .env
php artisan key:generate
3. 資料庫建立： php artisan migrate ，如有產生以下警告，回答yes 即可生成名為 Blog 的資料庫
` WARN  The database 'blog' does not exist on the 'mysql' connection. ` 
` Would you like to create it? (yes/no) [no]`
4. 若 mysql 的 my.ini 檔案中的 max_allowed_packet 上限不夠，可能會造成圖片無法成功上傳，若圖片上傳失敗可以修改其上限。
5. 產生假資料： php artisan db:seed --class=DatabaseSeeder
6. 運行專案： php artisan serve
7. 連線網址：http://127.0.0.1:8000
8. 可以透過首頁右上角的註冊，註冊後方可新增修改刪除文章與留言，僅可對於自己的文章與留言編輯與刪除