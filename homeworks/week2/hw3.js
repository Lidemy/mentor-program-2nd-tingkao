function isPrime(n) {
    var arr = []
    var isPrime = false

    if(n === 2 || n === 3) isPrime = true
    else if(n > 3){
        for(var i=2; i<n; i++){
            arr.push(i)
        }
        // console.log(arr)
        for(var i=0; i<n - 2; i++){
            if(n % arr[i] === 0){
                isPrime = false
                break
            }
            else{
                isPrime = true
            }
        }
    }
    return isPrime
}



module.exports = isPrime