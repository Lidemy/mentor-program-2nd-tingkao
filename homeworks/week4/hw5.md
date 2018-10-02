## 什麼是 DOM？
DOM (Document Object Model，文件物件模型)，是一個將 HTML 文件以樹狀的結構來表示的模型。

## 什麼是 Ajax？
clien 端可以透過它直接發 request 跟 server 端交換資料，可以更改網頁的部分內容就好，不用像一般的 request 得到的 response 需要更改或重新載入整個網頁。

## HTTP method 有哪幾個？有什麼不一樣？
有很多種，常用的就六七種，基本上最常使用 get 跟 post
- get // 查看資料
- post // 比對資料，ex: 登入，要post 帳號密碼到 server
- patch // 更改資料，ex: 更改會員資料
- put // 換新整個資料
- delete //  刪除資料
- options // 看 Server 支援哪些 methods 
- head // 跟 get 一樣，只是 Response 沒有 body / 比較常用在測試一些東西

## GET 跟 POST 有哪些區別，可以試著舉幾個例子嗎？
- Get 是透過網址傳遞 request 的內容，適合傳遞公共頁面的資料(每個人看到的都一樣）
- Post 是透過 request body 存取 request 的內容，適合傳遞較敏感性的資料

## 什麼是 RESTful API？
- RESTful API是一種設計風格，這種風格使API設計具有整體一致性，易於維護、擴展，並且充份利用HTTP協定的特點。
- 運用明確的 HTTP methods，可以從 methods 就知道該功能是什麼。
- 依照該規範，設計出一個不需要太多說明文檔即可讓使用者快速理解且使用的 API 。

## JSON 是什麼？
一種常被用來交換資料的檔案格式，跟 JS 的物件長的有點像，只是 JSON 的 key 跟 value 都必須以雙引號包覆，為文字型態。

## JSONP 是什麼？
- 只能透過 get 的方式取得資料
- 透過 html 標籤屬性可以載入不同網域的特性
例如：<a>/<img>/<link>/<script> 裡面的 src 和 href 都是用於外部資源的引入，像圖片、CSS文件、HTML文件、js文件或其他web頁面等。
透過 <script> 載人一段網址並發出 request 到伺服器端。且該網址帶有一個 callback function，伺服器執行該 function 將所要傳遞的資料透過參數的方式帶回來

## 要如何存取跨網域的 API？
該 api 設有 CORS 或是使用 JSONP 的方式
