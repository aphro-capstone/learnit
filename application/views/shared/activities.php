<!-- head -->
<div class="row" id="picact">
	<div class="overlay"></div>
	<div class="container">
		<div class="title">
			<span>Educational Games & Videos</span>
		</div>
	</div>
</div>

<div class="container"> 
	<!-- Games -->
	<div class="panel full-width panel2 mb-5">
		<div class="panel-heading has-ribbon-header">
			<div class="ribbon left-ribbon ribbon-primary ribbon1 title-ribbon">
				<div class="content">
					<span class="">   Games  </span> 
				</div>
			</div>
		</div>
		<div class="panel-content mt-4">
			<div class="row">
				<div class="col-sm-12 col-md-6 col-lg-4">

					<div class="game-box modal-games-trgr" data-type="typing-it">
						<div class="img-container">
								<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/pic.jpg" alt="">
						</div>
						<div class="backtext">
							<span> Typing IT </span>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4">
					<div class="game-box modal-games-trgr" data-type="quiz-it">
						<div class="img-container">
								<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/pic3.png" alt="">
						</div>
						<div class="backtext">
							<span> Checker </span>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4">
					<div class="game-box modal-games-trgr" data-type="scrabble-it">
						<div class="img-container">
							<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/pic2.jpg" alt="">
						</div>
						<div class="backtext">
							<span> Scrabble IT </span>
						</div>
					</div>
				</div>

			<div class="col-sm-12 col-md-6 col-lg-4">

					<div class="game-box modal-games-trgr" data-type="hangman">
						<div class="img-container">
								<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/hangman-small.jpg" alt="">
						</div>
						<div class="backtext">
							<span> Hangman </span>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4">
					<div class="game-box modal-games-trgr"  data-type="chess-it">
						<div class="img-container">
								<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/chess-it-bg.jpg" alt="">
						</div>
						<div class="backtext">
							<span> Chess IT </span>
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-6 col-lg-4">
					<div class="game-box modal-games-trgr">
						<div class="img-container">
							<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/pic2.jpg" alt="">
						</div>
						<div class="backtext">
							<span> Scrabble IT </span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<!-- Videos -->
	<div class="panel full-width panel2">
		<div class="panel-heading has-ribbon-header">
			<div class="ribbon left-ribbon ribbon-primary ribbon1 title-ribbon">
				<div class="content">
					<span class="">   Videos  </span> 
				</div>
			</div>
		</div>
		<div class="panel-content mt-4">
			<div class="row">
				<?php foreach($multimedia as $media):  ?>
					<div class="col-sm-12 col-md-4 col-lg-4">
						
						<div class="game-box videobox" data-src="<?=  __MULTIMEDIA_UPLOAD_PATH__. $media['m_path'];?>">
							<div class="img-container">
								<img class="full-width" src="<?= 'data:image/png;base64,' . $media['snapshot']; ?> " alt="">
							</div>
							<div class="backtext">
								<i class="fa fa-play-circle">
									</i>
								<span><?= $media['m_title'];?> </span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				 
			</div>
		</div>
	</div>
</div>


