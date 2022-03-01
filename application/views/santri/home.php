<!DOCTYPE html>
<html>
	<head>
		<title>PC Batch-1</title>
	<!-- <link rel="stylesheet" type="text/css" href="https://localhost/pc-batch1/hari-1/src/css/obets.css"> -->
	<!-- <?= base_url(); ?> = https://localhost/pc-batch1/hari-1/ -->
	<link rel="stylesheet" type="text/css" href="<?= base_url(); ?>src/css/obets.css">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
	</head>
	<body>
		<h1>Selamat Datang di Web Penerimaan Santri Baru (PSB)</h1>
		<div class="person" onclick="helloo('Muhammad Fachrurrozi');">Muhammad Fachrurrozi</div>
		<div class="person">Erji Ridho</div>
		<place>Kota Palembang</place>

		<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from <label id="obets">45 BC</label> , making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in <span id="obets">section 1.10.32.</span></p>
		<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from "de Finibus Bonorum et Malorum" by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>

		<input type="text" id="input-nama"></input> 
		<button id="btn-hello">Hello</button>

		<select id="opsi-style">
			<option value="1">Merah</option>
			<option value="2">Hijau</option>
			<option value="3">Biru</option>
		</select>
		<button id="btn-listData">Lihat data</button>
		<div id="output_tag">
			
		</div>
		<div id="output_tag_2">
			
		</div>
		<div id="output_tag_3">
			
		</div>
		<div id="listData"></div>
		<table id="table-data" class="display" style="width:100%">
	        <thead>
	            <tr>
	                <th>NIS</th>
	                <th>Nama</th>
	                <th>Tanggal Lahir</th>
	            </tr>
	        </thead>
	        <tbody>
	        </tbody>
	    </table>
	</body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){
	var option_table = {
		paging: true,
		searching: true,
		columnDefs: [
			{
				width: "10%",
				className: "dt-center",
				targets: [0,2]
			},
			{
				className: "person",
				targets: [1]
			},
			{ "visible": true, "targets": 2 }
		]
	};

	var table_data = $("#table-data").DataTable(option_table);

	function helloo(nama) {
		//console.log("Hello "+nama); //debugging error
		$("#output_tag").text("<strong>Haloo "+nama+"</strong>");
		$("#output_tag_2").html(`Apa Kabar <strong>${nama}</strong>?, silahkan pilih Mata Pelajaran yang Anda paling sukai`);

	}

	$("#btn-hello").click(function(){
		var erji = $("#input-nama").val();
		var listMaPel = ['Bahasa Inggris','Olahraga'];
		listMaPel.push('Matematika');
		listMaPel.push('IPA');
		listMaPel.push('IPS');
		listMaPel.push('Sejarah');
		listMaPel.push('Bahasa Indonesia');

		//console.log(listMaPel);

		if(erji.length<2){
			$("#output_tag").html('<span style="color: red">Silahkan input nama terlebih dahulu...!</span>')
		}
		else{
			helloo(erji);
			var teks = `<ol>`;
			/*for (var i = 0; i < listMaPel.length; i++) {
				teks += `<li>${listMaPel[i]}</li>`;
			}*/
			listMaPel.forEach(function(mapel){
				teks += `<li>${mapel}</li>`;
			});

			teks += `</ol>`;
			$("#output_tag_3").html(teks);
		}
	})

	$("#opsi-style").change(function(){
		var id_color = $(this).val();
		var color = {
			1: "red",
			2: "green",
			3: "blue",
		}
		$("body").css("background-color", color[id_color]);
	})

	$("#btn-listData").click(function(){
		//$( "#listData" ).load( "<?= base_url(); ?>Santri/getListData/" );
		var filter_bulan = 1;
		var filter_tahun = 2005;

		$.ajax({
			method: "POST",
			url: "<?= base_url(); ?>Santri/getListData/",
			data: {filter_bulan, filter_tahun}
		}).done(function(res){
			var res = JSON.parse(res);
			console.log(res);
			var listData = res['listData'];
			renderDatav2(listData);
		})
	})

	function renderDatav2(listData){
		var rows = [];
		for (var i = 0; i < listData.length; i++) {
			var nis = listData[i]['nis'];
			var nama = listData[i]['nama'];
			var tanggal_lahir = listData[i]['tanggal_lahir'];

			rows.push([
				nis,
				nama,
				tanggal_lahir
				]);
		}

		table_data.rows.add(rows).draw(false);
	}

	function renderData(listData){
		var pData = '';
		var p='';
		for (var i = 0; i < listData.length; i++) {
			pData =  `
				<p><ul>
				<li>NIS : ${listData[i]['nis']} </li>
				<li>NAMA : ${listData[i]['nama']} </li>
				<li>Tanggal Lahir : ${listData[i]['tanggal_lahir']} </li>
				</ul></p>
			`;

			p +=pData;
		}

		$("#listData").html(p);
	}
});
	
	
</script>

