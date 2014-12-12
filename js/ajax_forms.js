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
	var foo = function() {
		var i = 0;
		var j = 0;
		var listOfObjects = [];
		$('#filter_leilao tr').each(function() {
			//alert('tr found');
			j=0;
			$(this).find('td').each (function() {  
				 
				//alert('td found');
				var data =  $(this).html();
				if(j == 0 && i != 0)
					listOfObjects.push(data);
					//alert();
				j++;
			});
			i++;
			
		}); 
		return listOfObjects;
	};
	/* Leilao_transaction Form Ajax */
	$("#leilao_transaction").submit(function(event){
		data = foo();
		/* Stop form from submitting normally */
		event.preventDefault();
		/* Get some values from elements on the page: */
		var values = $(this).serialize();
		//alert(values);
		v= values.substr(1);
		v = v.substr(1);
		v = v.substr(1);
		v = v.substr(1);
		var array = new Array();
		array = v.split("%2C");
		//alert(array.length);
		try{
			for(var i = 0; i < array.length; i += 1){
					var bool = 0;
					for(var j = 0; j < data.length; j += 1){
						if(array[i] == data[j])
							bool++;
					}
					if(bool == 0){
						alert("Erro um dos leiloes nao sao do mesmo dia!");
						return false;
					}
				//$(this).reject("Yolo");
				//return false;
			}
		}
		catch(err) {
			alert(err);
		}
		/*var mystr = values.lid.split(",");
		for (var i = 4; i < values.length; i += 1) {
			alert(values[i].lid);
		}*/
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
				//populateDivTable("leilaoinscritos.php","leiloesincritos");
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