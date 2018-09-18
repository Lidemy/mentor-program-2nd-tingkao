## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。
<hr> // 分隔線
<br> // 斷行
<strong></strong> // 強調並顯示粗體
<em></em> // 強調並顯示斜體

## 請問 display: inline, block 跟 inline-block 的差別是什麼？
block // 可設定寬高，但是佔據的位置是一整列
inline // 不能設定寬高，大小依內容 content 大小而定，可以併排
inline-block // 可設定寬高，可以併排

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？
static 為預設值，依據元素本身的狀態和順序排列位置(不能使用 top/bottom/left/right )
relative 依據元素本身原始的位置可以設定 top/bottom/left/right，來設定相對位置(以自己為準)
absolute 依據父層有設定 position 的元素可以設定 top/bottom/left/right，來設定絕對位置(以有設 position 的父層為準)
fixed 依據螢幕視窗的位置來設定 top/bottom/left/right，並且永遠保持在該位置，即便滾輪滾動(以視窗為準)

