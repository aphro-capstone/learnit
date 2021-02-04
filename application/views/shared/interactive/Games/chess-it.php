
<link rel="stylesheet" type="text/css" href="<?=site_url();?>assets/css/interactiveCSS/chess-it.css"/>

<div class="wrapper" id="chess-it">

    <div class="option-nav">
        <div id="player-nav">
            Player: <span id="player"></span>
        </div>
        <div id="option" class="btn">
            <i class="fa fa-cog" aria-hidden="true"></i>
            <span class="tooltiptext">OPTION</span>
        </div>
        <div id="undo-btn" class="btn">
            <i class="fa fa-undo" aria-hidden="true"></i>
            <span class="tooltiptext">UNDO</span>
        </div>
    </div>
    <div id="board">
        <div id="result" class="hide"></div>
        <div id="pawn-promotion-option" class="hide">
            <span id="queen" class="option"></span>
            <span id="rook" class="option"></span>
            <span id="knight" class="option"></span>
            <span id="bishop" class="option"></span>
        </div>
        <div id="option-menu" class="hide">
            <div id="back-btn" class="button">BACK</div>
            <div id="theme-menu">
                THEME: <span id="theme-option" class="button"></span>
            </div>
            <div id="color-menu">
                COLOR: <span id="color-option" class="button"></span>
            </div>
            <div id="restart-btn" class="button">NEW GAME</div>
        </div>
        <div id="game" >
            
        </div>
    </div>


</div>