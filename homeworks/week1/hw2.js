function capitalize(str) {
    var fst_letter = str[0]
    var fst_word = str.split(' ')[0]
    var other_words = ''
    var word = ''
    if('A'<= fst_letter && fst_letter <='z'){
      for(var i=1; i<fst_word.length ; i++){
          other_words = other_words + fst_word[i]
      }
      word = fst_letter.toUpperCase() + other_words
      return word
    }else{
      return fst_word
    }
  }
  
  console.log(capitalize('hello word!'))
  console.log(capitalize('!!hey u'))