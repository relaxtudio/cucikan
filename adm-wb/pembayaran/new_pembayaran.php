<div id="new_byr" class="panel panel-success" style="display:none;">
	<div class="panel-header">
	<a id="close_byr_form" class="btn btn-warning pull-right" href="#" title="Close"><i class="fa fa-close"></i></a>
	<script>
	$(document).on('click','#close_byr_form',function(){
		$('#new_byr').attr('style','display:none');
	});
	</script>
	</div>
	<div class="panel-body">
	<legend align="center">Form Tipe Pembayaran Baru</legend>
	<br />
	<form id="add_byr_form" method="POST" action="#" class="form-horizontal">
		<div class="form-group">
			<label class="col-md-3 col-sm-3  control-label" for="tipe_pembayaran" style="font-size:15px;color:black;">Tipe</label>
			<div class="col-md-5 col-sm-7">
				<select id="tipe_pembayaran" name="tipe_pembayaran" placeholder="" class="form-control input-md" value="" required>
					<option value="Transfer">Transfer</option>
					<option value="Cash">Cash</option>
					<option value="Lainnya">Lain-lain</option>
				</select>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-3 col-sm-3  control-label" for="keterangan_pembayaran" style="font-size:15px;color:black;">Keterangan</label>
			<div class="col-md-8 col-sm-7">
				<textarea id="keterangan_pembayaran" name="keterangan_pembayaran" type="text" placeholder="Contoh: BCA 12345678 a.n Admin Cucikan" class="form-control input-md" style="max-width:300px;max-height:200px;" value="" required></textarea>
			</div>
		</div>
		
		<div class="form-group">
			<label class="col-md-3 col-sm-3 control-label" for="simpan_byr"></label>
			<div class="col-md-7">
				<button id="simpan_byr" name="simpan_byr" class="btn btn-success"><b>Simpan</b></button>
			</div>
		</div>
	</form>
	<script>
	$('#add_byr_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url: "pembayaran/save_pembayaran.php",
			type:'POST',
			data:$('form').serialize(),
			success: function(){
				$('#new_byr').attr('style','display:none');
				$('#adm-content').load('pembayaran/list_pembayaran.php');
			}
		});
	});
	</script>
	</div>
</div>