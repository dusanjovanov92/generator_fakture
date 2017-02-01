<?php 
	session_start();
	error_reporting(0);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="css/stil_faktura.css?priority=1">
</head>
<body>
	<?php
	if(isset($_POST['dugme_generisi']))
	{
		$ukupna_poreska_osnovica;
		$ukupan_iznos_pdv;
		$sveukupna_naknada;

		$primalac_racuna = $_POST["primalac_racuna"];
		$adresa_primaoca_racuna = $_POST["adresa_primaoca_racuna"];
		$broj_fakture = $_POST["broj_fakture"];
		$datum_izdavanja_fakture = $_POST["datum_izdavanja_fakture"];
		$broj_otpremnice = $_POST["broj_otpremnice"];
		$datum_izdavanja_otpremnice = $_POST["datum_izdavanja_otpremnice"];
		$slovima = $_POST["slovima"];

		$div_zatvoren = "</div>";
		$paragraf = "<p>";
		$paragraf_velika_slova = "<p class='uppercase'>";
		$paragraf_zatvoren = "</p>";
		$paragraf_podnaslov = "<p class='subtitle'>";
		$clear = "<div class='clear'></div>";
		$novi_red ="<br>";
		$mesto ="26213 Crepaja ";

		$print_area = "<div id='print_area'>";
		$gornji_deo = "<div id='gornji_deo'>";
		$leva_kolona = "<div id='leva_kolona'>";
		$podaci_zadruga = "<p class='uppercase'>izdavalac računa</p>
						<p class='uppercase'>zz \"demetra 2008\"</p>
						<p>Crepaja, Heroja Raše bb</p>
						<p>PIB : 1054098153</p>
						<p>Tekući račun br. 205-129355-23</p>
						<p>Komercijalna banka AD Beograd</p>";
		$desna_kolona = "<div id='desna_kolona'>";
		$podaci_primalac = $paragraf_velika_slova."primalac racuna".$paragraf_zatvoren
						.$paragraf.$primalac_racuna.$paragraf_zatvoren
						.$paragraf.$adresa_primaoca_racuna.$paragraf_zatvoren;
		$donji_deo = "<div id='donji_deo'>";
		$naslov = "<h1 id='title' class='uppercase center'>faktura br. : ".$broj_fakture."/2016</h1>";
		$podnaslov1 = "Mesto i datum izdavanja fakture : ".$mesto.$datum_izdavanja_fakture;
		$podnaslov2 = "Na osnovu otpremnice br. ".$broj_otpremnice." od ".$datum_izdavanja_otpremnice;
		$tabela = napraviTabelu();
		$tablica = napraviTablicu();

		$ukupna_poreska_osnovica_format = dveDecimale($ukupna_poreska_osnovica);
		$ukupan_iznos_pdv_format = dveDecimale($ukupan_iznos_pdv);
		$sveukupna_naknada_format = dveDecimale($sveukupna_naknada);

		$ispodtabele1 = "<div id='ispod_tabele'><p class='uppercase'>poreska osnovica : &#9 ".$ukupna_poreska_osnovica_format."</p>";
		$ispodtabele2 = "<p class='uppercase'>pdv po: &#9 ".$ukupan_iznos_pdv_format."</p>";
		$isprekidana_linija = "----------------------------------------";
		$ispodtabele3 = "<p class='uppercase bold'>ukupan iznos za plaćanje: ".$sveukupna_naknada_format."</p>";
		$ispodtabele4 = "<p>SLOVIMA: ".$slovima."</p>";
		$potpis = "<div id='potpis'>
				<p class='uppercase'>izdavalac fakture</p>
				<p class='uppercase'>zz \"demetra 2008\"</p>
				<br>
				<p>___________________________________</p>
				<p class='bold'>Dragan Jovanov</p>
			</div>";


		echo $print_area.$gornji_deo.$leva_kolona.$podaci_zadruga.$div_zatvoren.$desna_kolona.$podaci_primalac.$div_zatvoren.$clear.$div_zatvoren
			.$novi_red.$donji_deo.$naslov.$novi_red.$paragraf_podnaslov.$podnaslov1.$paragraf_zatvoren.$paragraf_podnaslov.$podnaslov2.$paragraf_zatvoren.$novi_red.$tabela.
			$ispodtabele1.
			$ispodtabele2.
			$isprekidana_linija.
			$ispodtabele3.
			$novi_red.
			$isprekidana_linija.
			$ispodtabele4.
			$novi_red.
			$tablica.
			$novi_red.
			$potpis;

		session_destroy();
	}

	

	function napraviTabelu(){
	$tabela = "<table id='tabela'>";
	$tabela_zatvorena = "</table>";
		$thead = "<thead>";
		$thead_zatvoren = "</thead>";
		$tbody = "<tbody>";
		$tbody_zatvoren = "</tbody>";
		$red = "<tr>";
		$heder = "<th>";
		$red_zatvoren = "</tr>";
		$heder_zatvoren = "</th>";
		$celija = "<td>";
		$celija_zatvorena = "</td>";

		$rezultat = $tabela.$thead.$red.
					$heder."R.b.".$heder_zatvoren.
					$heder."naziv robe".$heder_zatvoren.
					$heder."j.m.".$heder_zatvoren.
					$heder."količina".$heder_zatvoren.
					$heder."cena po jed.".$heder_zatvoren.
					$heder."rabat".$heder_zatvoren.
					$heder."poreska osn.".$heder_zatvoren.
					$heder."stopa pdv".$heder_zatvoren.
					$heder."iznos pdv".$heder_zatvoren.
					$heder."ukupna naknada".$heder_zatvoren
					.$red_zatvoren.$thead_zatvoren.$tbody;

		if(isset($_SESSION["roba"])){
			$sesija = $_SESSION["roba"];

			$redni_broj = 1;
			foreach ($sesija as $roba) {
				$rezultat.=$red;
				
				//Dohvatanje i racunanje podataka za pojedinacni red
				$naziv_robe = $roba["naziv_robe"];
				$jm = $roba["jedinica_mere"];
				$kolicina = $roba["kolicina"];
				$cena_po_jedinici = $roba["cena_po_jedinici"];
				$rabat = "/";
				$poreska_osnovica = bezPdv($cena_po_jedinici) * $kolicina;
				$stopa_pdv = "10%";
				$ukupna_naknada = $cena_po_jedinici * $kolicina;
				$iznos_pdv = $ukupna_naknada - $poreska_osnovica;

				global $ukupna_poreska_osnovica;
				global $ukupan_iznos_pdv;
				global $sveukupna_naknada;

				//Globalne promenljive sa ukupnim rezultatima
				$ukupna_poreska_osnovica+= $poreska_osnovica;
				$ukupan_iznos_pdv+= $iznos_pdv;
				$sveukupna_naknada+= $ukupna_naknada;

				//Formatiranje za dve decimale
				$cena_po_jedinici_format = dveDecimale(bezPdv($cena_po_jedinici));
				$poreska_osnovica_format = dveDecimale($poreska_osnovica);
				$ukupna_naknada_format = dveDecimale($ukupna_naknada);
				$iznos_pdv_format = dveDecimale($iznos_pdv);

				//Upisivanje celija u tabelu
				$rezultat.= $celija.$redni_broj++.$celija_zatvorena.
							$celija.$naziv_robe.$celija_zatvorena.
							$celija.$jm.$celija_zatvorena.
							$celija.$kolicina.$celija_zatvorena.
							$celija.$cena_po_jedinici_format.$celija_zatvorena.
							$celija.$rabat.$celija_zatvorena.
							$celija.$poreska_osnovica_format.$celija_zatvorena.
							$celija.$stopa_pdv.$celija_zatvorena.
							$celija.$iznos_pdv_format.$celija_zatvorena.
							$celija.$ukupna_naknada_format.$celija_zatvorena;

				$rezultat.=$red_zatvoren;
			}

			$rezultat.=$red;

			$ukupna_poreska_osnovica_format = dveDecimale($ukupna_poreska_osnovica);
			$ukupan_iznos_pdv_format = dveDecimale($ukupan_iznos_pdv);
			$sveukupna_naknada_format = dveDecimale($sveukupna_naknada);

			for($i=0; $i<10; $i++){

				if($i==1){
					$rezultat.= $celija."UKUPNO".$celija_zatvorena;
				}
				else if($i==6){
					$rezultat.= $celija.$ukupna_poreska_osnovica_format.$celija_zatvorena;
				}
				else if($i==8){
					$rezultat.=$celija.$ukupan_iznos_pdv_format.$celija_zatvorena;
				}
				else if($i==9){
					$rezultat.=$celija.$sveukupna_naknada_format.$celija_zatvorena;
				}
				else{
					$rezultat.=$celija.$celija_zatvorena;
				}
			}

			$rezultat.$red_zatvoren;
		}

		$rezultat.=$tbody_zatvoren.$tabela_zatvorena;

		return $rezultat;
	}

	function napraviTablicu(){
$tabela_zatvorena = "</table>";
		$thead = "<thead>";
		$thead_zatvoren = "</thead>";
		$tbody = "<tbody>";
		$tbody_zatvoren = "</tbody>";
		$red = "<tr>";
		$heder = "<th>";
		$red_zatvoren = "</tr>";
		$heder_zatvoren = "</th>";
		$celija = "<td>";
		$celija_zatvorena = "</td>";

		global $ukupna_poreska_osnovica;
		global $ukupan_iznos_pdv;
				

		$ukupna_poreska_osnovica_format = dveDecimale($ukupna_poreska_osnovica);
		$ukupan_iznos_pdv_format = dveDecimale($ukupan_iznos_pdv);

		$rezultat= "<table id='pdv_tabela'>";
		$rezultat.=$red;
		$rezultat.=$celija."tarifa".$celija_zatvorena.
				$celija."stopa".$celija_zatvorena.
				$celija."osnovica".$celija_zatvorena.
				$celija."iznos".$celija_zatvorena;
		$rezultat.=$red_zatvoren;
		$rezultat.=$red;
		$rezultat.=$celija."pdv".$celija_zatvorena.
				$celija."10%".$celija_zatvorena.
				$celija.$ukupna_poreska_osnovica_format.$celija_zatvorena.
				$celija.$ukupan_iznos_pdv_format.$celija_zatvorena;
		$rezultat.=$red_zatvoren.$tabela_zatvorena;

		return $rezultat;
	}

	function bezPdv($cena_po_jed){
		return $cena_po_jed/1.1;
	}

	function dveDecimale($broj){
		return number_format($broj,2,'.','');
	}
	
?>
</body>
</html>
