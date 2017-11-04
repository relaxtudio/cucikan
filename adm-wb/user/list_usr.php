<style>
.aktif, .blokir, .panel, .btn {border-radius: 0 !important;}
#ket_user li span{
	display: inline-block;
	width: 12px;
	height: 12px;
	margin-right: 5px;
}
#ket_user ul{
	list-style-type: none;
}
#users{
	max-width: 300px;
	margin: auto;
}
#userchart{
	max-width: 150px;
	position: relative;
	margin: auto;
}
</style>
<script>
	$(document).ready(function() {
		var table = $('#list_usr').DataTable({
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
				url:"user/dt_usr.php",
				type:"POST",
				dataType:"json",
				error: function(){  // error handling
					$(".list_usr-error").html("");
					$("#list_usr").append('<tbody class="list_usr-error"><tr><th colspan="4">Data tidak ditemukan.</th></tr></tbody>');
					$("#list_usr_processing").css("display","none");
				}
				
			},
			"columns":[
				{"data": "id"},
				{"data": "username"},
				{"data": "email"},
				{
					"orderable": false,
					"searchable": false,
					"data": null,
					"defaultContent": '',
					"render": function ( data, type, full ) {
						var uid = full.id;
						var stats = full.usrcred;
						if(stats==2){
							return '<a id="'+uid+'" status="'+stats+'" href="#" class="btn btn-danger blokir" title="Blokir"><i class="fa fa-ban"></i></a> ';
						}
						if(stats==0){
							return '<a id="'+uid+'" status="'+stats+'" href="#" class="btn btn-success aktif" title="Aktifkan"><i class="fa fa-check"></i></a> ';
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
			var usrstats	= u.usrcred;
			if(usrstats==0){
				var usrstats = 'Diblokir';
			}
			if(usrstats==1){
				var usrstats = 'Admin';
			}
			if(usrstats==2){
				var usrstats = 'Aktif';
			}
			
		return '<table cellpadding="3" cellspacing="0" border="0" style="padding-left:50px;">'+
		'<tr>'+
			'<td align="left">Nama &nbsp; </td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+u.nama+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">Alamat &nbsp; </td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+u.alamat+', '+u.kota_kab+', '+u.kecamatan+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">Telepon &nbsp; </td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+u.telepon+'</td>'+
		'</tr>'+
		'<tr>'+
			'<td align="left">Status &nbsp; </td>'+
			'<td>:</td>'+
			'<td></td>'+
			'<td align="left">&nbsp;&nbsp;'+usrstats+'</td>'+
		'</tr>'+
		'</table>'
		}
		
		$('#list_usr tbody').on('click', 'td.details-control', function () {
			var tr = $(this).closest('tr');
			var row = $('#list_usr').DataTable().row(tr);

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
		$(document).on('click','.blokir',function(e){
			var uid = $(this).attr('id');
			console.log(uid);
			$.ajax({
				type: 'POST',
				url: 'user/blokir.php?block='+uid,
				data: {uid:uid},
				success: function(response){
					$('#list_usr').DataTable().ajax.reload();
					alert('Akun berhasil diblokir');
				}
			});
			e.stopImmediatePropagation();
		});
		$(document).on('click','.aktif',function(e){
			var uid = $(this).attr('id');
			console.log(uid);
			$.ajax({
				type: 'POST',
				url: 'user/aktif.php?aktif='+uid,
				data: {uid:uid},
				success: function(response){
					$('#list_usr').DataTable().ajax.reload();
					alert('Akun berhasil diaktifkan');
				}
			});
			e.stopImmediatePropagation();
		});
	});
</script>
<div class="row">
<div class="col-md-7">
<fieldset>
<legend>Daftar Akun</legend>
<table id="list_usr" class="table table-striped table-bordered responsive" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th width="15px">ID</th>
			<th>Username</th>
			<th>Email</th>
			<th width="20px;">Action</th>
			<th width="10px;"></th>			
		</tr>
	</thead>
</table>
</fieldset>
</div>
<div class="col-md-5">
<fieldset>
<br></br>
<div id="users" class="panel panel-default">
	<div class="panel-body">
	<legend align="center">Account Status Chart</legend>
	<div id="userchart-container">
		<canvas id="userchart"></canvas>
		<script>
			$(document).ready(function(){
				$.ajax({
					type: "POST",
					url: "user/dt_usr_chart.php",
					dataType: "json",
					success: function(data){
						var tblok = [];
						var tadmin	= [];
						var taktif = [];
						var ttotal = [];
						for (var i in data){
							tblok.push(data[i].diblokir);
							tadmin.push(data[i].admin);
							taktif.push(data[i].aktif);
							ttotal.push(data[i].total)
						}
													
						var dtuser = {
							labels 	: ["Diblokir", "Aktif"],
							datasets: [{
								label: "Total Akun",
								data: [tblok, taktif],
								backgroundColor: ["#CD5B59", "#46FA8A"],
								borderwidth: [1,1]
							}]
						}
						
						var ctx3 = $("#userchart");
						var donat= new Chart(ctx3,{
							type: 'doughnut',
							data: dtuser,
							options: {
								responsive: true,
								cutoutPercentage: 65,
								legend: {
									display: false
								}
							}
						});
						document.getElementById('ket_user').innerHTML = donat.generateLegend();
						$("#ket_user").append("<p style='font-size:15px;padding-left:10%;'>Total Akun :<b> "+ttotal+"<b/></p>");
					}
				});
			});
		</script>
	<div id="ket_user" style="padding-left:30%"></div>
	</div>
</div>
</div>
</fieldset>
</div>
</div>