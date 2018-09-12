function isPrime(n) {
    var arr = []
    var isPrime = false
    for(var i=2; i<=n; i++){
        arr.push(i)
    }
    for(var i=2; i<=n; i++){
        if(n % arr[i] === 0){
            isPrime = false
            break
        }else {
            isPrime = true
        }
    }
    return isPrime
}

module.exports = isPrime