function reverse(str) {
    var array = str.split('')
    var new_array = []
    for(var i =0; i<array.length ;i++){
        var letter = array[i]
        var number = (array.length - 1 - i)
        new_array[number] = letter
    }
    return new_array.join('')

}

console.log(reverse('yayayssdafgrheh'))