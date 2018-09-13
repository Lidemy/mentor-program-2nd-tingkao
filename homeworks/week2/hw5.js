function add(a, b) {
    var numLength
    var aArr = a.split('')
    var bArr = b.split('')
    var newArr = []
    if(a.length >= b.length){
        numLength = a.length
        for(var i=0; i<numLength - b.length; i++){
            bArr.unshift('0')
        }
    }
    else {
        numLength = b.length
        for(var i=0; i<numLength - a.length; i++){
            aArr.unshift('0')
        }
    }
//     console.log(aArr ,bArr)
    for(var i=0; i<numLength; i++){
        newArr[i] = Number(aArr[i]) + Number(bArr[i])
    }
//     console.log(newArr)
    for(var i = numLength - 1 ; i > 0; i--){
      if( newArr[i] >= 10){
            newArr[i - 1] = newArr[i - 1] + 1
        }
    }
    console.log(newArr)
    newArr.map(function(e, i){
        if(i > 0 && e >= 10){
            newArr[i] = newArr[i].toString()[1]
        }
        else newArr[i] = newArr[i].toString()
    })
    return newArr.join('')
}


module.exports = add;