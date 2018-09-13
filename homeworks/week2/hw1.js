function stars(n) {
    var arr = []
    for(var i=0; i<n; i++){
        arr[i] = '*'.repeat(i + 1)
    }
    return arr
}

module.exports = stars;