
<link rel="stylesheet" type="text/css" href="<?=site_url();?>assets/css/interactiveCSS/checker-it.css"/>

<div class="wrapper" id="checker-it">
    <div class="column">

        <div class="stats">
          <h2>Game Statistics</h2>
            <div class="wrapper">
                <div id="player1">
                    <h3>Player 1 (Top)</h3>
                </div>
                <div id="player2">
                    <h3>Player 2 (Bottom)</h3>
                </div>
            </div>
            <div class="clearfix"></div>
                <div class="turn"></div>
                    <span id="winner"></span>
                <button id="cleargame">Reset Game</button>
        </div>
      </div>

    <div class="column">
        <div id="board">
          <div class="tiles"></div>
            <div class="pieces">
                <div class="player1pieces"></div>
                <div class="player2pieces"></div>
            </div>
        </div>
    </div>
</div>