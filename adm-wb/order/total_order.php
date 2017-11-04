
<script>
$(document).ready(function() {
		var table = $('#total_order').DataTable({
			"order": [[0, "desc"]],
			"language": {
            "lengthMenu": "Tampilkan _MENU_ data",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
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
			"pageLength": 5,
			"lengthMenu": [ 5, 10 ],
			"responsive": true,
			"deferRender": true,
			"processing": true,
			"serverSide": true,
			"ajax":{
				url:"order/dt_total_ord.php",
				type:"POST",
				dataType:"json",
				error: function(){  // error handling
					$(".total_order-error").html("");
					$("#total_order").append('<tbody class="total_order-error"><tr><th colspan="4">Data tidak ditemukan.</th></tr></tbody>');
					$("#total_order_processing").css("display","none");
				}
				
			},
			"columns":[
				//{"data": "id_order"},
				{"data": "invoice"},
				{"data": "nama"},
				{"data": "telepon"},
				{"data": "status"},
				{"data": "nama_paket"},
				{
					"orderable": false,
					"searchable": false,
					"data": null,
					"defaultContent": '',
					"render": function ( data, type, full ) {
						var uid = full.id_order;
						var stats = full.status;
						if(stats=='Order'){
							return '<a id="'+uid+'" status="'+stats+'" href="#" class="btn btn-info completed" title="Order Complete"><i class="fa fa-check"></i></a> ';
						}
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
		function format(u){			
		
		var date = new Date(u.tanggal);
		var month= date.getMonth() + 1;
		var newtanggal = date.getDate()+ "-" +(month.length > 1 ? month : "0" + month)+ "-" + date.getFullYear();
		
		return '<table cellpadding="3" cellspacing="0" border="0" style="padding-left:50px;">'+
		'<tr>'+
			'<td align="left">Mobil &nbsp; </td>'+
			'<td></td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+u.nama_brand+'&nbsp;'+u.produk_mobil+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">No. Polisi &nbsp; </td>'+
			'<td></td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+u.nopol+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">Alamat &nbsp; </td>'+
			'<td></td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+u.lokasi+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">Tanggal &nbsp; </td>'+
			'<td></td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+newtanggal+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">Jam &nbsp; </td>'+
			'<td></td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+u.jam+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">Email &nbsp; </td>'+
			'<td></td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+u.email+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">Harga &nbsp; </td>'+
			'<td></td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;IDR '+u.harga+',-</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">Pembayaran &nbsp; </td>'+
			'<td></td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+u.tipe_pembayaran+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">No. Rekening &nbsp; </td>'+
			'<td></td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+u.keterangan_pembayaran+'</td>'+
		'</tr>'+
		'</table>'
		}
		
		$('#total_order tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = $('#total_order').DataTable().row(tr);

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
		$(document).on('click','.completed',function(e){
			var uid = $(this).attr('id');
			console.log(uid);
			$.ajax({
				type: 'POST',
				url: 'order/completed.php?ord_id='+uid,
				data: {uid:uid},
				success: function(response){
					$('#total_order').DataTable().ajax.reload();
				}
			});
			e.stopImmediatePropagation();
		});
		//$(document).on('click','.cancel',function(e){
		//	var uid = $(this).attr('id');
		//	console.log(uid);
		//	$.ajax({
		//		type: 'POST',
		//		url: 'order/cancel.php?ord_id='+uid,
		//		data: {uid:uid},
		//		success: function(response){
		//			$('#total_order').DataTable().ajax.reload();
		//		}
		//	});
		//	e.stopImmediatePropagation();
		//});
	});
</script>
<fieldset>
<legend>Total Order</legend>
<table id="total_order" class="table table-striped table-bordered responsive" cellspacing="0" width="100%">
	<thead>
		<tr>
			<!--<th width="17px">No. </th>-->
			<th>Invoice</th>
			<th>Customer</th>
			<th>Telepon</th>
			<th>Status</th>
			<th>Paket Layanan</th>
			<th width="20px;">Action</th>
			<th width="15px;">Detail</th>			
		</tr>
	</thead>
</table>
</fieldset>