<div id="progress_jamaah"></div>

<script type="text/javascript">
	//var sdata = [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175];

	getChartData();

	function getChartData() {
		$.ajax({
	      method: "POST",
	      url: "<?= base_url(); ?>Setoran/getListDataBySessionIdJamaah/",
	      data: {}
	    }).done(function(retval){
	      var res = JSON.parse(retval);
	      //console.log(res);
	      var listData = res['listData'];
	      var id = listData[0]['id_jamaah'];
	      var nama = listData[0]['nama_jamaah'];

	      var sdata = [];
	      var tdata = [];
	      var tanggalMulai = new Date(listData[0]['tanggal_masehi']);
	      var tanggalAkhir = new Date(listData[listData.length-1]['tanggal_masehi']);

	      /*console.log(tanggalMulai);
	      console.log(tanggalAkhir);*/

	      for(var i=0; i<listData.length; i++){
	      	tdata[new Date(listData[i]['tanggal_masehi'])] = listData[i]['jumlah'];
	      }

	      //console.log(tdata);

	      var jumlahHari = Math.round(tanggalAkhir-tanggalMulai)/(1000*60*60*24);

	      var inc = new Date(listData[0]['tanggal_masehi']);
	      while (inc<=tanggalAkhir){
	      	if(tdata[inc]){
	      		sdata.push(parseInt(tdata[inc]));
	      	}
	      	else{
	      		sdata.push(0);
	      	}

	      	inc.setDate(inc.getDate()+1);
	      }
	      //console.log(sdata);
	      renderGrafikSetoran(sdata, id, nama, tanggalMulai);
	    })
	}

	function renderGrafikSetoran(sdata, id, nama, tanggalMulai){
		//var tanggal = new Date(tanggalMulai);

		Highcharts.setOptions({
			lang: {
		  	thousandsSep: '.'
		  }
		})

		Highcharts.chart('progress_jamaah', {
		    title: {
		        text: `Progress Setoran - ${id} - <strong>${nama}</strong>`
		    },
		    subtitle: {
		        text: 'campsholawat-communitydevelopmnet.site'
		    },

		    yAxis: {
		    	/*type: 'logarithmic',
       			minorTickInterval: 1,*/
		        title: {
		            text: 'Jumlah Sholawat'
		        }
		    },

		    xAxis: {
		    	/*tickInterval: 1,
        		type: 'logarithmic',*/
        		allowDecimals: false,
		    	title: {
		            text: 'Tanggal Setoran'
		        },
		        type: 'datetime'
		    },

		    legend: {
		        layout: 'vertical',
		        align: 'right',
		        verticalAlign: 'middle'
		    },

		    plotOptions: {
		        series: {
		            label: {
		                connectorAllowed: false
		            },
		            pointStart: Date.UTC(tanggalMulai.getFullYear(), tanggalMulai.getMonth(), tanggalMulai.getDate()),
            		pointInterval: 24 * 3600 * 1000 // one day  
		        }
		    },

		    series: [{
		        name: 'Jumlah Sholawat',
		        data: sdata,
		        //pointStart: 1
		    }],

		    tooltip: {
		    	formatter: function() {
	                return  `<strong> ${this.series.name}</strong><br/>
	                Tanggal <strong>${Highcharts.dateFormat('%e %b %Y',new Date(this.x))}</strong><br>
	                Jumlah = <strong>${Highcharts.numberFormat(this.y, 0)}</strong>`;
	            },
		        /*headerFormat: '<b>{series.name}</b><br />',
		        pointFormat: 'Tanggal = {point.x}, Jumlah = {point.y}'*/
		    },

		    responsive: {
		        rules: [{
		            condition: {
		                maxWidth: 500
		            },
		            chartOptions: {
		                legend: {
		                    layout: 'horizontal',
		                    align: 'center',
		                    verticalAlign: 'bottom'
		                }
		            }
		        }]
		    }

		});
	}
	

</script>