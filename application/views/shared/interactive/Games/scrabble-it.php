<div class="overlay"></div>

<div class="wrapper">
<div id="scrabble-div">
    <h1>Guess The Number</h1> 
    <p>We have selected a random number between 1 - 10.  
    See if you can guess it.</p> 
      
    <div class="form"> 
        <label for="guessField">Enter a guess: </label> 
        <input type = "text" id = "guessField" class = "guessField"> 
        <input type = "submit" value = "Submit guess" 
               class = "guessSubmit" id = "submitguess"> 
    </div>

</div>
</div>

  
<script type = "text/javascript"> 
  
    // random value generated 
    var y = Math.floor(Math.random() * 10 + 1); 
      
    // counting the number of guesses 
    // made for correct Guess 
    var guess = 1; 
      
    document.getElementById("submitguess").onclick = function(){ 
      
   // number guessed by user      
   var x = document.getElementById("guessField").value; 
  
   if(x == y) 
   {     
       alert("CONGRATULATIONS!!! YOU GUESSED IT RIGHT IN "
               + guess + " GUESS "); 
   } 
   else if(x > y) /* if guessed number is greater 
                   than actual number*/ 
   {     
       guess++; 
       alert("OOPS SORRY!! TRY A SMALLER NUMBER"); 
   } 
   else
   { 
       guess++; 
       alert("OOPS SORRY!! TRY A GREATER NUMBER") 
   } 
} 
</script> 