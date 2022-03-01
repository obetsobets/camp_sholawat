<form class="row g-3" id="formData" method="post">
  <div class="col-auto">
    <label for="kode" class="visually-hidden">Kode</label>
    <input type="text" class="form-control" id="kode_institusi" name="kode_institusi" placeholder="Kode" required>
  </div>
  <div class="col-12">
    <label for="Nama Institusi" class="visually-hidden">Nama Institusi</label>
    <input type="text" class="form-control" id="nama_institusi" name="nama_institusi" placeholder="Nama Institusi" required>
  </div>
  <div class="col-12">
    <label for="Singkatan" class="visually-hidden">Singkatan</label>
    <input type="text" class="form-control" id="singkatan_institusi" name="singkatan_institusi" placeholder="Singkatan" required>
  </div>
  <div class="col-12">
    <!-- <label for="Nama Provinsi" class="visually-hidden">Provinsi</label>
    <input type="text" class="form-control" id="id_provinsi" name="id_provinsi" placeholder="Nama Provinsi"> -->

    <select class="form-select" aria-label="Default select example" id="id_provinsi" name="id_provinsi" required>
	  
	</select> 
  </div>
  <hr>
  <div class="col-auto">
  	<button class="btn btn-primary form-control" type="submit" id="btn-simpan">Simpan</button>
  </div>
</form>

<script type="text/javascript">
	$(document).ready(function(){
		
		renderProvinsi();

		function renderProvinsi(currentValue = 0){
			$.ajax({
				method: "POST",
				url : "<?= base_url(); ?>Provinsi/getListData/",
			}).done(function(retval){
				var res = JSON.parse(retval);
				var listData = res['listData'];

				var strSelectHTML = ``;
				$.each(listData, function(key, val){
					//console.log(key);
					//console.log(val);
					var selected = currentValue == val.id_provinsi ? "selected" : "";
					strSelectHTML += `<option value="${val.id_provinsi}" ${selected}>${val.nama_provinsi}</option>`;
				})
				$("#id_provinsi").append(strSelectHTML);
			})
		}

		renderFormData();
		function renderFormData(){
			$.ajax({
				method: "POST",
				url : "<?= base_url(); ?>Institusi/getDataBySessionId/",
			}).done(function(retval){
				var res = JSON.parse(retval);
				//console.log(res);

				var data = res['data'];
				var kode='', nama='', singkatan='', id_provinsi='';
				if(data){
					kode = data['kode_institusi'] ? data['kode_institusi'] : '';
					nama = data['nama_institusi'] ? data['nama_institusi'] : '';
					singkatan = data['singkatan_institusi'] ? data['singkatan_institusi'] : '';
					id_provinsi = data['id_provinsi'] ? data['id_provinsi'] : 0;
				}
				
				

				renderProvinsi(id_provinsi);

				$("#formData input[name='kode_institusi']").val(kode);
				$("#formData input[name='nama_institusi']").val(nama);
				$("#formData input[name='singkatan_institusi']").val(singkatan);
				$("#formData input[name='id_provinsi']").val(id_provinsi);
			})
		}

		$("#formData").submit(function(event){
			event.preventDefault();
			var formData = $(this).serialize();

			$.ajax({
				method: "POST",
				url: "<?= base_url(); ?>Institusi/simpan/",
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