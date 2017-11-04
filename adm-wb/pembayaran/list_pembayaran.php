<script>
$(document).ready(function() {
	var table = $('#list_pembayaran').DataTable({
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
			url:"pembayaran/dt_pembayaran.php",
			type:"POST",
			dataType:"json",
			error: function(){  // error handling
				$(".list_pembayaran-error").html("");
				$("#list_pembayaran").append('<tbody class="list_pembayaran-error"><tr><th colspan="4">Data tidak ditemukan.</th></tr></tbody>');
				$("#list_pembayaran_processing").css("display","none");
			}
		},
		"columns":[
			{"data" : "id_pembayaran"},
			{"data" : "tipe_pembayaran"},
			{"data" : "keterangan_pembayaran"},
			{	"orderable": false,
				"searchable": false,
				"data": null,
				"defaultContent": '',
				"render": function ( data, type, a ) {
					var bid = a.id_pembayaran;
					var tp	= a.tipe_pembayaran;
					var byr	= a.keterangan_pembayaran;
					return '<a id="'+bid+'" tp="'+tp+'" byr="'+byr+'" href="#" class="btn btn-info edit_byr" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a id="'+bid+'" href="#" class="btn btn-danger del_byr" title="Delete"><i class="fa fa-trash"></i></a>';
					}
			}
		]
	});
	$(document).on('click','.add_byr',function(){
		$('#new_byr').attr('style','display:show');
	});
	$(document).on('click','.edit_byr',function(){
		$('#edit_byr').attr('style','display:show');
			var z	= $(this).attr('id');
			var x	= $(this).attr('tp');
			var v	= $(this).attr('byr');
			$('#id_byr_ed').val(z);
			$('#tp_byr_ed').val(x);
			$('#ket_byr_ed').val(v);
	});
	$(document).on('click','.del_byr',function(e){
		if(confirm("Anda yakin akan menghapus data ini?")){
		var id_byr = $(this).attr('id');
			$.ajax({
				type: "POST",
				url: "pembayaran/del_pembayaran.php?id_byr="+id_byr,
				data:{id_byr:id_byr},
				success: function(){
					$('#list_pembayaran').DataTable().ajax.reload();
				}
			});
			e.stopImmediatePropagation();
			//e.preventDefault();
		}
	});
});
</script>
<div class="row">
<div id="tabel_byr" class="col-md-7">
	<div class="panel panel-default">
		<div class="panel-body">
			<fieldset>
			<legend>Tipe Pembayaran</legend>
			<a id="add_bayar" href="#" class="btn btn-success add_byr"><i class="fa fa-plus"></i> Pembayaran Baru</a>
			<br></br>
			<table id="list_pembayaran" class="table table-striped table-bordered responsive" cellspacing="0" width="100%" style="margin-left:-10px;text-align:justify;">
				<thead>
					<tr>
						<th width="10px;">ID</th>
						<th width="25%">Tipe</th>
						<th>Keterangan</th>
						<th width="75px;">Action</th>
				</thead>
			</table>
			</fieldset>
		</div>
	</div>
</div>
<div class="col-md-5">
	<div id="byr_container">
	<?php include('new_pembayaran.php');?>
	<?php include('edit_pembayaran.php');?>
	</div>
</div>
</div>