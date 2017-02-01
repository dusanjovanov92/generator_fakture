<!DOCTYPE html>
<html>
<head>
	<title>Unos podataka</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/style.css?priority=1">
	<script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$.post({
    				url: "tabela_roba.php",
    				data: {
    					"action" : "osvezi_listu"
    				},
    				success: function(data){
    					document.getElementById("tabela_roba").innerHTML = data;
    				}
    		});

    		$("#jos_robe").click(function(){
        		$("#unos_robe").show();
    		}); 
    		$("#osvezi_listu").click(function(){
    			$.post({
    				url: "tabela_roba.php",
    				data: {
    					"action" : "osvezi_listu"
    				},
    				success: function(data){
    					document.getElementById("tabela_roba").innerHTML = data;
    				}
    			})
    		});
    		$("#obrisi_sve").click(function(){
    			$.post({
    				url: "tabela_roba.php",
    				data: {
    					"action" : "obrisi_sve"
    				},
    				success: function(){
    					console.log("uspesno sve obrisano");
    					$.post({
    						url: "tabela_roba.php",
    						data: {
    							"action" : "osvezi_listu"
    						},
    						success: function(data){
    							$("#tabela_roba").html(data);
    						}
    					});
    				}
    			});
    		});
    		// $(".akcija_obrisi").click(function(e){
    		// 	e.stopImmediatePropagation();

    		// 	var href = $(this).attr("href");

    		// 	$.ajax({
    		// 		url: href,
    		// 		success: function(){
    		// 			$.post({
    		// 				url: "tabela_roba.php",
    		// 				data: {
    		// 					"action" : "osvezi_listu" 
    		// 				},
    		// 				success: function(data){
    		// 					$("#tabela_roba").html(data);
    		// 				}
    		// 			});
    		// 		}
    		// 	});
    		// });
    		$(document).on('click','.akcija_obrisi',function(e){

 				e.preventDefault();

 				var href = $(this).attr("href");

    			$.ajax({
    				url: href,
    				success: function(data){
    					console.log("uspesno obrisan artikal "+ data);
    					$.post({
    						url: href,
    						data: {
    							"action" : "osvezi_listu" 
    						},
    						success: function(data){
    							$("#tabela_roba").html(data);
    						}
    					});
    				}
    			});

			});
    		$("#otkazi").click(function(){
        		$("#unos_robe").hide();
    		}); 
    		$("#dodaj_robu").click(function(){
    			$("#unos_robe").hide();

    			var naziv_robe = $("#naziv_robe").val();
    			var jedinica_mere = $("#jedinica_mere").val();
    			var kolicina = $("#kolicina").val();
    			var cena_po_jedinici = $("#cena_po_jedinici").val();

    			$.post('tabela_roba.php', 
    				{
    					"action" : "dodaj_robu",
      					"naziv_robe" : naziv_robe,
      					"jedinica_mere" : jedinica_mere,
      					"kolicina" : kolicina,
      					"cena_po_jedinici" : cena_po_jedinici
   					},
   					function(data){
   						// $("#tabela_roba").innerHTML = data;
   						document.getElementById("tabela_roba").innerHTML = data;
   					});
    		});
    	});
	</script>
</head>
<body>
	<div id="wrapper">
	<div id="unos">
		<div id="unos_podataka" class="col-md-6">
		<h1>Unos podataka</h1>
		<br>
		<form action="generator.php" method="POST" name="form1">
			<div class="form-group">
    			<label for="primalac_racuna">Ime primaoca računa</label>
   	 			<input type="text" class="form-control" id="primalac_racuna" name="primalac_racuna">
   	 		</div>
   	 		<div class="form-group">
    			<label for="adresa_primaoca_racuna">Adresa primaoca računa</label>
   	 			<input type="text" class="form-control" id="adresa_primaoca_racuna" name="adresa_primaoca_racuna">
   	 		</div>
   	 		<div class="form-group">
    			<label for="broj_fakture">Broj fakture</label>
   	 			<input type="text" class="form-control" id="broj_fakture" name="broj_fakture">
   	 		</div>
   	 		<div class="form-group">
    			<label for="datum_izdavanja_fakture">Datum izdavanja fakture</label>
   	 			<input type="text" class="form-control" id="datum_izdavanja_fakture" name="datum_izdavanja_fakture">
   	 		</div>
   	 		<div class="form-group">
    			<label for="broj_otpremnice">Broj otpremnice</label>
   	 			<input type="text" class="form-control" id="broj_otpremnice" name="broj_otpremnice">
   	 		</div>
   	 		<div class="form-group">
    			<label for="datum_izdavanja_otpremnice">Datum izdavanja otpremnice</label>
   	 			<input type="text" class="form-control" id="datum_izdavanja_otpremnice" name="datum_izdavanja_otpremnice">
   	 		</div>
   	 		<div class="form-group">
    			<label for="slovima">Slovima</label>
   	 			<input type="text" class="form-control" id="slovima" name="slovima">
   	 		</div>
   	 		<div class="form-group">
    			<label for="lista_roba">Lista roba</label>
    			<br>
    			<button id="jos_robe" type="button" class="btn btn-primary">Dodaj robu</button>
    			<button id="osvezi_listu" type="button" class="btn btn-success">Osvezi listu</button>
    			<button id="obrisi_sve" type="button" class="btn btn-danger">Obrisi sve</button>
    			<br><br>
    			<div id="tabela_roba"></div>
   	 		</div>
  		
		<input id="dugme_generisi" name="dugme_generisi" type="submit" class="btn btn-primary" value="Napravi fakturu"> 
	</form>
	</div>
	<div id="unos_robe" class="col-md-6">
	<h2>Unos robe</h2>
		<div>
			<div class="form-group">
				<label for="naziv_robe">Naziv robe</label>
   	 			<input type="text" class="form-control" id="naziv_robe" name="naziv_robe">
			</div>
			<div class="form-group">
				<label for="jedinica_mere">Jedinica mere</label>
   	 			<input type="text" class="form-control" id="jedinica_mere" name="jedinica_mere">
			</div>
			<div class="form-group">
				<label for="kolicina">Količina</label>
   	 			<input type="text" class="form-control" id="kolicina" name="kolicina">
			</div>
			<div class="form-group">
				<label for="cena_po_jedinici">Cena po jedinici</label>
   	 			<input type="text" class="form-control" id="cena_po_jedinici" name="cena_po_jedinici">
			</div>
			<button id="dodaj_robu" class="btn btn-primary">Dodaj</button>
			<button id="otkazi" class="btn btn-primary">Otkazi</button>
		</div>
	</div>
	<div class="clear"></div>
	</div>
	<br>
	
	</div>
</body>
</html>