
let allDone = true
let submitTimes = 0

function check(){
    // 判斷有沒有全部都填寫了
    document.querySelectorAll('.done').forEach( function(el){
        if(el.value === '' || allDone === false){
            allDone = false
        }else {
            allDone = true
        }})
        console.log(allDone)
}

function addWarning(){
    // 沒有填寫的要增加警告
    if(allDone === false){
        document.querySelectorAll('.done').forEach( function(el){
            // 一個一個判斷
            if(el.value !== ''){
                // 不是空格
                el.classList.add('isDone')
            }else{
                // 如果是空格
                el.classList.remove('isDone')
            }
            if(!el.classList.contains('isDone') && !el.classList.contains('hasWarning')){
                // 如果是空格，而且沒有紅色警告，加警告
                let node = document.createElement('div')
                node.classList.add('warning')
                node.innerText = '這是必填問題'
                el.parentNode.appendChild(node)
                el.parentNode.style.backgroundColor = 'rgba(255, 219, 225, 0.6)'
                el.classList.add('hasWarning')
                // class hasWarning 標示有加了警告
                // class isDone 標示有填寫資料
            }
        })
    }
}

document.querySelector('.submit__btn').addEventListener('click',function(){
    submitTimes += 1    
    allDone = true
    check()
    addWarning()
    console.log(allDone)

    if(allDone){
        alert('submited!!')
        document.querySelectorAll('.item').forEach(function(e){
            console.log(`${e.innerText}:${e.parentNode.querySelector('input').value}`)
        })
        document.querySelectorAll('li > input').forEach(function(e){
            e.value = ''
        })
        // window.location.reload() => 重新載入頁面
    }else{
        alert('error!')
    }    
},false)

document.querySelectorAll('.done').forEach(function(el){
    // 點擊輸入框時，移除必填效果
    el.addEventListener('click',function(){
        if(submitTimes >= 1){
            el.parentNode.removeChild(el.parentNode.querySelector('.warning'))
            el.parentNode.style.backgroundColor = '#fff'
            // 重新判斷
            el.classList.remove('isDone')
            el.classList.remove('hasWarning')
        }
    },false)
})
