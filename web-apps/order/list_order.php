
<script>
	$(document).ready(function() {
		var DataTable = $('#historyorder').DataTable({
			language: {
            lengthMenu: "Tampilkan _MENU_ data",
            zeroRecords: "Tidak ada data yang ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            infoEmpty: "",
            infoFiltered: "<br />(Dari _MAX_ total data)",
			search: "Cari Data",
			paginate: {
				"first": "<<",
				"last": ">>",
				"next": ">",
				"previous": "<"
				}
			},
			responsive: true,
			pageLength: 5,
			lengthMenu: [ 5, 10 ],
			deferRender: true,
			processing: true,
			serverSide: true,
			ajax:{
				url:"order/dt_order.php",
				type:"POST",
				dataType:"json",
				succes: function(e){
					console.log(e);
				},
				error: function(){  // error handling
					$(".historyorder-error").html("");
					$("#historyorder").append('<tbody class="historyorder-error"><tr><th colspan="6">Data tidak ditemukan</th></tr></tbody>');
					$("#historyorder_processing").css("display","none");
				}
			},
			"columns":[
				{"data": "invoice"},
				{"data": "tanggal",
					"render": function(data){
					var date = new Date(data);
					var month = date.getMonth() + 1;
					return date.getDate()+ "-" +(month.length > 1 ? month : "0" + month)+ "-" + date.getFullYear();
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

function format(ord){
    // `d` is the original data object for the row

    return '<table cellpadding="2" cellspacing="0" class="responsive nowrap" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td align="left">Mobil &nbsp; </td>'+
			'<td>:</td>'+
            '<td align="left">&nbsp;&nbsp;'+ord.nama_brand+'&nbsp;'+ord.produk_mobil+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td align="left">Nama Pemesan &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+ord.nama+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td align="left">lokasi &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+ord.lokasi+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td align="left">Jam &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+ord.jam+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td align="left">Email &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+ord.email+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td align="left">Telepon &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+ord.telepon+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td align="left">Paket Layanan &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+ord.nama_paket+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td align="left">Total Harga &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;IDR&nbsp;'+ord.harga+',-</td>'+
        '</tr>'+
		'<tr>'+
            '<td align="left">Pembayaran &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+ord.tipe_pembayaran+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td align="left">Keterangan &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+ord.keterangan_pembayaran+'</td>'+
        '</tr>'+
        '<tr height="50px;">'+
			'<td colspan="3" align="right"><a id="'+ord.id_order+'" tgl="'+ord.tanggal+'" jam="'+ord.jam+'" class="btn btn-danger cancel-order" style="height: 30px; width:150px;font-size:12px;" href="#">Cancel Order*</a></td>'+
			'<td></td>'+
            '<td></td>'+
		'</tr>'+
		'<tr>'+
			'<td colspan = "3">*) Cancel order dapat dilakukan paling lambat H-2 jam dari jam order.</td>'+
		'</tr>'+
    '</table>'
	}
		$('#historyorder tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = $('#historyorder').DataTable().row(tr);

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
	});
</script>
<fieldset>
<p style="font-size:12px;"> Anda dapat melakukan pencarian data menggunakan data tanggal yang tersimpan.</p>
<table id="historyorder" class="table table-striped table-bordered" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>Invoice</th>
			<th width="30%">Tanggal</th>
			<th width="10px;">
				<script>
				$(function(){
					$(document).on('click','.cancel-order',function(){
						var cancel_id = $(this).attr('id');
						var tgl = $(this).attr('tgl');
						var jam = $(this).attr('jam');
						console.log(tgl, jam);
						var limit = new Date().getTime() + (2 * 60 * 60 * 1000);
						limit = new Date(limit);
						var input = new Date(tgl + " " + jam);
						console.log(limit, input);
						if (input > limit) {
							if (confirm("Anda yakin ingin membatalkan order ini?")) {
								console.log("yes");
								$.ajax({
								type: "POST",
								url: "order/cancel_order.php?cancel="+cancel_id,
								data: {cancel_id:cancel_id},
								success :function(){
									$("#content").load("home-content.php");
									alert("Order anda telah dibatalkan.");
									}
								});
							}
						} else {
							$(".cancel-order").prop("disabled", true);
							alert("Oops! Batas waktu cancel order anda sudah habis.");
						}
						
					});
				});
				</script>
			</th>
		</tr>
	</thead>
</table>
</fieldset>
