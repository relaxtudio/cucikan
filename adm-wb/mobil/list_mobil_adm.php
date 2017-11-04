
<script>
$(document).ready(function() {
	var table = $('#brand_mbl').DataTable({
		"language": {
		"lengthMenu": "Tampilkan _MENU_ data",
		"zeroRecords": "Data tidak ditemukan",
		"info": "Halaman _PAGE_ dari _PAGES_",
		"infoEmpty": "",
		"infoFiltered": "<br />(Dari _MAX_ total data)",
		"search": "Cari Data",
		"paginate": {
			"first": "<<",
			"last": ">>",
			"next": ">",
			"previous": "<"
			}
		},
		"pagingType": "full",
		"pageLength": 5,
		"lengthMenu": [ 5, 10 ],
		"responsive": true,
		"deferRender": true,
		"processing": true,
		"serverSide": true,
		"ajax":{
			url:"mobil/dt_brand.php",
			type:"POST",
			dataType:"json",
			error: function(){  // error handling
				$(".brand_mbl-error").html("");
				$("#brand_mbl").append('<tbody class="brand_mbl-error"><tr><th colspan="4">Data tidak ditemukan.</th></tr></tbody>');
				$("#brand_mbl_processing").css("display","none");
			}
			
		},
		"columns":[
			{"data": "id_brand_mobil"},
			{"data": "nama_brand_mobil"},
			{
				"orderable": false,
				"searchable": false,
				"data": null,
				"defaultContent": '',
				"render": function ( data, type, full ) {
					var uid = full.id_brand_mobil;
					var brd = full.nama_brand_mobil;
					return '<a id="'+uid+'" href="#" brd="'+brd+'" class="btn btn-info edit_brd" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a id="'+uid+'" href="#" class="btn btn-danger del_brd" title="Delete"><i class="fa fa-trash"></i></a>';
				}
			}
		]
	});
	$(document).on('click','.edit_brd',function(e){
		var id_brd	= $(this).attr('id');
		var brand	= $(this).attr('brd');
		$('#edit_brand').attr('style','display:show');
		$('#nama_brand_mobil').val(brand);
		$('#id_brand_mobil').val(id_brd);
	});
	$(document).on('click','.cancel_brand', function(e){
		$('#edit_brand').attr('style','display:none');
	});
	$(document).on('click','.del_brd',function(e){
		var id_del	= $(this).attr('id');
		$.ajax({
			type: "POST",
			url: "mobil/del_brand.php?id_del="+id_del,
			data:{id_del:id_del},
			success: function(){
				$('#brand_mbl').DataTable().ajax.reload();
			}
		});
	});
});
</script>
<!--<a id="add_brand" class="btn btn-info"><i class="fa fa-plus"></i> Brand Mobil Baru</a>-->
<legend>Daftar Brand & Mobil Customer</legend>
<br />
<div class="row">
<div class="col-md-4">
<div class="panel panel-default">
	<div class="panel-body">
		<fieldset>
		<legend>Brand Mobil</legend>
		<div id="edit_brand" style="display:none;">
			<div class="panel panel-primary">
			<div class="panel-body">
			<h4 align="center"><u>Edit Brand</u></h4>
			<form id="edit_brnd" class="form-horizontal" action="#" method="POST">
				<div class="form-group" style="display:none;">
					<label class="col-sm-6 col-xs-3"for="id_brand_mobil" style="font-size:15px;color:black;">ID Brand</label>
					<div class="col-sm-7 col-xs-3">
						<input id="id_brand_mobil" name="id_brand_mobil" type="text" placeholder="" class="form-control input-md" value="" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-6 col-xs-3"for="nama_brand_mobil" style="font-size:15px;color:black;">Nama Brand</label>
					<div class="col-sm-12 col-xs-5">
						<input id="nama_brand_mobil" name="nama_brand_mobil" type="text" placeholder="" class="form-control input-md" value="" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-0 col-xs-3 control-label" for="update_brand"></label>
					<div class="col-sm-12" style="display:inline-block;vertical-align:top;">
						<button id="update_brand" name="update_brand" class="btn btn-success update_brand"><b>Update</b></button>
						<button id="cancel_brand" align="right" name="cancel_brand" class="btn btn-warning cancel_brand" style="padding-left:25px;"><b>Close</b></button>
					</div>
				</div>
				<script>
				$('form').on('submit', function(e){
					e.preventDefault();
					$.ajax({
						url: "mobil/upd_brand.php",
						type:'POST',
						data:$('form').serialize(),
						success: function(){
							$('#edit_brand').attr('style','display:none');
							$('#brand_mbl').DataTable().ajax.reload();
						}
					});
				});
				</script>
			</form>
			</div>
			</div>
		</div>
		<table id="brand_mbl" class="table table-striped table-bordered responsive" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th width="25px">ID </th>
					<th>Nama Brand</th>
					<th>Action</th>
				</tr>
			</thead>
		</table>
	</fieldset>
	</div>
</div>
</div>
<div class="col-md-8">
<script>
$(document).ready(function() {
	var table = $('#mobil_usr').DataTable({
		"language": {
		"lengthMenu": "Tampilkan _MENU_ data",
		"zeroRecords": "Data tidak ditemukan",
		"info": "Halaman _PAGE_ dari _PAGES_",
		"infoEmpty": "",
		"infoFiltered": "<br />(Dari _MAX_ total data)",
		"search": "Cari Data",
		"paginate": {
			"first": "<<",
			"last": ">>",
			"next": ">",
			"previous": "<"
			}
		},
		"pagingType": "full",
		"pageLength": 5,
		"lengthMenu": [ 5, 10 ],
		"responsive": true,
		"deferRender": true,
		"processing": true,
		"serverSide": true,
		"ajax":{
			url:"mobil/dt_mobil_usr.php",
			type:"POST",
			dataType:"json",
			error: function(){  // error handling
				$(".mobil_usr-error").html("");
				$("#mobil_usr").append('<tbody class="mobil_usr-error"><tr><th colspan="4">Data tidak ditemukan.</th></tr></tbody>');
				$("#mobil_usr_processing").css("display","none");
			}
			
		},
		"columns":[
			{"data": "nopol"},
			{"data": "nama_brand",
				"render": function(data, type, a){
					var produk = a.produk_mobil;
					return a.nama_brand+'&nbsp;'+produk;
				}
			},
			{"data": "tahun"},
			{"data": "warna"},
			{"data": "nama_pemilik"}
		]
	});
});
</script>
<div class="panel panel-default">
	<div class="panel-body">
		<fieldset>
		<legend>Mobil Customer</legend>
		<table id="mobil_usr" class="table table-striped table-bordered responsive" cellspacing="0" width="100%" style="margin-left:-10px;">
			<thead>
				<tr>
					<th>No. Polisi</th>
					<th>Produk Mobil</th>
					<th>Tahun</th>
					<th>Warna</th>
					<th>Pemilik</th>
			</thead>
		</table>
		</fieldset>
	</div>
</div>
</div>