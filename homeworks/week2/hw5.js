function add(a, b) {
    var numLength
    var aArr = a.toString().split('')
    var bArr = b.toString().split('')
    var newArr = []
    if(aArr.length >= bArr.length){
        numLength = aArr.length
        for(var i=0; i<numLength - bArr.length; i++){
            bArr.unshift('0')
        }
    }
    else {
        numLength = bArr.length
        for(var i=0; i<numLength - aArr.length; i++){
            aArr.unshift('0')
        }
    }
//     console.log(aArr)
    for(var i=0; i<numLength; i++){
        newArr[i] = Number(aArr[i]) + Number(bArr[i])
    }
//     console.log(newArr[1])
    newArr.map(function(e, i){
        if(i > 0 && e >= 10){
            newArr[i - 1] = newArr[i - 1] + 1
        }
    })
//     console.log(newArr)
    newArr.map(function(e, i){
        if(i > 0 && e >= 10){
            newArr[i] = newArr[i].toString()[1]
        }
    })
    return newArr.join('')
}


module.exports = add;