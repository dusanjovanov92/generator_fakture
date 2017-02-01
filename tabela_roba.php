<?php
	session_start();

	if(isset($_POST["action"]) && $_POST["action"]=="obrisi_sve"){
		obrisiSve();
	}

	if(isset($_POST["action"]) && $_POST["action"]=="osvezi_listu"){
		$niz_roba = vratiListu();

		napraviTabelu($niz_roba);
	}
	if(isset($_GET["action"]) && $_GET["action"]=="obrisi_jedan"){
		$id = $_GET["id"];

		obrisiArtikal($id);
	}

	if(isset($_POST["action"]) && $_POST["action"]=="dodaj_robu"){
		$niz_roba = dodajRobuIVratiListu();

		napraviTabelu($niz_roba);
	}

	function vratiListu(){
		$niz_roba = array();

		if(isset($_SESSION["roba"])){
			$niz_roba = $_SESSION["roba"];
		}

		return $niz_roba;
	}

	function dodajRobuIVratiListu(){
		$naziv_robe = $_POST["naziv_robe"];
		$jedinica_mere = $_POST["jedinica_mere"];
		$kolicina = $_POST["kolicina"];
		$cena_po_jedinici = $_POST["cena_po_jedinici"];

		$nova_roba = ["naziv_robe"=> $naziv_robe, "jedinica_mere" => $jedinica_mere, "kolicina" => $kolicina, "cena_po_jedinici" => $cena_po_jedinici];
		$niz_roba = array();

		if(isset($_SESSION["roba"])){
			$niz_roba = $_SESSION["roba"];
			array_push($niz_roba,$nova_roba);
			$_SESSION["roba"] = $niz_roba;
		}
		else{
			array_push($niz_roba, $nova_roba);
			$_SESSION["roba"] = $niz_roba;
		}

		return $niz_roba;
	}

	function napraviTabelu($niz_roba){
		$tabela = "<table class='table table-bordered'>";
		$tabela_zatvorena = "</table>";
		$red = "<tr>";
		$heder = "<th>";
		$red_zatvoren = "</tr>";
		$heder_zatvoren = "</th>";
		$celija = "<td>";
		$celija_zatvorena = "</td>";

		$output = $tabela.
				$red.
					$heder."R.b.".$heder_zatvoren.
					$heder."naziv robe".$heder_zatvoren.
					$heder."jm".$heder_zatvoren.
					$heder."kolicina".$heder_zatvoren.
					$heder."cena po jed".$heder_zatvoren.
					$heder."akcije".$heder_zatvoren.
				$red_zatvoren;

		$ukupna_naknada = 0;

		$indeks = 1;
		foreach($niz_roba as $roba){
			$ukupna_naknada += $roba["kolicina"]* $roba["cena_po_jedinici"];

			$output.=$red;
			$output.=$celija.$indeks++.$celija_zatvorena;
			foreach ($roba as $value) {
				$output.= $celija.$value.$celija_zatvorena;
			}
			$output.= $celija."<a href='tabela_roba.php?action=obrisi_jedan&id=".(intval($indeks)-2)."' class='akcija_obrisi'>Obrisi</a>".$celija_zatvorena;
			$output.=$red_zatvoren;
		}

		$output.=$red;
		$output.=$celija."Ukupna naknada".$celija_zatvorena;
		$output.=$celija.$ukupna_naknada.$celija_zatvorena;
		$output.=$red_zatvoren;
		$output.=$tabela_zatvorena;

		echo $output;
	}

	function obrisiSve(){
		unset($_SESSION["roba"]);
	}

	function obrisiArtikal($id){
		unset($_SESSION["roba"][$id]);
	}

?>