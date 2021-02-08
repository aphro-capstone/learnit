

$(function(){
  setTimeout( function(){
    iniHangman();
  },2000);
})


let iniHangman = function () {
  var alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h',
        'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's',
        't', 'u', 'v', 'w', 'x', 'y', 'z'];
  
  var categories;         // Array of topics
  var chosenCategory;     // Selected catagory
  var getHint ;          // Word getHint
  var word ;              // Selected word
  var guess ;             // Geuss
  var geusses = [ ];      // Stored geusses
  var lives ;             // Lives
  var counter ;           // Count correct geusses
  var space;              // Number of spaces in word '-'

  // Get elements
  var showLives = document.getElementById("mylives");
  var showCatagory = document.getElementById("scatagory");
  var getHint = document.getElementById("hint");
  var showClue = document.getElementById("clue");



  // create alphabet ul
  var buttons = function () {
    myButtons = document.getElementById('buttons');
    letters = document.createElement('ul');

    for (var i = 0; i < alphabet.length; i++) {
      letters.id = 'alphabet';
      list = document.createElement('li');
      list.id = 'letter';
      list.innerHTML = alphabet[i];
      check();
      myButtons.appendChild(letters);
      letters.appendChild(list);
    }
  }
    
  
  // Select Catagory
  var selectCat = function () {
    if (chosenCategory === categories[0]) {
      catagoryName.innerHTML = "Category: Basic Parts of Computer System";
    } else if (chosenCategory === categories[1]) {
      catagoryName.innerHTML = "Category: Computer History Timeline";
    } else if (chosenCategory === categories[2]) {
      catagoryName.innerHTML = "Category: Viruses";
    }
  }

  // Create geusses ul
   result = function () {
    wordHolder = document.getElementById('hold');
    correct = document.createElement('ul');

    for (var i = 0; i < word.length; i++) {
      correct.setAttribute('id', 'my-word');
      guess = document.createElement('li');
      guess.setAttribute('class', 'guess');
      if (word[i] === "-") {
        guess.innerHTML = "-";
        space = 1;
      } else {
        guess.innerHTML = "_";
      }

      geusses.push(guess);
      wordHolder.appendChild(correct);
      correct.appendChild(guess);
    }
  }
  
  // Show lives
   comments = function () {
    showLives.innerHTML = "You have " + lives + " lives";
    if (lives < 1) {
      showLives.innerHTML = "Game Over";
      showAnswer();
    }
    for (var i = 0; i < geusses.length; i++) {
      if (counter + space === geusses.length) {
        showLives.innerHTML = "You Win!";
      }
    }
  }

  var showAnswer = function(){
    $.confirm({
      title:'Game Over!',
      type : 'red',
      content : 'You failed to guess the word. The word is <strong>'+ word +'</strong>'
    });

    $('#my-word li.guess').each(function(a,b){
      if(  $(this).text() == '_' ){
        $(this).text( word.charAt(a) );
      }
    });

    $('#alphabet li').each(function(a,b){
      $(this).addClass('active');
      $(this)[0].onclick = null;
    });
  }



      // Animate man
  var animate = function () {
    var drawMe = lives ;
    drawArray[drawMe]();
  }

  
   // Hangman
  canvas =  function(){

    myStickman = document.getElementById("stickman");
    context = myStickman.getContext('2d');
    context.beginPath();
    context.strokeStyle = "#fff";
    context.lineWidth = 7;
  };
  
    head = function(){
      myStickman = document.getElementById("stickman");
      context = myStickman.getContext('2d');
      context.beginPath();
      context.arc(120, 50, 10, 70, Math.PI*2, true);
      context.stroke();
    }
    
  draw = function($pathFromx, $pathFromy, $pathTox, $pathToy) {
    
    context.moveTo($pathFromx, $pathFromy);
    context.lineTo($pathTox, $pathToy);
    context.stroke(); 
}

   frame1 = function() {
     draw (0, 150, 70, 150);
   };
   
   frame2 = function() {
     draw (30, 0, 30, 600);
   };
  
   frame3 = function() {
     draw (30, 5, 150, 5);
     draw (30, 50, 70, 0);
   };
  
   frame4 = function() {
     draw (120, 0, 120, 40);
   };
  
   torso = function() {
     draw (120, 60, 120, 100);
   };
  
   rightArm = function() {
     draw (120, 70, 135, 90);
   };
  
   leftArm = function() {
     draw (105, 90, 120, 70);
   };
  
   rightLeg = function() {
     draw (120, 90, 130, 120);
   };
  
   leftLeg = function() {
     draw (110, 120, 120, 90);
   };
  
  drawArray = [rightLeg, leftLeg, rightArm, leftArm,  torso,  head, frame4, frame3, frame2, frame1]; 




  buttonClick = function(letter){
    var geuss = (this.innerHTML);
    if( letter != undefined){
      geuss = letter;
      found = false;
      $('#alphabet li:not(.active)').each(function(){
          console.log( $(this).text().toLowerCase(), letter.toLowerCase()  );
        if( $(this).text().toLowerCase().trim() == letter.toLowerCase().trim() ){

          $(this).addClass('active')
          $(this)[0].onclick = null;
          found = true;
          return false;
        }
      });

      if( !found ) return;
    }else{
      this.setAttribute("class", "active");
      this.onclick = null;
    }
      
      
      for (var i = 0; i < word.length; i++) {
        if (word[i].toLowerCase() === geuss.toLowerCase()) {
          geusses[i].innerHTML = geuss;
          counter += 1;
        } 
      }
      var j = (word.indexOf(geuss));
      if (j === -1) {
        lives -= 1;
        comments();
        animate();
      } else {
        comments();
      }
  }


  // OnClick Function
   check = function () {
    list.onclick = buttonClick;
    
    }
  // Play
  play = function () {
    categories = [
        ["Keyboard", "Mouse", "Central-Processing-Unit", "Hard-disk", "Floppy-disk",
         "Compact-disc", "Speakers", "Printer", "Monitor", "Web-camera", "Microphone"],
        ["The-First-Computer", "Transistor", "IBM", "Bank-Computers", "Computer-Chips", "Video-Games",
        "Invention-of-Mouse", "The-Internet", "Microsoft", "Microsoft-Expands", "Laptop", "World-Wide-Convention"],
        ["Iloveyou-virus", "File-Infecting-Virus", "Macro-Virus", "Browser-Hijacker", "Polymorphic-Virus", "Resident-Virus"]
    ];

    chosenCategory = categories[Math.floor(Math.random() * categories.length)];
    word = chosenCategory[Math.floor(Math.random() * chosenCategory.length)];
    word = word.replace(/\s/g, "-");
    console.log(word);
    buttons();

    geusses = [ ];
    lives = 10;
    counter = 0;
    space = 0;
    result();
    comments();
    selectCat();
    canvas();
  }

  play();
  
  // Hint

    hint.onclick = function() {

      hints = [
        ["Input Devices", "Input Devices", "Processing Device", "Storage Devices", "Storage Devices",
         "Storage Devices", "Output Devices", "Output Devices", "Output Devices", "Input Devices", "Input Devices"],
        ["1936", "1947", "1953", "1955", "1958", "1962", "1963", "1969", "1975", "1989", "1991", "1996"],
        ["Love Bug/Love Letter", "infects files with .exe or .com extensions", "Found in Microsoft Word or Excel",
         "Alters your browser setting", "Evade anti-virus programs", "Infect files on your computer"]
    ];

    var catagoryIndex = categories.indexOf(chosenCategory);
    var hintIndex = chosenCategory.indexOf(word);
    showClue.innerHTML = "Clue: - " +  hints [catagoryIndex][hintIndex];
  };

   // Reset

  document.getElementById('reset').onclick = function() {
    correct.parentNode.removeChild(correct);
    letters.parentNode.removeChild(letters);
    showClue.innerHTML = "";
    context.clearRect(0, 0, 400, 400);
    play();
  }

  var inputKeys = function(e){
    let key = e.which;
    if(key >= 65 && key <= 90){
      buttonClick(e.originalEvent.key);
    }
  }

  $(document).on('keyup',inputKeys);
}


