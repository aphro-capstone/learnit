


<div class="overlay"></div>


<div class="wrapper" id="typing-it-wrapper">
		<h1> Type IT</h1>
		<p>Type as many words as you can until time runs out!</p>

		<button class="start btn-outline-secondary col-sm-3 col-md-3">
			<label class="col-sm-12 col-md-12 col-form-label mt-2">
				 START
			</label>
		</button>
	
	<div class="custom-select">
			<!-- <select name="difficulty outline-secondary"> -->
		<select name="difficulty">
			<option value="">  Select Difficulty </option>
			<option value="1">Easy ( 1p each )</option>
			<option value="2">Moderate ( 2p each ) </option>
			<option value="3">Hard ( 3p each )</option>
		</select>
	</div>
		<div class="outerWrap">
			<div class="scoreWrap">
				<div class="scoreboard">
					<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/score.png" alt="">
				<div class="score-div">
					<p class="mb-0">Score</p>
					<span class="score">0</span>	
				</div>
				
			</div>
		</div>

			<div class="timeWrap">
				<div class="scoreboard">
					<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/score.png" alt="">
				<div class="time-div">
					<p class="mb-0">Time</p>
					<span class="score">60</span>
				</div>
			</div>
		</div>
		<div class="wordsWrap">
			<p class="words"></p>
		</div>
</div>
 