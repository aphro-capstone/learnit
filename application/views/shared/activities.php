 

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
			<div class="slick-container" id="games-list-container">
				<div class="game-box modal-games-trgr" data-type="typing-it">
					<div class="img-container">
							<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/pic.jpg" alt="">
					</div>
					<div class="backtext">
						<span> Typing IT </span>
					</div>
				</div>
				<div class="game-box modal-games-trgr" data-type="checker-it">
					<div class="img-container">
							<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/checkers.png" alt="">
					</div>
					<div class="backtext">
						<span> Checkers IT </span>
					</div>
				</div>
				<div class="game-box modal-games-trgr" data-type="scrabble-it">
					<div class="img-container">
						<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/pic2.jpg" alt="">
					</div>
					<div class="backtext">
						<span> Scrabble IT </span>
					</div>
				</div>
				<div class="game-box modal-games-trgr" data-type="hangman">
					<div class="img-container">
							<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/hangman.jpg" alt="">
					</div>
					<div class="backtext">
						<span> Hang IT </span>
					</div>
				</div>
				<div class="game-box modal-games-trgr"  data-type="chess-it">
					<div class="img-container">
							<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/chess-it-bg.jpg" alt="">
					</div>
					<div class="backtext">
						<span> Chess IT </span>
					</div>
				</div>
				<div class="game-box modal-games-trgr" data-type="tictactoe-it">
					<div class="img-container">
						<img class="full-width" src="<?php echo base_url();  ?>/assets/images/games/tictac.png" alt="">
					</div>
					<div class="backtext">
						<span> Tic-Tac-Toe IT </span>
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
			<div class="slick-container" id="videosContainer">
				<?php foreach($multimedia as $media):  ?>
					<div class="game-box videobox" data-vid-id="<?= $media['m_id'];?>">
						<div class="img-container position-relative" data-src="<?=  __MULTIMEDIA_UPLOAD_PATH__. $media['m_path'];?>">
							<img class="full-width" src="<?= 'data:image/png;base64,' . $media['snapshot']; ?> " alt="">
							<div class="overlay-play-video">
								<i class="fa fa-play-circle-o"> </i>
							</div>
						</div> 
						<div class="bottomtext">
							<span class="title	"><?= $media['m_title'];?> </span>
							<div class="buttons"> 
								<span class="get-url"><i class="fa fa-globe" data-toggle="tooltip" data-placement="left" title="Get URL"></i></span>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
				 
			</div>
		</div>
	</div>
</div>


