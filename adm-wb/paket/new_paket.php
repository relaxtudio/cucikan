<div id="new_pkt" class="panel panel-success" style="display:none;">
	<div class="panel-header">
	<a id="close_pkt_form" class="btn btn-warning pull-right" href="#" title="Close"><i class="fa fa-close"></i></a>
	<script>
	$(document).on('click','#close_pkt_form',function(){
		$('#new_pkt').attr('style','display:none');
	});
	</script>
	</div>
	<div class="panel-body">
	<legend align="center">Form Paket Layanan Baru</legend>
	<br />
	<form id="add_pkt_form" method="POST" action="#" class="form-horizontal">
		<div class="form-group">
			<label class="col-md-4 col-sm-3  control-label" for="nama_paket" style="font-size:15px;color:black;">Nama Paket(*)</label>
			<div class="col-md-7 col-sm-7">
				<input id="nama_paket" name="nama_paket" type="text" placeholder="Nama paket baru" class="form-control input-md" value="" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 col-sm-3  control-label" for="harga" style="font-size:15px;color:black;">Harga (IDR)</label>
			<div class="col-md-6 col-sm-7">
				<input id="harga" name="harga" type="number" placeholder="Contoh: 20000" class="form-control input-md" value="" required>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 col-sm-3 control-label" for="keterangan" style="font-size:13px;">Keterangan</label>
			<div class="col-md-7 col-sm-7">
				<textarea id="keterangan" name="keterangan" placeholder="Keterangan paket" style="max-width:260px;" class="form-control input-md" required></textarea>
			</div>
		</div>
		<div class="form-group">
			<label class="col-md-4 col-sm-3 control-label" for="simpan_paket"></label>
			<div class="col-md-7">
				<button id="simpan_paket" name="simpan_paket" class="btn btn-info"><b>Simpan Paket</b></button>
			</div>
		</div>
	</form>
	<script>
	$('#add_pkt_form').on('submit', function(e){
		e.preventDefault();
		$.ajax({
			url: "paket/save_paket.php",
			type:'POST',
			data:$('form').serialize(),
			success: function(){
				$('#new_pkt').attr('style','display:none');
				$('#adm-content').load('paket/list_paket.php');
			}
		});
	});
	</script>
	</div>
</div>