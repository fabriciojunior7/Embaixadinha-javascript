<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<title>Junior (Novo Recorde)</title>

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

			$conexao = mysqli_connect($host, $usuario, $senha, $bancoDados);
			if(mysqli_connect_errno()){
				echo "Erro!";
			}

			$consulta = "SELECT nome, score FROM embaixadinha ORDER BY score DESC";
			$dados = mysqli_query($conexao, $consulta);
			$voltas = 0;
			$recordista = "";
			$recorde = "";
			$novoRecorde = $_POST["novo-recorde"];

			while($saida = mysqli_fetch_array($dados)){
				$voltas++;
				if($voltas == 1){
					$recordista = $saida['nome'];
					$recorde = $saida['score'];
				}

				$menorRecorde = $saida['score'];

				if($voltas > 9){
					break;
				}
			}
				if($voltas < 10){
					$menorRecorde = 0;
				}

			mysqli_close($conexao);

		?>

	</head>

	<body style="margin: 0px; background-color: rgb(0, 100, 0); color: white; font-size: 18px; font-family: Century Gothic;">

		<style type="text/css">
			
		#recorde{
			position: relative;
			font-size: 50px;
		}

		#nome{
			position: relative;
			width: 80%;
			height: 60px;
			border-radius: 20px;

			text-align: center;
			font-size: 40px;
		}

		#botao{
			position: relative;
			width: 80%;
			height: 60px;
			border-radius: 20px;
			font-size: 40px;
		}


		</style>

		<center>

			<?php

				if($novoRecorde >= 10){
					echo "<p id='recorde'>Novo Recorde:<br>$novoRecorde</p>";
					echo "<form method=get' action='registrar.php'>";
					echo "<input type='hidden' value=$novoRecorde name='recorde'>";
					echo "<input type='text' name='nome' id='nome' maxlength='10' placeholder='Nome'><br><br>";
					echo "<input type='submit' value='Enviar!' id='botao'>";
					echo "</form>";
				}
				else{
					header("location: embaixadinha.php");
				}
			
			?>

		</center>

	</body>

</html>