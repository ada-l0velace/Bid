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
		        	alert(data);
					populateDivTable("leilaoinscritos.php","leiloesincritos");
		        },
		        error:function(){
		            alert("failure");
		            $("#result").html('There is error while submit');
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
		        	alert(data);
					populateDivTable("leilaotop.php","leiloestop");
		        },
		        error:function(){
		            alert("failure");
		            $("#result").html('There is error while submit');
		        }
		    });
		});






});