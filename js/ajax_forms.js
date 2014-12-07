$(document).ready(function(){
	/* Leilao Form Ajax */
	$("#leilao").submit(function(event){
		/* Stop form from submitting normally */
		event.preventDefault();
		/* Get some values from elements on the page: */
		var values = $(this).serialize();
		/* Send the data using post and put the results in a div */
		$.ajax({
			url: "leilao.php",
			type: "post",
			data: values,
			success: function(data){
				try {	
					var error = $(data).filter("#erro");
					//var error = $(data).find('#erro'); use this if div is nested
					if(error.html() != undefined && error.html() != "")
						alert(error.html());
				}
				catch(err) {
					console.log("Error not found");
				}
				populateDivTable("leilaoinscritos.php","leiloesincritos");
				populateDivTable("leilaotop.php","leiloestop");
				},
				error:function(){
					alert("failure");
					$("#result").html('There is error while submit');
				}
			});
	});
	/* Leilao_transaction Form Ajax */
	$("#leilao_transaction").submit(function(event){
		/* Stop form from submitting normally */
		event.preventDefault();
		/* Get some values from elements on the page: */
		var values = $(this).serialize();
		/* Send the data using post and put the results in a div */
		$.ajax({
			url: "leilao_transaction.php",
			type: "post",
			data: values,
			success: function(data){
				try {
					//alert(data);
					var error = $(data).filter("#erro");
					//var error = $(data).find('#erro'); use this if div is nested
					if(error.html() != undefined && error.html() != "")
						alert(error.html());
				}
				catch(err) {
					console.log("Error not found");
				}
				populateDivTable("leilaoinscritos.php","leiloesincritos");
				populateDivTable("leilaotop.php","leiloestop");
				},
			error:function(){
				alert("error");
			}
		});
	});

	/* Lance Form Ajax */
	$("#lance").submit(function(event){
		/* Stop form from submitting normally */
		event.preventDefault();
		/* Get some values from elements on the page: */
		var values = $(this).serialize();
		/* Send the data using post and put the results in a div */
		$.ajax({
			url: "lance.php",
			type: "post",
			data: values,
			success: function(data){
				try {
					//alert(data);
					var error = $(data).filter("#erro");
					//var error = $(data).find('#erro'); use this if div is nested
					if(error.html() != undefined && error.html() != "")
						alert(error.html());
				}
				catch(err) {
					console.log("Error not found");
				}
				populateDivTable("leilaoinscritos.php","leiloesincritos");
				populateDivTable("leilaotop.php","leiloestop");
			},
			error:function(){
				alert("failure");
				$("#result").html('There is error while submit');
			}
		});
	});
	
  	$("#table_filter_leilao").submit(function(event){
  		var selected = $('#dropdown_days').val();
		/* Stop form from submitting normally */
		event.preventDefault();
		/* Get some values from elements on the page: */
		//var values = $(this).serialize();
		/* Send the data using post and put the results in a div */
		$.ajax({
			url: "table_filterDay_leilao.php",
			type: "post",
			data: { dia:  selected },
			success: function(data){
				try {
					//alert(data);
					var error = $(data).filter("#erro");
					//var error = $(data).find('#erro'); use this if div is nested
					if(error.html() != undefined && error.html() != "")
						alert(error.html());
				}
				catch(err) {
					console.log("Error not found");
				}
				$('#table_filterDay_leilao').html(data);
				//populateDivTable("table_filterDay_leilao.php","table_filterDay_leilao");
			},
			error:function(){
				alert("failure");
				$("#result").html('There is error while submit');
			}
		});
	});
	/* Dropdown days as form */
	$("#dropdown_days").change(function() {
		$("#table_filter_leilao").submit();
  	});
});