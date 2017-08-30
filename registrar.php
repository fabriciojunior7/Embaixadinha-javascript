<html>
	<head>
		<meta charset="UTF-8">
		<title>Junior (Registrado)</title>

		<?php

			
			$host = "localhost";
			$usuario = "root";
			$senha = "";
			$bancoDados = "u525042514_ranks";
			/*
			$host = "";
			$usuario = "";
			$senha = "";
			$bancoDados = "";
			*/

			date_default_timezone_set("America/Bahia");
			$data = date("d/m/Y - H:i:s");

			$conexao = mysqli_connect($host, $usuario, $senha, $bancoDados);
			mysqli_query($conexao, "SET NAMES 'utf8'");
			if(mysqli_connect_errno()){
				echo "Erro!";
			}

			$nome = $_GET["nome"];
			$recorde = $_GET["recorde"];
			if($nome == ""){
				$nome = "Anônimo";
			}

			$consulta = "INSERT INTO embaixadinha (nome, score, data) VALUES ('$nome', '$recorde', '$data')";
			$dados = mysqli_query($conexao, $consulta);

			mysqli_close($conexao);

			header("location: embaixadinha.php");

		?>

	</head>

	<body style="margin: 0px; background-color: rgb(0, 100, 0); color: white; font-size: 18px; font-family: Century Gothic;">
	</body>

</html>