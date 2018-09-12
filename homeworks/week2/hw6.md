## hw1：好多星星
一開始沒有想到用 repeat ，在苦惱怎麼塞星星進陣列
用下面的方法印出 n 個星星。

var str = ''
for(var i=0; i<n; i++){
    str += '*'
}

在想還要再包一個 forloop 的時候想到了 repeat 和 arr[i] 的方式來塞東西，
程式碼就簡化了好多...


## hw2：大小寫互換
這個部分用兩次 if 跟如果第二行用了 else if 會有語意上的差別嗎?
好像比較像是上下是有關連性的判斷?
因為一開始是寫了兩次 if ，但後來想想好像可以用 else if
但是在排列上，兩個 if 看起來好像比較整齊XD

if('A' <= e && e <= 'Z') return e.toLowerCase()
if('a' <= e && e <= 'z') return e.toUpperCase()
else return e

if('A' <= e && e <= 'Z') return e.toLowerCase()
else if('a' <= e && e <= 'z') return e.toUpperCase()
else return e


## hw3：判斷質數
這題在寫的時候思考了一下 function 的名稱如果跟裡面的變數名稱一樣的話會不會有問題
後來證實應該沒問題，因為 scope 作用範圍
但是在語意上因為剛好 isPrime 是較適合的，在一般的變數使用上，會盡量不這樣重覆嗎?

然後一開始把 return isPrime 放到 for 迴圈裡面了， debug 找很久
在 forloop 裡面我記得是不能用 return 的，return 在 forloop 裡面只是無效嗎? 因為在 console.log 的時候不會有錯誤
只是答案不對，但就因為這樣找 bug 找很久...


## hw4：判斷迴文
這題用了 reverse 所以快很多


## hw5：大數加法
這題算是比較複雜一點的題目，
明顯發現自己在函式的使用上還是很不熟悉，
比如一開始在
var aArr = a.split('')
會忘記去把參數 a 轉為字串再使用

相同問題，一開始也用了 a.length
後來經過 debug 才改為 aArr.length

目前也還沒辦法一次精準地寫出程式碼，
必須一行一行的 console.log 出來看是否達到自己預期的東西... 然後再去調整

雖然在解題時，分解問題跟列出步驟邏輯上還可以，
但是覺得要花很多時間去把自己想成電腦，一行一行推算結果跟找出錯誤