<script>
$(document).ready(function() {
	var table = $('#list_paket').DataTable({
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
			url:"paket/dt_paket.php",
			type:"POST",
			dataType:"json",
			error: function(){  // error handling
				$(".list_paket-error").html("");
				$("#list_paket").append('<tbody class="list_paket-error"><tr><th colspan="4">Data tidak ditemukan.</th></tr></tbody>');
				$("#list_paket_processing").css("display","none");
			},
		},
		"columns":[
			{"data" : "id_paket"},
			{"data" : "nama_paket"},
			{"data" : "harga",
				"render": function(data, type, a){
					var hrg = a.harga;
					return 'IDR&nbsp;'+hrg;
				}
			},
			{	"orderable": false,
				"searchable": false,
				"data": null,
				"defaultContent": '',
				"render": function ( data, type, a ) {
					var pid = a.id_paket;
					var nm	= a.nama_paket;
					var idr	= a.harga;
					var ket	= a.keterangan;
					return '<a id="'+pid+'" nm="'+nm+'" idr="'+idr+'" ket="'+ket+'" href="#" class="btn btn-info edit_pkt" title="Edit"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;&nbsp;<a id="'+pid+'" href="#" class="btn btn-danger del_pkt" title="Delete"><i class="fa fa-trash"></i></a>';
					}
			},
			{
				"className":      'details-control',
				"orderable":      false,
				"data":           null,
				"defaultContent": ''
			}
			
		]
	});
	function format(x){
		return '<table cellpadding="3" cellspacing="0" border="0" style="padding-left:50px;">'+
			'<tr>'+
				'<td align="left" valign="top">Keterangan</td>'+
				'<td valign="top">&nbsp;&nbsp;:&nbsp;&nbsp;</td>'+
				'<td></td>'+
				'<td align="justify">'+x.keterangan+'</td>'+
			'</tr>'+
			'</table>'
	}
	$('#list_paket tbody').on('click', 'td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = $('#list_paket').DataTable().row(tr);

		if ( row.child.isShown()) {
			// This row is already open - close it
			row.child.hide();
			tr.removeClass('shown');
		}
		else {
			// Open this row
			row.child(format(row.data()) ).show();
			tr.addClass('shown');
		}
	});
	$(document).on('click','.add_pkt',function(){
		$('#new_pkt').attr('style','display:show');
	});
	$(document).on('click','.edit_pkt',function(){
		$('#edit_pkt').attr('style','display:show');
			var a	= $(this).attr('id');
			var b	= $(this).attr('nm');
			var c 	= $(this).attr('idr');
			var d	= $(this).attr('ket');
			$('#id_paket_ed').val(a);
			$('#nama_paket_ed').val(b);
			$('#harga_ed').val(c);
			$('#keterangan_ed').val(d);
	});
	$(document).on('click','.del_pkt',function(){
		if(confirm("Anda yakin akan menghapus paket ini?")){
		var del_id = $(this).attr('id');
			$.ajax({
				type: "POST",
				url: "paket/del_paket.php?del_id="+del_id,
				data:{del_id:del_id},
				success: function(){
					$('#list_paket').DataTable().ajax.reload();
				}
			});
			e.stopImmediatePropagation();
		}
	});
});
</script>
<div class="row">
<div id="tabel_pkt" class="col-md-7">
	<div class="panel panel-default">
		<div class="panel-body">
			<fieldset>
			<legend>Paket Layanan</legend>
			<a id="add_paket" href="#" class="btn btn-info add_pkt"><i class="fa fa-plus"></i> Paket Baru</a>
			<br></br>
			<table id="list_paket" class="table table-striped table-bordered responsive" cellspacing="0" width="100%" style="margin-left:-10px;text-align:justify;">
				<thead>
					<tr>
						<th width="15px">ID </th>
						<th>Nama Paket</th>
						<th>Harga</th>
						<th width="75px">Action</th>
						<th width="10px"></th>
				</thead>
			</table>
			</fieldset>
		</div>
	</div>
</div>
<div class="col-md-5">
	<div id="pkt_container">
		<?php include('new_paket.php');?>
		<?php include('edit_paket.php');?>
	</div>
</div>
</div>