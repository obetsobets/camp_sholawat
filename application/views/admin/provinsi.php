<div class="card">
  <img src="<?= base_url(); ?>src/image/logo-unsri.jpg" class="" alt="..." width="100" height="100">
  <div class="card-body">
    <h5 class="card-title">Provinsi</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
	  <button class="btn btn-primary" type="button" id="btn_tambah">Tambah Data</button>
	</div>

	<p>
		<table id="table-data" class="display" style="width: 100%">
			<thead>
				<tr>
					<th>No</th>
					<th>Kode</th>
					<th>Nama Provinsi</th>
					<th>#Aksi</th>
				</tr>
			</thead>
			<tbody>
				
			</tbody>
			<tfoot>
			</tfoot>
		</table>
	</p>
    
  </div>

</div>

<!-- Modal -->
<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Form Data Provinsi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="hapusModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Hapus Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger" id="btn-konfirmasi-hapus">Hapus</button>
      </div>
    </div>
  </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
  <div id="liveToast" class="toast hide" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
      <img src="..." class="rounded me-2" alt="...">
      <strong class="me-auto">Bootstrap</strong>
      <small>11 mins ago</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
      Hello, world! This is a toast message.
    </div>
  </div>
</div>


<script type="text/javascript">
  $(document).ready(function() {
  	var option_table = {
		paging: true,
		searching: true,
		columnDefs: [
			{
				width: "6%",
				className: "dt-center",
				targets: [0]
			},
			{
				width: "15%",
				className: "dt-center",
				targets: [1]
			},
		]
	};

	var table_data = $("#table-data").DataTable(option_table);

	renderData();

	function renderData(){
		$.ajax({
			method: "POST",
			url: "<?= base_url(); ?>Provinsi/getListData/",
			data: {}
		}).done(function(retval){
			table_data.clear().draw(false);
			var res = JSON.parse(retval);
			//console.log(res);
			var listData = res['listData'];
			var rows = [];
			for (var i = 0; i < listData.length; i++) {
				var no = i+1;
				var id_provinsi = listData[i]['id_provinsi'];
				var kode = listData[i]['kode_provinsi'];
				var nama = listData[i]['nama_provinsi'];

				
				
				var aksi = `
					<button class="btn btn-warning btn-sm btn-edit" type="button" id_provinsi="${id_provinsi}">Edit</button>
					<button class="btn btn-danger  btn-sm btn-hapus" type="button" id_provinsi="${id_provinsi}">Hapus</button>
				`;

				rows.push([
					no,
					kode,
					nama,
					aksi
				]);
			}
			table_data.rows.add(rows).draw(false);
		})
	}

	$("#btn_tambah").click(function(){
		$("#formModal").find(".modal-body").load("<?= base_url(); ?>Provinsi/viewForm/")
		$("#formModal").modal('show');
	})

	$("#table-data").on('click','.btn-edit',function(){
		var id_provinsi = $(this).attr('id_provinsi');

		$("#formModal").find(".modal-body").load("<?= base_url(); ?>Provinsi/viewForm/",{
			id_provinsi
		})
		$("#formModal").modal('show');
	})

	$("#table-data").on('click','.btn-hapus',function(){
		var id_provinsi = $(this).attr('id_provinsi');

		$.ajax({
			method: "POST",
			url: "<?= base_url(); ?>Provinsi/getDataById/",
			data: {id_provinsi},
		}).done(function(retval){
			var res = JSON.parse(retval);
			var data = res['data'];
			//console.log(res);

			var strHtml = `Apakah data Provinsi dengan kode = <strong>${data['kode_provinsi']} dan Nama = ${data['nama_provinsi']}</strong> akan dihapus?`;
			$("#hapusModal").find(".modal-body").html(strHtml);

			$("#btn-konfirmasi-hapus").attr('id_provinsi',data['id_provinsi']);

			$("#hapusModal").modal('show');
		})
		
	})

	$("#btn-konfirmasi-hapus").click(function(){
		var id_provinsi = $(this).attr('id_provinsi');
		$.ajax({
			method: "POST",
			url: "<?= base_url(); ?>Provinsi/hapus/",
			data: {id_provinsi},
		}).done(function(retval){
			var res = JSON.parse(retval);
			var data = res['data'];
			//console.log(res);

			var notifikasiHtml = ``;

			if(data){  //kondisi berhasil dihapus, data sudah ditampung di var data
				renderData();
				notifikasiHtml = `Data Provinsi dengan kode ${data['kode_provinsi']} telah dihapus`;
				
			}
			else{ //kondisi gagal hapus
				notifikasiHtml = `Data Provinsi dengan kode ${data['kode_provinsi']} gagal dihapus`;
			}

			$("#hapusModal").modal('hide');
			$("#liveToast").find(".toast-body").html(notifikasiHtml);
			$("#liveToast").toast('show');
			
		})
		
	})
    
  })
</script>

