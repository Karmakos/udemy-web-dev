<?php
if(isset($_GET['transaction_id']) && $_GET['transaction_id'] >0){
	$transaction_qry = $conn->query("SELECT * from `transaction_list` where id = '{$_GET['transaction_id']}' ");
    if($transaction_qry->num_rows > 0){
        foreach($transaction_qry->fetch_assoc() as $k => $v){
            $transaction[$k]=$v;
        }
    }
	if(isset($transaction['vehicle_id'])){
		$vehicle_id = $transaction['vehicle_id'];
	}
}else if(isset($_GET['id']) && $_GET['id'] >0){
	$vehicle_id = $_GET['id'];
}else{
	echo '<script>alert("Vehicle ID is not valid."); location.replace("./?page=vehicles")</script>';
}
$qry = $conn->query("SELECT * from `vehicle_list` where id = '{$vehicle_id}' ");
if($qry->num_rows > 0){
	foreach($qry->fetch_assoc() as $k => $v){
		$$k=$v;
	}
}
if(isset($model_id)){
	$model_qry = $conn->query("SELECT m.*, b.name as `brand`, ct.name as `car_type` from `model_list` m inner join brand_list b on m.brand_id = b.id inner join car_type_list ct on m.car_type_id = ct.id where m.id = '{$model_id}'");
	if($model_qry->num_rows > 0){
		foreach($model_qry->fetch_assoc() as $k => $v){
			$model[$k]=$v;
		}
	}
}
?>
<style>
	legend.legend-sm {
		font-size: 1.4em;
	}
	#cimg{
		max-width: 100%;
		max-height: 20em;
		object-fit:scale-down;
		object-position:center center;
	}
</style>
<div class="content py-5 px-3 bg-gradient-navy">
	<h4 class="font-wight-bolder">Transaction Form</h4>
