
<div id="edit_pkt" class="panel panel-success" style="display:none;">
	<div class="panel-header">
	<a id="close_pkt_form_ed" class="btn btn-warning pull-right" href="#" title="Close"><i class="fa fa-close"></i></a>
	<script>
	$(document).on('click','#close_pkt_form_ed',function(){
		$('#edit_pkt').attr('style','display:none');
	});
	</script>
	</div>
	<div class="panel-body">
	<legend align="center">Form Edit Paket Layanan</legend>
	<form id="edit_pkt_form" method="POST" action="#" class="form-horizontal">
		<div class="form-group" style="display:none;">
			<label class="col-md-4 col-sm-3  control-label" for="id_paket_ed" style="font-size:15px;color:black;">ID</label>
			<div class="col-md-3 col-sm-2">
				<input id="id_paket_ed" name="id_paket_ed" type="text" placeholder="" class="form-control input-md" value="" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 col-sm-3  control-label" for="nama_paket_ed" style="font-size:15px;color:black;">Nama Paket(*)</label>
			<div class="col-md-6 col-sm-5">
				<input id="nama_paket_ed" name="nama_paket_ed" type="text" placeholder="Nama paket baru" class="form-control input-md" value="" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 col-sm-3  control-label" for="harga_ed" style="font-size:15px;color:black;">Harga (IDR)</label>
			<div class="col-md-6 col-sm-5">
				<input id="harga_ed" name="harga_ed" type="number" placeholder="Contoh: 20000" class="form-control input-md" value="" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 col-sm-3 control-label" for="keterangan_ed" style="font-size:13px;">Keterangan</label>
			<div class="col-md-7 col-sm-7">
				<textarea id="keterangan_ed" name="keterangan_ed" placeholder="Keterangan paket" style="max-width:270px;min-height:175px;" class="form-control input-md" required></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 col-sm-5 control-label" for="simpan_paket"></label>
			<div class="col-md-7">
				<button id="simpan_paket" name="simpan_paket" class="btn btn-info"><b>Update Paket</b></button>
			</div>
		</div>
	</form>
	<script>
	$('#edit_pkt_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url: "paket/upd_paket.php",
			type:'POST',
			data:$('form').serialize(),
			success: function(){
				$('#list_paket').DataTable().ajax.reload();
				$('#edit_pkt').attr('style','display:none');
			}
		});
	});
	</script>
	</div>
</div>