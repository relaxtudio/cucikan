<div id="edit_byr" class="panel panel-success" style="display:none;">
	<div class="panel-header">
	<a id="close_byr_form_ed" class="btn btn-warning pull-right" href="#" title="Close"><i class="fa fa-close"></i></a>
	<script>
	$(document).on('click','#close_byr_form_ed',function(){
		$('#edit_byr').attr('style','display:none');
	});
	</script>
	</div>
	<div class="panel-body">
	<legend align="center">Form Edit Tipe Pembayaran</legend>
	<br />
	<form id="edit_byr_form" method="POST" action="#" class="form-horizontal">
		<div class="form-group" style="display:none;">
			<label class="col-md-4 col-sm-3  control-label" for="id_byr_ed" style="font-size:15px;color:black;">ID</label>
			<div class="col-md-3 col-sm-2">
				<input id="id_byr_ed" name="id_byr_ed" type="text" placeholder="" class="form-control input-md" value="" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 col-sm-3  control-label" for="tp_byr_ed" style="font-size:15px;color:black;">Tipe</label>
			<div class="col-md-5 col-sm-7">
				<select id="tp_byr_ed" name="tp_byr_ed" placeholder="" class="form-control input-md" value="" required>
					<option value="Transfer">Transfer</option>
					<option value="Cash">Cash</option>
					<option value="Lain-lain">Lain-lain</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 col-sm-3  control-label" for="ket_byr_ed" style="font-size:15px;color:black;">Keterangan</label>
			<div class="col-md-8 col-sm-7">
				<textarea id="ket_byr_ed" name="ket_byr_ed" type="text" placeholder="Contoh: BCA 12345678 a.n Admin Cucikan" class="form-control input-md" style="max-width:300px;max-height:200px;" value="" required></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-3 col-sm-3 control-label" for="update_byr"></label>
			<div class="col-md-7">
				<button id="update_byr" name="update_byr" class="btn btn-success"><b>Update</b></button>
			</div>
		</div>
	</form>
	<script>
	$('#edit_byr_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url: "pembayaran/upd_pembayaran.php",
			type:'POST',
			data:$('form').serialize(),
			success: function(){
				$('#list_pembayaran').DataTable().ajax.reload();
				$('#edit_byr').attr('style','display:none');
			}
		});
	});
	</script>
	</div>
</div>