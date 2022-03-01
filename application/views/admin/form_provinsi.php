<form class="row g-3" id="formData" method="post">
  <div class="col-auto">
    <label for="kode" class="visually-hidden">Kode</label>
    <input type="text" class="form-control" id="kode_provinsi" name="kode_provinsi" placeholder="Kode Provinsi">
  </div>
  <div class="col-12">
    <label for="Nama Provinsi" class="visually-hidden">Nama Provinsi</label>
    <input type="text" class="form-control" id="nama_provinsi" name="nama_provinsi" placeholder="Nama Provinsi">
  </div>
  <hr>
  <div class="col-auto">
  	<button class="btn btn-primary form-control" type="submit" id="btn-simpan">Simpan</button>
  </div>
</form>

<script type="text/javascript">
	$(document).ready(function(){

		renderFormData();
		function renderFormData(){
			$.ajax({
				method: "POST",
				url : "<?= base_url(); ?>Provinsi/getDataBySessionId/",
			}).done(function(retval){
				var res = JSON.parse(retval);
				//console.log(res);

				var data = res['data'];
				var kode_provinsi = data['kode_provinsi'] ? data['kode_provinsi'] : '';
				var nama_provinsi = data['nama_provinsi'] ? data['nama_provinsi'] : '';

				$("#formData input[name='kode_provinsi']").val(kode_provinsi);
				$("#formData input[name='nama_provinsi']").val(nama_provinsi);
			})
		}

		$("#formData").submit(function(event){
			event.preventDefault();
			var formData = $(this).serialize();

			$.ajax({
				method: "POST",
				url: "<?= base_url(); ?>Provinsi/simpan/",
				data: formData
			}).done(function(retval){
				var res = JSON.parse(retval);
				
				var sukses = res['sukses'];
				if(sukses){ //sukses == true OR sukses ==1
					alert("Data berhasil disimpan");
				}
				else{
					alert("Data gagal disimpan")
				}

			})
		})


	})
	
</script>