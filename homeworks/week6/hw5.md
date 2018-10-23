## 請說明 SQL Injection 的攻擊原理以及防範方法

- 攻擊原理：
void queryDB(string name){
    string sql = "select * from users where name = '" + name + "'";
    doQuery(sql);
}
SQL 語法如上，name 這個變數如果是使用者所輸入的內容，如果數用者輸入： Steve
那 sql 就是 “select * from users where name = Steve”
如果 server 拿到的 name 是 John or 1 = 1，那 sql 就是 “select * from users where name = John or 1 = 1”。
因為 where 的 condition always true。上述 sql 回傳 database 的所有 row 的所有 column。
攻擊者可以輸入自設的條件或是乾脆終止原本的 sql 指令，去執行其他 sql 指令，例如：刪除整個 table

- 防範方法：
1. 把 web server 的 error log 關起來(不要 return 給 client 端)。不要讓任何訊息洩露。
如果沒關起來，hacker 大概隨便試兩次就知道你的 table name 了。

2. 做好 validate user input。 
採用 參數化查詢（Parameterized Query或Parameterized Statement）是指在設計與資料庫連結並存取資料時，在需要填入數值或資料的地方，使用參數（Parameter）來給值。
在使用參數化查詢的情況下，資料庫伺服器不會將參數的內容視為SQL指令的一部份來處理，而是在資料庫完成SQL指令的編譯後，才套用參數執行，因此就算參數中含有具破壞性的指令，也不會被資料庫所執行。

$stmt = $conn->prepare("SELECT `欄位` FROM `table_name` WHERE `欄位`=?");
$stmt->bind_param("s", 實際要帶入 ? 的值);  //此處的 "s" 為 string 的意思
$stmt->execute();

## 請說明 XSS 的攻擊原理以及防範方法

- 攻擊原理：
利用可以在網頁 comment，comment 一段實際可以執行的程式碼
在別人的網頁上執行 JavaScript
只要能執行 JavaScript，就能做任何事
1. 竄改頁面
2. 竄改連結
3. 偷 Cookie

- 防範方法：escape，跳脫
htmlspecialchars($str, ENT_QUOTES, ‘utf-8’)，把輸入的程式碼轉為不能執行的純字串

## 請說明 CSRF 的攻擊原理以及防範方法 (Cross Site Request Forgery)
https://blog.techbridge.cc/2017/05/07/owasp/

- 攻擊原理：
基本上我們跟 server 能做的互動，取決於 server 開放給我們的權限。
比如說 A 可以轉錢到別人信箱，可是不能改 B 的密碼，也不能把 C 的錢轉給自己。

可是今天要是有權限的話就不一樣了，什麼時候會有權限呢？就是你的 cookie/session 還有效的時候(比如你現在開 facebook 不用輸入密碼，因為你 cookie 還有效)，讓你在你不知情的情況下送 http request。

這就是你很常收到垃圾郵件或惡意郵件的時候，他都會要你點個 link，那絕不是只是要你點廣告衝流量而已。如果你點了，剛好你另外一個網站(比如銀行)的 cookie 沒有到期，他就可以假裝是你，送 http request。

- CSRF 防範方法：
1. 一個 request 過來前先看一下他的 header，先看 Origin 的值跟現在這個網頁的網址或 Domain 一不一樣，沒有 Origin 值就看 Referer值。不一樣的話就很可能是CSRF。
2. 對於非 get 的重要 request，要求提供驗證碼，或是重新驗證使用者。

## 請舉出三種不同的雜湊函數

常見演算法
SHA 系列：
    SHA-0
    SHA-1 已經被證明不夠安全。（在可接受的時間範圍內，可以找到內容不相同輸入卻得到相同輸出。）
    SHA-2 目前普遍使用 SHA-2
        SHA-256
        SHA-512
    SHA-3
        SHA3-256
        SHA3-512
MD5：
MD5 也已經被證明不夠安全。（在可接受的時間範圍內，可以找到內容不相同輸入卻得到相同輸出。）
BLAKE2

## 請去查什麼是 Session，以及 Session 跟 Cookie 的差別

- Cookie 是用來暫時儲存使用者資料的技術應用，儲存資料於用戶端
儲存資料於 clien 端，並於每次對相同 domain 發送 request 的時候帶上所有 cookie 紀錄的資料

Cookie的時效：
可自行由程式設定，若無設定則為一次瀏覽時間（瀏覽器關閉後失效）

- Session 是一種儲存使用者資料的機制，儲存資料於伺服器端(或是存到資料庫，但是一般都存在伺服器端，效能較好)
儲存資料於 server 端，然後回傳一個 session id 到 clien 端，作為一個之後取得所存資料的認證，
可配合 cookie 使用將 session id 存在 cookie，並於每次對相同 domain 發送 request 的時候帶上該 session id，以取得相關的儲存資料

Session的時效有兩個：
1.在一段時間（須看伺服器設定）與伺服器無連線的狀況之下會失效。
2.一次瀏覽時間（瀏覽器關閉後失效）

## `include`、`require`、`include_once`、`require_once` 的差別

include 和 include_once
都是用來引入檔案，後者可避免重複引入，故建議用後者。引不到檔案會出現錯誤息，但程式不會停止。
require 和 require_once
都是用來引入檔案，後者可避免重複引入，故建議用後者。引不到檔案會出現錯誤息，而且程式會停止執行。