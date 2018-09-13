function isPalindromes(str) {
    var arr = str.split('')
    if(arr.reverse().join('') === str) return true
    else return false
}

module.exports = isPalindromes