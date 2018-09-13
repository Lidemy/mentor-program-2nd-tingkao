function alphaSwap(str) {
    var arr = str.split('')
    var newarr = arr.map(function(e, i){
        if('A' <= e && e <= 'Z') return e.toLowerCase()
        else if('a' <= e && e <= 'z') return e.toUpperCase()
        else return e
    })
    return newarr.join('')
}

module.exports = alphaSwap