</div>
<div class="row mt-n4 align-items-center justify-content-center flex-column">
	<div class="col-lg-10 col-md-11 col-sm-12 col-xs-12">
		<div class="card rounded-0 shadow">
			<div class="card-header py-1">
				<div class="card-title"><b>Car Details</b></div>
			</div>
			<div class="card-body">
				<div class="container-fluid">
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Brand:</div>
						<div class="col-9 mb-0 border"><?= isset($model['brand']) ? $model['brand'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Car Type:</div>
						<div class="col-9 mb-0 border"><?= isset($model['car_type']) ? $model['car_type'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Model:</div>
						<div class="col-9 mb-0 border"><?= isset($model['model']) ? $model['model'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Engine Type:</div>
						<div class="col-9 mb-0 border"><?= isset($model['engine_type']) ? $model['engine_type'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Transmission Type:</div>
						<div class="col-9 mb-0 border"><?= isset($model['transmission_type']) ? $model['transmission_type'] : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Technology:</div>
						<div class="col-9 mb-0 border"><?= isset($model['technology']) ? htmlspecialchars_decode($model['technology']) : '' ?></div>
					</div>
					<div class="clear-fix my-1"></div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">M.V. File No.</div>
						<div class="col-9 mb-0 border"><?= isset($mv_number) ? $mv_number : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Plate Number</div>
						<div class="col-9 mb-0 border"><?= isset($plate_number) ? $plate_number : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Variant</div>
						<div class="col-9 mb-0 border"><?= isset($variant) ? $variant : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Mileage</div>
						<div class="col-9 mb-0 border"><?= isset($mileage) ? ($mileage > 0 ? format_num($mileage) : $mileage) : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Engine Number</div>
						<div class="col-9 mb-0 border"><?= isset($engine_number) ? $engine_number : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Chasis Number</div>
						<div class="col-9 mb-0 border"><?= isset($chasis_number) ? $chasis_number : '' ?></div>
					</div>
					<div class="d-flex w-100">
						<div class="col-3 mb-0 border bg-gradient-secondary">Price</div>
						<div class="col-9 mb-0 border"><?= isset($price) ? format_num($price, 2) : '' ?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid">
					<form action="" id="transaction-form">
						<input type="hidden" name ="id" value="<?php echo isset($transaction['id']) ? $transaction['id'] : '' ?>">
						<input type="hidden" name ="vehicle_id" value="<?php echo isset($id) ? $id : '' ?>">
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="agent_name" class="control-label">Agent Name</label>
								<input type="text" name="agent_name" id="agent_name" class="form-control form-control-sm rounded-0" value="<?php echo isset($transaction['agent_name']) ? $transaction['agent_name'] : ''; ?>"  required/>
							</div>
						</div>
						<h5><b>Customer Details</b></h5>
						<div class="row">
							<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<label for="firstname" class="control-label">First Name</label>
								<input type="text" name="firstname" id="firstname" class="form-control form-control-sm rounded-0" value="<?php echo isset($transaction['firstname']) ? $transaction['firstname'] : ''; ?>"  required/>
							</div>
							<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<label for="middlename" class="control-label">Middle Name</label>
								<input type="text" name="middlename" id="middlename" class="form-control form-control-sm rounded-0" value="<?php echo isset($transaction['middlename']) ? $transaction['middlename'] : ''; ?>" />
							</div>
							<div class="form-group col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<label for="lastname" class="control-label">Last Name</label>
								<input type="text" name="lastname" id="lastname" class="form-control form-control-sm rounded-0" value="<?php echo isset($transaction['lastname']) ? $transaction['lastname'] : ''; ?>"  required/>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="sex" class="control-label">Sex</label>
								<select name="sex" id="sex" class="form-control form-control-sm rounded-0" required="required">
									<option value="Male" <?= isset($sex) && $sex == 'Male' ? 'selected' : '' ?>>Male</option>
									<option value="Female" <?= isset($sex) && $sex == 'Female' ? 'selected' : '' ?>>Female</option>
								</select>
							</div>
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="dob" class="control-label">Birthday</label>
								<input type="date" name="dob" id="dob" class="form-control form-control-sm rounded-0" value="<?php echo isset($transaction['dob']) ? $transaction['dob'] : ''; ?>"  required/>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="contact" class="control-label">Contact #</label>
								<input type="text" name="contact" id="contact" class="form-control form-control-sm rounded-0" value="<?php echo isset($transaction['contact']) ? $transaction['contact'] : ''; ?>"  required/>
							</div>
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="email" class="control-label">Email</label>
								<input type="email" name="email" id="email" class="form-control form-control-sm rounded-0" value="<?php echo isset($transaction['email']) ? $transaction['email'] : ''; ?>" />
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<label for="address" class="control-label">Address</label>
								<textarea rows="3" name="address" id="address" class="form-control form-control-sm rounded-0" required><?php echo isset($transaction['address']) ? $transaction['address'] : ''; ?></textarea>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-flat btn-sm btn-navy bg-gradient-navy" form="transaction-form"><i class="fa fa-save"></i> Save</button>
				<?php if(isset($transaction['id']) && $transaction['id']): ?>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=vehicles/view_transaction&id=<?= isset($transaction['id']) ? $transaction['id'] : '' ?>"><i class="fa fa-angle-left"></i> Cancel</a>
				<?php else: ?>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=vehicles"><i class="fa fa-angle-left"></i> Cancel</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$('#brand_id').select2({
			placeholder:"Please Select Brand here",
			width:'100%',
			containerCssClass:'form-control form-control-sm rounded-0'
		})
		$('#car_type_id').select2({
			placeholder:"Please Select Brand here",
			width:'100%',
			containerCssClass:'form-control form-control-sm rounded-0'
		})
		$('#transaction-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_transaction",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.replace('./?page=vehicles/view_transaction&id='+resp.tid)
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").scrollTop(0);
                    }else{
						alert_toast("An error occured",'error');
					}
					end_loader()
				}
			})
		})

	})
</script>