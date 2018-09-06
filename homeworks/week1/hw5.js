function join(str, concatStr) {
  var newStr = str[0]
  for(var i = 1; i<str.length - 1 ; i++){
      newStr = newStr + concatStr + str[i]
  }
  return newStr
}

function repeat(str, times) {
  var newStr2 = ''
  for(var i=0; i<times; i++ ){
    newStr2 = newStr2 + str
  }
  return newStr2
}


console.log(join([1,2,3,4,5,6,7,8],'!!'))
console.log(repeat('hey', 5))