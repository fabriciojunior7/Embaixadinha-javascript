<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<title>Junior (Embaixadinha)</title>

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
			mysqli_query($conexao, "SET NAMES 'utf8'");
			if(mysqli_connect_errno()){
				echo "Erro!";
			}

			$consulta = "SELECT nome, score FROM embaixadinha ORDER BY score DESC";
			$dados = mysqli_query($conexao, $consulta);
			$voltas = 0;
			$recordista = "";
			$recorde = "";

		?>

	</head>

	<body style="margin: 0px; background-color: rgb(255, 255, 255); color: rgb(150, 150, 150); font-size: 150%; font-family: Century Gothic;">

		<center>

		<h1>=========<br>Instruções<br>=========</h1>
		<h4>--- Touch/Click ---</h4>Toque na bola para fazer embaixadinhas<br>
		<h4>--- Dica ---</h4>Toque um pouco<br>abaixo da bola<br>
		<font color="red"><h4>--- AVISO ---</h4>Peguenos Bugs em<br>Iphones</font><br><br><br>
		<a href="embaixadinha.php" style="text-decoration: none; color: black; font-family: Arial; font-size: 26px;">> JOGAR <</a><br><br><br>
		<a href="rankingCompleto.php" style="text-decoration: none; color: black; font-family: Arial; font-size: 26px;">> Ver Ranking Completo <</a><br><br><br>

		<div id="ranking" style="font-family: Arial; border: 0px solid black; border-radius: 70px; color: rgb(70, 70, 70); width: 90%; background-color: rgb(220, 220, 220); padding-bottom: 20px; padding-top: 0px;">

		<p style="font-size: 40px; color: rgb(0, 0, 0); padding-top: 10px;">TOP 10</p>
		<?php
			while($saida = mysqli_fetch_array($dados)){
				$voltas++;
				//echo "<h2>$saida[nome], $saida[score]";
				$recordista = $saida['nome'];
				$recorde = $saida['score'];
				echo "<br>";

				echo "($voltas) $recordista - $recorde";
				
				if($voltas > 9){
					break;
				}
			}

			mysqli_close($conexao);
			?>
		</div>

		<br>
		<div align=center><a href='http://contador.s12.com.br'><img src='http://contador.s12.com.br/img-0dB81Yw2w23CCyB5-3.gif' border='0' alt='contador de acesso grátis'></a><script type='text/javascript' src='http://contador.s12.com.br/ad.js?id=0dB81Yw2w23CCyB5'></script></div><br><br><br>

		</center>

	</body>

</html>