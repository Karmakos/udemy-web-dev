<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `model_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
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
	<h4 class="font-wight-bolder"><?= isset($id) ? "Update Model Details" : "New Model Entry" ?></h4>
</div>
<div class="row mt-n4 align-items-center justify-content-center flex-column">
	<div class="col-lg-10 col-md-11 col-sm-12 col-xs-12">
		<div class="card rounded-0 shadow">
			<div class="card-body">
				<div class="container-fluid">
					<form action="" id="model-form">
						<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="brand_id" class="control-label">Brand</label>
								<select name="brand_id" id="brand_id" class="form-control form-control-sm rounded-0" required="required">
									<option value="" <?= !isset($brand_id) ? 'selected' : '' ?>></option>
									<?php 
									$brands = $conn->query("SELECT * FROM `brand_list` where delete_flag = 0 and `status` = 1 order by `name` asc");
									while($row = $brands->fetch_assoc()):
									?>
									<option value="<?= $row['id'] ?>" <?= isset($brand_id) && $brand_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="car_type_id" class="control-label">Type</label>
								<select name="car_type_id" id="car_type_id" class="form-control form-control-sm rounded-0" required="required">
									<option value="" <?= !isset($car_type_id) ? 'selected' : '' ?>></option>
									<?php 
									$car_types = $conn->query("SELECT * FROM `car_type_list` where delete_flag = 0 and `status` = 1 order by `name` asc");
									while($row = $car_types->fetch_assoc()):
									?>
									<option value="<?= $row['id'] ?>" <?= isset($car_type_id) && $car_type_id == $row['id'] ? 'selected' : '' ?>><?= $row['name'] ?></option>
									<?php endwhile; ?>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="model" class="control-label">Model</label>
								<input type="text" name="model" id="model" class="form-control form-control-sm rounded-0" value="<?php echo isset($model) ? $model : ''; ?>"  required/>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="engine_type" class="control-label">Engine Type</label>
								<input type="text" name="engine_type" id="engine_type" class="form-control form-control-sm rounded-0" value="<?php echo isset($engine_type) ? $engine_type : ''; ?>"  required/>
							</div>
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="transmission_type" class="control-label">Transimission Type</label>
								<input type="text" name="transmission_type" id="transmission_type" class="form-control form-control-sm rounded-0" value="<?php echo isset($transmission_type) ? $transmission_type : ''; ?>"  required/>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<label for="technology" class="control-label">Technologies</label>
								<textarea rows="4" name="technology" id="technology" class="form-control form-control-sm rounded-0" required><?php echo isset($technology) ? $technology : ''; ?></textarea>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<label for="status" class="control-label">Status</label>
								<select name="status" id="status" class="form-control form-control-sm rounded-0" required="required">
									<option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Active</option>
									<option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Inactive</option>
								</select>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="card-footer py-1 text-center">
				<button class="btn btn-flat btn-sm btn-navy bg-gradient-navy" form="model-form"><i class="fa fa-save"></i> Save</button>
				<?php if(isset($id)): ?>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=models/view_model&id=<?= isset($id) ? $id : '' ?>"><i class="fa fa-angle-left"></i> Cancel</a>
				<?php else: ?>
				<a class="btn btn-flat btn-sm btn-light bg-gradient-light border" href="./?page=models"><i class="fa fa-angle-left"></i> Cancel</a>
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
		$('#model-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_model",
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
						location.replace('./?page=models/view_model&id='+resp.pid)
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