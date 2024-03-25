<?php
require_once('./../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `vehicle_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
?>

<div class="container-fluid">
    <form action="" id="vehicle-form">
        <input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
        <input type="hidden" name ="model_id" value="<?php echo isset($model_id) ? $model_id : (isset($_GET['model_id']) ? $_GET['model_id'] : '') ?>">
        <div class="row">
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="mv_number" class="control-label">M.V. File No.</label>
                <input type="text" name="mv_number" id="mv_number" class="form-control form-control-sm rounded-0" value="<?php echo isset($mv_number) ? $mv_number : ''; ?>"  required/>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="plate_number" class="control-label">Plate #</label>
                <input type="text" name="plate_number" id="plate_number" class="form-control form-control-sm rounded-0" value="<?php echo isset($plate_number) ? $plate_number : ''; ?>"  required/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="engine_number" class="control-label">Engine Number</label>
                <input type="text" name="engine_number" id="engine_number" class="form-control form-control-sm rounded-0" value="<?php echo isset($engine_number) ? $engine_number : ''; ?>"  required/>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="chasis_number" class="control-label">Chasis Number</label>
                <input type="text" name="chasis_number" id="chasis_number" class="form-control form-control-sm rounded-0" value="<?php echo isset($chasis_number) ? $chasis_number : ''; ?>"  required/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="variant" class="control-label">Variant</label>
                <input type="text" name="variant" id="variant" class="form-control form-control-sm rounded-0" value="<?php echo isset($variant) ? $variant : ''; ?>"  required/>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="mileage" class="control-label">Mileage</label>
                <input type="text" name="mileage" id="mileage" class="form-control form-control-sm rounded-0" value="<?php echo isset($mileage) ? $mileage : ''; ?>"  required/>
            </div>
        </div>
        <div class="row">
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="price" class="control-label">Price</label>
                <input type="number" step="any" name="price" id="price" class="form-control form-control-sm rounded-0 text-right" value="<?php echo isset($price) ? $price : 0; ?>"  required/>
            </div>
            <div class="form-group col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <label for="status" class="control-label">Status</label>
                <select name="status" id="status" class="form-control form-control-sm rounded-0" required="required">
                    <option value="0" <?= isset($status) && $status == 0 ? 'selected' : '' ?>>Available</option>
                    <option value="1" <?= isset($status) && $status == 1 ? 'selected' : '' ?>>Sold</option>
                </select>
            </div>
        </div>
    </form>
</div>
<script>
	$(document).ready(function(){
		$('#vehicle-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_vehicle",
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
						alert_toast(resp.msg, 'success')
						uni_modal('<i class="fa fa-th-list"></i> Vehicle Details', 'models/view_vehicle.php?id='+resp.vid)
						$('#uni_modal').on('hide.bs.modal', function(){
							location.reload()
						})
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