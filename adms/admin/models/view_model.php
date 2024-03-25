<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT m.*, b.name as `brand`, ct.name as `car_type` from `model_list` m inner join brand_list b on m.brand_id = b.id inner join car_type_list ct on m.car_type_id = ct.id where m.id = '{$_GET['id']}' and m.delete_flag = 0 ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }else{
		echo '<script>alert("model ID is not valid."); location.replace("./?page=models")</script>';
	}
}else{
	echo '<script>alert("model ID is Required."); location.replace("./?page=models")</script>';
}
?>
<style>
	#model-thumbnail{
		max-width:100%;
		max-height:23em;
		object-fit:scale-down;
		object-position:center center;
	}
	.model-img{
		width:100%;
		max-height:10em;
		object-fit:cover;
		object-position:center center;
	}
</style>
<div class="content py-5 px-3 bg-gradient-navy">
	<h4 class="font-wight-bolder">Model Details</h4>
</div>
<div class="row mt-n4 align-items-center justify-content-center flex-column">
	<div class="col-lg-10 col-md-11 col-sm-12 col-xs-12">
		<div class="card rounded-0 shadow">
			<div class="card-footer py-1 text-center">
				<button class="btn btn-flat btn-sm btn-primary bg-gradient-primary" type="button" id="add_vehicle"><i class="far fa-plus-square"></i> Add Vehicle</button>
				<a class="btn btn-flat btn-sm btn-navy bg-gradient-navy border" href="./?page=models/manage_model&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-edit"></i> Edit</a>
				<button class="btn btn-flat btn-sm btn-danger bg-gradient-danger" type="button" id="delete_model"><i class="fa fa-trash"></i> Delete</button>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=models"><i class="fa fa-angle-left"></i> Back to List</a>
			</div>
		</div>
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid">
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Brand:</div>
						<div class="col-9 mb-0 border"><?= isset($brand) ? $brand : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Car Type:</div>
						<div class="col-9 mb-0 border"><?= isset($car_type) ? $car_type : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Model:</div>
						<div class="col-9 mb-0 border"><?= isset($model) ? $model : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Engine Type:</div>
						<div class="col-9 mb-0 border"><?= isset($engine_type) ? $engine_type : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Transmission Type:</div>
						<div class="col-9 mb-0 border"><?= isset($transmission_type) ? $transmission_type : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Technology:</div>
						<div class="col-9 mb-0 border"><?= isset($technology) ? htmlspecialchars_decode($technology) : '' ?></div>
					</div>
					<div class="d-flex w-100 mb-3">
						<div class="col-3 mb-0 border bg-gradient-secondary">Status:</div>
						<div class="col-9 mb-0 border">
							<td class="text-center">
                                <?php if(isset($status)): ?>
									<?php if($status == 1): ?>
										<span class="badge badge-success px-3 rounded-pill">Active</span>
									<?php else: ?>
										<span class="badge badge-danger px-3 rounded-pill">Inactive</span>
									<?php endif; ?>
                                <?php else: ?>
										<span class="badge badge-light border px-3 rounded-pill">N/A</span>
                                <?php endif; ?>
                            </td>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid">
					<table class="table table-stripped table-bordered" id="vehicle-list">
						<colgroup>
							<col width="5%">
							<col width="25%">
							<col width="15%">
							<col width="25%">
							<col width="15%">
							<col width="15%">
						</colgroup>
						<thead>
							<th class="p-1 text-center">#</th>
							<th class="p-1 text-center">M.V. File No.</th>
							<th class="p-1 text-center">Mileage</th>
							<th class="p-1 text-center">Price</th>
							<th class="p-1 text-center">Status</th>
							<th class="p-1 text-center">Action</th>
						</thead>
						<tbody>
							<?php if(isset($id)): ?>
							<?php 
							$i = 1;
							$vehicles = $conn->query("SELECT * FROM `vehicle_list` where model_id = '{$id}' and delete_flag = 0 order by abs(unix_timestamp(date_created)) asc");
							while($row = $vehicles->fetch_assoc()):	
							?>
							<tr>
								<td class="p-1 align-middle text-center"><?= $i++ ?></td>
								<td class="p-1 align-middle"><?= $row['mv_number'] ?></td>
								<td class="p-1 align-middle"><?= $row['mileage'] ?></td>
								<td class="p-1 align-middle text-right"><?= format_num($row['price'], 2) ?></td>
								<td class="p-1 align-middle text-center">
									<?php if($row['status'] == 0): ?>
										<span class="badge badge-success px-3 rounded-pill">Available</span>
									<?php else: ?>
										<span class="badge badge-danger px-3 rounded-pill">Sold</span>
									<?php endif; ?>
								</td>
								<td class="p-1 align-middle text-center">
									<button class="btn btn-flat btn-light bg-gradient-light btn-sm border view_vehicle" data-id="<?= $row['id'] ?>" type="button"><i class="fa fa-eye"></i> View</button>
								</td>
							</tr>
							<?php endwhile; ?>
							<?php endif; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		$('#delete_model').click(function(){
			_conf("Are you sure to delete this model permanently?","delete_model",['<?= isset($id) ? $id : '' ?>'])
		})
		$('#add_vehicle').click(function(){
			uni_modal('<i class="far fa-plus-square"></i> Add Vehicle Entry','models/manage_vehicle.php?model_id=<?= isset($id) ? $id : '' ?>','modal-lg')
		})
		$('.view_vehicle').click(function(){
			uni_modal('<i class="fa fa-edit"></i> Edit Vehicle Details','models/view_vehicle.php?id='+$(this).attr('data-id'))
		})
		$('#vehicle-list').dataTable({
			columnDefs: [
					{ orderable: false, targets: [5] }
			],
			order:[0,'asc']
		});
		$('.dataTable td,.dataTable th').addClass('py-1 px-2 align-middle')
	
	})
	function delete_model($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_model",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.replace("./?page=models");
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
	function delete_image($link){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_img",
			method:"POST",
			data:{path: $link},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					var img = $('.del_img[data-link = "'+$link+'"]').closest('.img-item')
					if(img.hasClass('border')){
						$('.view-img').first().trigger('click')
					}
					img.remove()
					alert_toast('Image has been deleted successfully.','success')
					$('.modal').modal('hide')
				}else{
					alert_toast("An error occured.",'error');
				}
				end_loader();

			}
		})
	}
</script>