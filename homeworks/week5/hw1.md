
| Table             | 欄位名稱           | 欄位型態        | 說明            |
|-------------------|-------------------|---------------|----------------|
| tingkao_main      | id                | int(10)       | 主留言序
|                    | mainCommenter     | varchar(32)   | 主留言者名稱
|                    | mainComment       | text          | 主留言內容
|                    | created_at        | datetime      | 留言時間
|                    | userId            | varchar (32)  | 使用者帳號

---

| Table     | 欄位名稱            | 欄位型態   | 說明            |
|-----------|--------------------|-----------|----------------|
|  tingkao_sub       | id                 | int       | 主留言序
|            | subCommenter       | varchar (32)  | 次留言者名稱
|            | subComment         | text      | 次留言內容
|            | created_at         | datetime  | 留言時間
|            | userId          | varchar (32)  | 使用者帳號

---

| Table             | 欄位名稱            | 欄位型態   | 說明            |
|-------------------|--------------------|-----------|----------------|
|  tingkao_user      | ind              | int        | id
|                    | userId          | varchar (32)  | 使用者帳號
|                    | userPassword      | varchar (32)   | 使用者密碼
|                    | userNickname      | varchar (32)   | 使用者暱稱

- 使用者帳號跟 留言者名稱（帳號、暱稱、自己更改或輸入的稱號） 不一定會一樣，因爲沒有設定暱稱的 value 不能更改
