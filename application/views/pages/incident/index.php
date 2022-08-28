<!-- Content Header (Page header) -->
<div class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1 class="m-0">Incident</h1>
			</div><!-- /.col -->
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="javascript:void(0);">MS Ticket</a></li>
					<li class="breadcrumb-item active">Incident</li>
				</ol>
			</div><!-- /.col -->
		</div><!-- /.row -->
	</div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="card" id="secondCard">
					<div class="card-header">
						<h3 class="card-title">Incident List</h3>
						<?php if(!isItSupport()){ ?>
						<div class="card-tools">
							<button data-toggle="modal" data-target="#modalForm" class="btn btn-primary btn-xs"
								id="btnModal">
								<i class="fas fa-plus"></i> New Incident
							</button>
						</div>
						<?php } else { ?>
						<div class="card-tools">
							<a href="<?= base_url("incident/export") ?>" class="btn btn-success btn-xs">
								<i class="fas fa-fw fa-file-excel"></i> Export
							</a>
						</div>
						<?php } ?>
					</div>
					<!-- /.card-header -->
					<div class="card-body">
						<table id="tableData" class="table table-bordered table-hover">
							<thead>
								<tr>
									<th>Tracking No</th>
									<th>User Request</th>
									<th>Status</th>
									<th>Group/Ruangan</th>
									<th>IT Support</th>
									<th>Title/Summary</th>
									<th>Desc</th>
									<th>Service Type</th>
									<th>Urgency</th>
									<th>Created At</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									foreach($incident as $row){ 
								?>
								<tr>
									<td><?= $row->id ?></td>
									<td>
										<?php
												$user = $this->model_auth->getDataUser(['id' => $row->id_pengguna]);
												echo $user['nama'];
											?>
									</td>
									<td>
										<?php
												$s = @$status[$row->status];

												if($row->status == "new"){
													$color = "success";
												}
												else if($row->status == "assign"){
													$color = "warning";
												}
												else{
													$color = "primary";
												}

												echo('<span class="badge badge-'.$color.'">'.$s.'</span>');
											?>
									</td>
									<td><?= $row->group_room ?></td>
									<td>
										<?php
												$is = $this->model_auth->getDataUser(['id' => $row->id_it_support]);
												echo $is['nama'];
											?>
									</td>
									<td>
										<?= $row->title ?>
									</td>
									<td><?= $row->description ?> </td>
									<td>
										<?php
												$s = @$service[$row->service_type];
												if($row->service_type == "aplikasi_pendukung_kerja"){
													$color = "orange";
												}
												else if($row->service_type == "jaringan_internet"){
													$color = "navy";
												}
												else if($row->service_type == "perangkat_pc/laptop_internal"){
													$color = "maroon";
												}
												else if($row->service_type == "perangkat_pc/laptop_ms_lapto"){
													$color = "teal";
												}
												else if($row->service_type == "perangkat_pendukung"){
													$color = "purple";
												}
												else if($row->service_type == "server"){
													$color = "gray";
												}

												echo ('<span class="badge bg-'.$color.'">'.$s.'</span>');
											?>
									</td>
									<td>
										<?php
												$u = @$urgent[$row->urgent_level];
												if($row->urgent_level == "critical"){
													$color = "danger";
												}
												else if($row->urgent_level == "high"){
													$color = "orange";
												}
												else if($row->urgent_level == "medium"){
													$color = "warning";
												}
												else{
													$color = "teal";
												}
												echo ('<span class="badge bg-'.$color.'">'.$u.'</span>');
											?>
									</td>
									<td><?= $row->created_at ?></td>
									<td>
										<?php
											if($row->status == "resolved"){
												echo('<button class="btn btn-success btn-xs" onclick="showResolved(\''.base_url('incident/resolved/'.$row->id).'\')" title="Show Resolved Message"><i class="fa fa-comment"></i></button>');
											}

											if(!isItSupport()){
												if($row->status != "resolved"){
													echo('<button onclick="edit(\''.base_url('incident/'.$row->id).'\')" class="btn btn-xs btn-info" title="Edit Incident"><i class="fa fa-edit"></i></button>');

													echo(' <button onclick="deleteData(\''.base_url('incident/del-incident/'.$row->id).'\')" class="btn btn-xs btn-danger" title="Delete Incident"><i class="fa fa-trash"></i></button>');
												}
											}
											else{
												if($row->status == "new"){
													echo('<button onclick="setStatus(\''.base_url('incident/set-status/'.$row->id).'\', \''.$row->status.'\')" class="btn btn-xs btn-warning" title="Change Status"><i class="fa fa-fw fa-sign-in-alt"></i></button>');
												}

												if($row->status == "assign"){
													echo('<button onclick="setStatus(\''.base_url('incident/set-status/'.$row->id).'\', \''.$row->status.'\')" class="btn btn-xs btn-success" title="Change Status"><i class="fa fa-fw fa-check-square"></i></button>');
												}
											}
											?>
									</td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- /.row -->
	</div>
	<!--/. container-fluid -->
</section>
<!-- /.content -->
<div class="modal fade" id="modalResolved">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Ticket Form</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-12">
						<label for="">Cause</label>
						<p id="cause"></p>
					</div>
					<div class="col-md-12">
						<label for="">Keterangan</label>
						<p id="keterangan"></p>
					</div>
				</div>
			</div>
			<div class="modal-footer float-right">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<?php if(!isItSupport()){ ?>
<form action="<?= base_url("incident/save-incident") ?>" method="post" id="formModal" enctype="multipart/form-data"
	autocomplete="off">
	<input type="hidden" name="id_ticket" id="id_ticket">
	<div class="modal fade" id="modalForm">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Ticket Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="it_support">IT Support</label>
								<select name="it_support" id="it_support" class="form-control">
									<option value="" selected>-- Choose IT Support --</option>
									<?php foreach($it_support as $row){ ?>
									<option value="<?= $row->id ?>"><?= $row->nama ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="title">Title/Summary</label>
								<input type="text" name="title" class="form-control" id="title"
									placeholder="Title/Summary">
							</div>
							<div class="form-group">
								<label for="description">Description</label>
								<textarea name="description" id="description" rows="8" class="form-control"></textarea>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="status">Status</label>
								<select name="status" id="status" class="form-control">
									<option value="" selected>-- Choose Status --</option>
									<?php foreach($status as $key => $val){ ?>
									<option value="<?= $key ?>"><?= $val ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="service_type">Service Type</label>
								<select name="service_type" id="service_type" class="form-control">
									<option value="" selected>-- Choose Service Type --</option>
									<?php foreach($service as $key => $val){ ?>
									<option value="<?= $key ?>"><?= $val ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="group_ruangan">Group/Room</label>
								<input type="text" name="group_room" class="form-control" id="group_room"
									placeholder="Group/Room">
							</div>
							<div class="form-group">
								<label for="urgent_level">Urgency</label>
								<select name="urgent_level" id="urgent_level" class="form-control">
									<option value="" selected>-- Choose Urgent Level --</option>
									<?php foreach($urgent as $key => $val){ ?>
									<option value="<?= $key ?>"><?= $val ?></option>
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="priority">Priority</label>
								<select name="priority" id="priority" class="form-control">
									<option value="" selected>-- Choose Priority --</option>
									<?php for($i = 1; $i <= $priority; $i++){ ?>
									<option value="<?= $i ?>"><?= $i ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer float-right">
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
</form>
<?php } else { ?>
<form action="<?= base_url("incident/save-incident") ?>" method="post" id="formModal" enctype="multipart/form-data"
	autocomplete="off">
	<div class="modal fade" id="formModalResolved">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Ticket Form</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label>Cause</label>
						<input type="text" class="form-control" name="cause" required>
					</div>
					<div class="form-group">
						<label>Resolve Detail</label>
						<textarea name="resolved_ket" rows="10" class="form-control" required></textarea>
					</div>
				</div>
				<div class="modal-footer float-right">
					<button type="submit" class="btn btn-primary" >Submit</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
</form>
<?php } ?>
