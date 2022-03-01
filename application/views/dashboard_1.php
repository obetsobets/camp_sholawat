<div class="container">
  <div class="row">
    <div class="col">
      <div id="dashboard_1_a">
    </div>
    <div class="col">
      <div id="dashboard_1_b">
    </div>
    <div class="col">
      <div id="dashboard_1_c">
    </div>
  </div>
</div>


<script type="text/javascript">
	getChartData();

	function getChartData() {
		$.ajax({
	      method: "POST",
	      url: "<?= base_url(); ?>Setoran/getSebaranDataBySessionIdJamaahByGender/",
	      data: {}
	    }).done(function(retval){
	      var res = JSON.parse(retval);
	      //console.log(res);
	      var listData = res['listData'];
	      
	      var sdata_ikhwan = [];
	      var sdata_akhwat = [];
	      var sdata_rerata_ikhwan = [];
	      var sdata_rerata_akhwat = [];

	      var tanggalMulai;

	      var total_sdata_ikhwan = 0;
	      var total_sdata_akhwat = 0;
	      for (var i = 0; i < listData.length; i++) {
	      	sdata_ikhwan.push(parseInt(listData[i]['IKHWAN']));
	      	sdata_akhwat.push(parseInt(listData[i]['AKHWAT']));

	      	sdata_rerata_ikhwan.push(parseInt(listData[i]['rerata_ikhwan']));
	      	sdata_rerata_akhwat.push(parseInt(listData[i]['rerata_akhwat']));

	      	total_sdata_ikhwan += parseInt(listData[i]['IKHWAN']);
	      	total_sdata_akhwat += parseInt(listData[i]['AKHWAT']);
	      		
	      	if(i==0){
	      		tanggalMulai = listData[i]['tanggal_masehi'];
	      	}
	      }
	      //console.log(tanggalMulai);
	      renderGrafikSebaranSetoran(sdata_ikhwan, sdata_akhwat, tanggalMulai);
	      renderGrafikSebaranRerataSetoran(sdata_rerata_ikhwan, sdata_rerata_akhwat, tanggalMulai);
	      renderGrafikRekapSetoran(total_sdata_ikhwan, total_sdata_akhwat);
	    })
	}

	function renderGrafikSebaranSetoran(sdata_ikhwan, sdata_akhwat, tanggalMulai){
		var tanggal = new Date(tanggalMulai);

		Highcharts.setOptions({
			lang: {
		  	thousandsSep: '.'
		  }
		})

		Highcharts.chart('dashboard_1_a', {
		    title: {
		        text: `Sebaran Setoran  - <strong>Berdasarkan Gender</strong>`
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
		            pointStart: Date.UTC(tanggal.getFullYear(), tanggal.getMonth(), tanggal.getDate()),
            		pointInterval: 24 * 3600 * 1000 // one day  
		        }
		    },

		    series: [{
		        name: 'Jumlah Sholawat Ikhwan',
		        data: sdata_ikhwan,
		        color: 'blue',
		        //pointStart: 1
		    },{
		        name: 'Jumlah Sholawat Akhwat',
		        data: sdata_akhwat,
		        color: 'red',
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

	function renderGrafikSebaranRerataSetoran(sdata_ikhwan, sdata_akhwat, tanggalMulai){
		var tanggal = new Date(tanggalMulai);

		Highcharts.setOptions({
			lang: {
		  	thousandsSep: '.'
		  }
		})

		Highcharts.chart('dashboard_1_b', {
		    title: {
		        text: `Rerata Setoran  - <strong>Berdasarkan Gender</strong>`
		    },
		    subtitle: {
		        text: 'campsholawat-communitydevelopmnet.site'
		    },

		    yAxis: {
		    	/*type: 'logarithmic',
       			minorTickInterval: 1,*/
		        title: {
		            text: 'Rerata Sholawat'
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
		            pointStart: Date.UTC(tanggal.getFullYear(), tanggal.getMonth(), tanggal.getDate()),
            		pointInterval: 24 * 3600 * 1000 // one day  
		        }
		    },

		    series: [{
		        name: 'Rerata Sholawat Ikhwan',
		        data: sdata_ikhwan,
		        color: 'blue',
		        //pointStart: 1
		    },{
		        name: 'Rerata Sholawat Akhwat',
		        data: sdata_akhwat,
		        color: 'red',
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

	function renderGrafikRekapSetoran(total_sdata_ikhwan, total_sdata_akhwat){
		
		Highcharts.setOptions({
			lang: {
		  	thousandsSep: '.'
		  }
		})

		Highcharts.chart('dashboard_1_c', {
	    chart: {
	        plotBackgroundColor: null,
	        plotBorderWidth: null,
	        plotShadow: false,
	        type: 'pie'
	    },
	    title: {
	        text: 'Persentase Jumlah Setoran <strong>Berdasarkan Gender</strong>'
	    },
	    tooltip: {
	        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	    },
	    accessibility: {
	        point: {
	            valueSuffix: '%'
	        }
	    },
	    plotOptions: {
	        pie: {
	            allowPointSelect: true,
	            cursor: 'pointer',
	            dataLabels: {
	                enabled: true,
	                format: '<b>{point.name}</b>: {point.percentage:.1f} %'
	            }
	        }
	    },
	    series: [{
	        name: 'Persentase',
	        colorByPoint: true,
	        data: [{
	            name: 'IKHWAN',
	            y: total_sdata_ikhwan,
	            color: 'blue',
	            sliced: true,
	            selected: true
	        }, {
	            name: 'AKHWAT',
	            y: total_sdata_akhwat,
	            color: 'red'
	        }]
	    }]
	});	
	}

	

</script>