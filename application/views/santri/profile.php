<div class="card">
  <img src="<?= base_url(); ?>src/image/logo-unsri.jpg" class="" alt="..." width="100" height="100">
  <div class="card-body">
    <h5 class="card-title">Profile</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <a href="#" class="btn btn-primary">Go somewhere</a>
  </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
  Launch demo modal
</button>

<button type="button" class="btn btn-primary" id="btn-modal">
  Launch demo modal Cara ke-2
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" id="form_login" method="post">
		  <div class="col-auto">
		    <label for="email" class="visually-hidden">Email</label>
		    <input type="email" class="form-control-plaintext" id="email" name="email" placeholder="email@example.com">
		  </div>
		  <div class="col-auto">
		    <label for="password" class="visually-hidden">Password</label>
		    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
		  </div>
		</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" form="form_login" class="btn btn-primary">Login</button>
      </div>
    </div>
  </div>
</div>


<div id="param_out">
	
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#param_out").load("<?= base_url(); ?>Santri/getParam/");

		$("#form_login").submit(function(event){
			event.preventDefault();

			var formData = $(this).serialize();
			//console.log(formData);
			$.ajax({
				method: "POST",
				url: "<?= base_url(); ?>Santri/login/",
				data: formData
			}).done(function(retval){
				var res = JSON.parse(retval);
				console.log(res);

				var status_login = res['status_login'];
				if(status_login==1){
					alert("Silahkan Masuk");
				}
				else{
					alert("Autentikasi Salah")
				}

			})
		})

		$("#btn-modal").click(function(){
			$("#exampleModal").modal('show');
		})

	})
	
</script>
