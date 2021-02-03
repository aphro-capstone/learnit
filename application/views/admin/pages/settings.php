
<div class="row">
	<div class="col col-sm-12 col-lg-12 col-md-12">
		<div class="panel">
			<div class="panel-heading d-table full-width">
				<h3 class="pull-left">Year Level</h3>
				<a href="#addGrades" class="btn btn-primary pull-right" data-toggle="modal"> <i class="fa fa-plus"> Add Grade </i> </a>
			</div>
			<div class="panel-content mt-4">
				<div class="dataTable-container">
					<table class="table table-bordered table-hover dataTable" data-table="grade" data-modal="#addGrades">
						<thead>
							<tr>
								<th>ID</th>
								<th>Year Lvl Name</th>
								<th>Date Created</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($grades as $row): ?>
								<tr class="data-row" data-id="<?= $row['g_id']; ?>" data-key="g_id">
									<td data-ref="id" class="text-center"> <?= $row['g_id'] ?> </td>
									<td data-ref="grade"> <?= $row['g_name'] ?> </td>
									<td> <?= date_format( date_create($row['timestamp_created']), 'Y/m/d @ h:i a') ?> </td>
									<td class="text-center">
										<a href="#" class="btn btn-xs btn-info editItem btn-3d"> <i class="fa fa-edit"></i> Update</a>
										<a href="#" class="btn btn-xs btn-danger removeItem btn-3d"> <i class="fa fa-trash"></i> Delete</a>
									</td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
</div>

<div class="row mt-4">
	<div class="col col-sm-12 col-lg-12 col-md-12">
		<div class="panel">
			<div class="panel-heading d-table full-width">
				<h3 class="pull-left">Colors</h3>
				<a href="#addColor" class="btn btn-primary pull-right btn-3d" data-toggle="modal"> <i class="fa fa-plus"> Add Color </i> </a>
			</div>
			<div class="panel-content mt-4">
				<div class="dataTable-container">
					<table class="table table-bordered table-hover dataTable" data-table="colors" data-modal="#addColor">
						<thead>
							<tr>
								<th class="text-center">ID</th>
								<th class="">Color Name</th>
								<th class="">Color</th>
								<th class="">Text Color</th>
								<th class="">Date Created</th>
								<th class="text-center">Actions</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($colors as $row): ?>
								<tr class="data-row" data-id="<?= $row['sc_id']; ?>" data-key="sc_id">
									<td  data-ref="id" class="text-center"> <?= $row['sc_id'] ?> </td>
									<td  data-ref="name" > <?= $row['sc_name'] ?> </td>
									<td  data-ref="color" data-ref-val="<?=$row['sc_color']?>" class="color-preview-container"> 
										<span class="color-preview" style="background:<?=$row['sc_color']?>"></span>
										<?= $row['sc_color'] ?> </td>
									<td  data-ref="tcolor" data-ref-val="<?=$row['sc_text_color']?>" class="color-preview-container"> 
										<span class="color-preview" style="background:<?=$row['sc_text_color']?>"></span>
										<?= $row['sc_text_color'] ?> </td>

									<td> <?= date_format( date_create($row['timestamp_created']), 'Y/m/d @ h:i a') ?> </td>
									<td class="text-center">
										<a href="#" class="btn btn-xs btn-info editItem btn-3d"> <i class="fa fa-edit"></i> Update</a>
										<a href="#" class="btn btn-xs btn-danger removeItem btn-3d"> <i class="fa fa-trash"></i> Delete</a>
									</td>
								</tr>
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row mt-4">
	<div class="col col-sm-12 col-md-12 col-lg-12">
		<div class="panel">
			<div class="panel-heading d-table full-width">
				<h3 class="pull-left">Subjects</h3>
				<a href="#addSubject" class="btn btn-primary pull-right btn-3d" data-toggle="modal"> <i class="fa fa-plus"> Add Subject </i> </a>
			</div>
			<div class="panel-content mt-4">
				<div class="dataTable-container">
					<table class="table table-bordered table-hover" data-table="subject" data-modal="#addSubject">
						<thead>
							<tr>
								<th>ID</th>
								<th>Subject</th>
								<th> Sub-Subject</th>
								<!-- <th>Parent Subject</th> -->
								<th>Abbr</th>
								<!-- <th>Desc</th> -->
								<th>Date Created</th>
								<th>Actions </th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($subject as $row): ?>
							<?php $subsubjects = getSubSubject($row['s_id']); ?>
								<tr class="data-row has-hidden-rows" data-id="<?= $row['s_id']; ?>" data-key="s_id">
									<td data-ref="id" class="text-center"> <?= $row['s_id'] ?> </td>
									<td data-ref="name"> <?= $row['s_name'] ?> </td>
									<td class="hasBtn" data-ref="parentSubject" data-ref-val="<?= $row['s_parent_sub']; ?>"> 
										<?php if( $subsubjects->num_rows() > 0 ): ?>
											<button class="btn btn-xs btn-info btn-3d toggle-subsubjects full-width"> Show Sub-subjects  </button>
										<?php endif; ?>									
									</td>
									<td data-ref="abbre"> <?= $row['s_abbre'] ?> </td>
									<!-- <td data-ref="desc" class="text-center notdirecttext "> <?php // echo $row['s_desc'] ? '<button  class="btn btn-info btn-xs gettext" data-toggle="tooltip" data-placement="top" data-original-title="'. $row['s_desc']  .'"> <i class="fa fa-question-circle"></i> </button>' : ''; ?>  </td> -->
									<td> <?= date_format( date_create($row['timestamp_created']), 'Y/m/d @ h:i a') ?> </td>
									<td class="text-center">
										<a href="#" class="btn btn-xs btn-info editItem btn-3d"> <i class="fa fa-edit"></i> Update</a>
										<a href="#" class="btn btn-xs btn-danger removeItem btn-3d"> <i class="fa fa-trash"></i> Delete</a>
									</td>
								</tr>
								<?php foreach (getSubSubject($row['s_id'])->result_array() as $subsubject): ?>
									<tr class="data-row hidden-row data-subsubject" data-parent-id="<?=$subsubject['s_parent_sub'];?>" data-id="<?= $subsubject['s_id']; ?>">
										<td data-ref="id" data-ref-val="<?=$subsubject['s_id']?>">  </td>
										<td data-ref="name" data-ref-val="<?=$subsubject['s_name']?>"></td>
										<td data-ref="parentSubject" data-ref-val="<?= $subsubject['s_parent_sub']; ?>"> <?=$subsubject['s_name'] ?> </td>
										<td data-ref="abbre"> <?= $subsubject['s_abbre'] ?> </td>
										<!-- <td data-ref="desc" class="text-center notdirecttext "> <?php // echo $row['s_desc'] ? '<button  class="btn btn-info btn-xs gettext" data-toggle="tooltip" data-placement="top" data-original-title="'. $row['s_desc']  .'"> <i class="fa fa-question-circle"></i> </button>' : ''; ?>  </td> -->
										<td> <?= date_format( date_create($row['timestamp_created']), 'Y/m/d @ h:i a') ?> </td>
										<td class="text-center">
											<a href="#" class="btn btn-xs btn-info editItem btn-3d"> <i class="fa fa-edit"></i> Update</a>
											<a href="#" class="btn btn-xs btn-danger removeItem btn-3d"> <i class="fa fa-trash"></i> Delete</a>
										</td>
									</tr>
								<?php endforeach; ?>
								
							<?php endforeach;?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Do not dis[;ay for now.] -->
