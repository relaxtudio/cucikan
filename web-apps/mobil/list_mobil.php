<style>
#listmobil td{
	align: left;
}
</style>
<script>	
	$(document).ready(function() {
		var table = $('#listmobil').DataTable({
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
				url:"mobil/dt_mobil.php",
				type:"POST",
				dataType:"json",
				error: function(){  // error handling
					$(".listmobil-error").html("");
					$("#listmobil").append('<tbody class="listmobil-error"><tr><th colspan="3">Data tidak ditemukan.</th></tr></tbody>');
					$("#listmobil_processing").css("display","none");
				}
			
			},
			"columns":[
				{"data": "nopol"},
				{"data": getBrandProdukMobil},
				{
					"className":      'details-control',
					"orderable":      false,
					"data":           null,
					"defaultContent": ''
				}
			]
    });
	function getBrandProdukMobil(data, type, dataToSet){
		return data.nama_brand + " " + data.produk_mobil;
	}
		function format(d){
    // `d` is the original data object for the row
    return '<table cellpadding="3" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td align="left">Tahun &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+d.tahun+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td align="left">Warna &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+d.warna+'</td>'+
        '</tr>'+
		'<tr>'+
            '<td align="left">Nama Pemilik &nbsp; </td>'+
			'<td>:</td>'+
			'<td align="left">&nbsp;&nbsp;'+d.nama_pemilik+'</td>'+
        '</tr>'+
        '<tr height="50px;">'+
            '<td><a id="'+d.id_kendaraan+'" class="btn btn-info edit-mobil" href="#">edit</a></td>'+
            '<td></td>'+
			'<td><a id="'+d.id_kendaraan+'" class="btn btn-danger delete-mobil" href="#">Delete</a></td>'+
        '</tr>'+
    '</table>'
	}
		// Add event listener for opening and closing details
		$('#listmobil tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = $('#listmobil').DataTable().row(tr);
	 
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
<p style="font-size:12px;"> Anda dapat melakukan pencarian data meggunakan data No. Polisi mobil yang tersimpan.</p>
<table id="listmobil" class="table table-striped table-bordered responsive" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th width="30%">No. Polisi</th>
			<th>Mobil</th>
			<th width="10px;">
			<script>
			$(function(){
			$(document).on('click','.delete-mobil',function(){
				var del_id	= $(this).attr('id');
				$.ajax({
					type: 'POST',
					url: 'mobil/del_mobil.php?'+del_id,
					data: {del_id:del_id},
					success: function(){
						$('#listmobil').DataTable().ajax.reload();
						alert('Data berhasil dihapus');
					}
					});
				});
			});
			$(function(){
			$(document).on('click','.edit-mobil',function(){
				var edit_id	= $(this).attr('id');
				 $('#content').load('mobil/edit_mobil.php?mobil='+edit_id);
				});
			});
			</script>
			</th>			
		</tr>
	</thead>
</table>
</fieldset>