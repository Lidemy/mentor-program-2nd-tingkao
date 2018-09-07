function capitalize(str) {
    var fst_letter = str[0].toUpperCase()
    var other_words = ''
    var word = ''
    for(var i=1; i<str.length ; i++){
      other_words += str[i]
    }
    word = fst_letter + other_words
    return word
  }
  
  // console.log(capitalize('hello word!'))
  // console.log(capitalize('!!hey u'))
  // console.log(capitalize('asdaknsjncwei'))