<?php if( false ): ?>
	<div class="row mt-4">
		<div class="col col-sm-12 col-md-12 col-lg-12">
			<div class="panel">
				<div class="panel-heading d-table full-width">
					<h3 class="pull-left">Post visibility</h3>
					<a href="#addAvailabilityModal" class="btn btn-primary pull-right" data-toggle="modal"> <i class="fa fa-plus"> Add Availability </i> </a>
				</div>
				<div class="panel-content mt-4">
					<div class="dataTable-container">
						<table class="table table-bordered table-hover dataTable" data-table="subject" data-modal="#addAvailabilityModal">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Roles</th>
									<th>Description</th>
									<th>Date Created</th>
									<th>Actions </th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($postavailability as $row): ?>
									<tr class="data-row" data-id="<?= $row['spa_id ']; ?>" data-key="spa_id ">
										<td data-ref="id" class="text-center"> <?= $row['spa_id '] ?> </td>
										<td data-ref="name"> <?= $row['spa_name'] ?> </td>
										<td data-ref="abbre"> <?= $row['spa_roles'] ?> </td>
										<td data-ref="desc" class="text-center notdirecttext "> <?php echo $row['spa_desc'] ? '<button  class="btn btn-info btn-xs gettext" data-toggle="tooltip" data-placement="top" data-original-title="'. $row['spa_desc']  .'"> <i class="fa fa-question-circle"></i> </button>' : ''; ?>  </td>
										<td> <?= date_format( date_create($row['timestamp_created']), 'Y/m/d @ h:i a') ?> </td>
										<td class="text-center">
											<a href="#" class="btn btn-xs btn-info editItem btn-3d"> <i class="fa fa-edit"></i> Update</a>
											<a href="#" class="btn btn-xs btn-danger removeItem btn-3d"> <i class="fa fa-trash"></i> Delete</a>
										</td>
									</tr>
								<?php endforeach;?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php endif; ?>
