<link rel="stylesheet" type="text/css" href="<?=site_url();?>assets/css/interactiveCSS/hangman.css"/>

<div class="wrapper" id="hangman">
   <h1>Hangman</h1> 
    <p>Use the alphabet below to guess the word, or click hint to get a clue. </p>
    <div id="buttons">
    </div>  
    <p id="catagoryName"></p>
    <div id="hold">
    </div>
    <p id="mylives"></p>
    <p id="clue">Clue -</p>  
     <canvas id="stickman">This Text will show if the Browser does NOT support HTML5 Canvas tag</canvas>
    <div class="container">
      <button id="hint">Hint</button>
      <button id="reset">Play again</button>
    </div>

  </div> 