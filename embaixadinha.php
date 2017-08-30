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
			$menorRecorde = "";

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

	<body style="background-color: rgb(0, 0, 0); margin: 0px; text-align: center; position: fixed; color: white;">

		<form action="novo-recorde.php" method="post" id="formulario">
			<input type="hidden" name="novo-recorde" value="" id="novo-recorde" />
		</form>

		<script language="javascript" type="text/javascript" src="libraries/p5.js"></script>
  		<script language="javascript" src="libraries/p5.dom.js"></script>
  		<script language="javascript" src="libraries/p5.sound.js"></script>
  		<script language="javascript" src="libraries/p5.collide2d.js"></script>
		<script language="javascript" type="text/javascript">

			var largura, altura;
			var bola, barra;
			var frames = 60;
			var input;
			//document.cookie = "5";

			//var ultimoScore = 0;
			var meuRecorde = 0;

			var recordista = "<?php echo $recordista; ?>";
			var recorde = "<?php echo $recorde; ?>";
			var menorRecorde = "<?php echo $menorRecorde; ?>";
			var biscoito;

			var menu1X, menu1Y, menu2X, menu2Y, menuVisivel;
			var frameScore = 0, framePausa = 10;

			var inicio, hit1, hit2, hitBarra, recordeOnline, every10, every50, every100, somAleatorio, barraAtivarSom, barraDesativarSom;
			
			function preload(){
				inicio = loadSound("sons/inicio.mp3");
				hit1 = loadSound("sons/hit1.mp3");
				hit2 = loadSound("sons/hit2.mp3");
				//lose = loadSound("sons/lose.mp3");
				barraAtivarSom = loadSound("sons/barraAtivar.mp3");
				barraDesativarSom = loadSound("sons/barraDesativar.mp3");
				recordeOnline = loadSound("sons/recordeOnline.mp3");
				every10 = loadSound("sons/every10.mp3");
				every50 = loadSound("sons/every50.mp3");
				every100 = loadSound("sons/every100.mp3");
			}

			function setup(ultimoScore){
				inicio.setVolume(0.3);
				//lose.setVolume(0.3);
				//meuRecordeSom.setVolume(0.3);
				recordeOnline.setVolume(0.3);

				if(ultimoScore > meuRecorde){meuRecorde = ultimoScore;}

				inicio.play();
				frameRate(frames);
				if(windowWidth > 300){
					largura = windowWidth;
				}
				else{
					largura = 300;
				}
				altura = windowHeight;

				tela = createCanvas(largura, altura);
				tela.position(0, 0);

				//Objetos
				bola = new Bola(largura/2.0, altura/2.0, 80);
				barra = new Barra(largura, altura, 10);
				textSize(24);

				//Biscoito
				//document.cookie = "meuRecorde=0";
				//biscoito = document.cookie;
				//if(biscoito == "" || biscoito == "1" || biscoito == "1490981573612"){
				//	meuRecorde = 0;
				//	document.cookie = "meuRecorde=0";
				//}
				//meuRecorde = int(biscoito.split("=")[1]);
				//print("Este: "+meuRecorde);
				//if(meuRecorde < 2 || meuRecorde >= 10000){
				//	document.cookie = "meuRecorde=0";
				//}

				//Menu
				menu1X = -100;
				menu1Y = -100;
				menu1Largura = 100;
				menu1Altura = 40;
				menu2X = -100;
				menu2Y = -100;
				menu2Largura = 100;
				menu2Altura = 40;

				menuVisivel = false;

				hitMenu1 = false;
				hitMenu2 = false;
			}

			function draw(){
				background(0);
				//Roda
				if(bola.start == true){bola.atualizarPosicao(altura);}
				hitBarra = collideRectRect(barra.x, barra.y, barra.largura, barra.altura, bola.x-bola.raio, bola.y-bola.raio, bola.diametro, bola.diametro);
				if(hitBarra == true){bola.velocidadeY = barra.colidir(largura, altura);}
				//Desenhar
				if(barra.ativado == true){barra.desenhar();}
				bola.desenhar();
				//Texto Meu Recorde e BarraRestante
				textSize(24);
				fill(255);
				if(meuRecorde < 10){text(meuRecorde, largura-20, 25);}
				else if(meuRecorde < 100){text(meuRecorde, largura-30, 25);}
				else if (meuRecorde < 1000){text(meuRecorde, largura-45, 25);}
				else{text(meuRecorde, largura-58, 25);}
				textSize(16);
				fill(255, 90, 90);
				if((barra.restante*(-1)) < 10){text(barra.restante, largura-24, 45);}
				else if((barra.restante*(-1)) < 100){text(barra.restante, largura-30, 45);}
				else if((barra.restante*(-1)) >= 100){text(barra.restante, largura-34, 45);}
				//Texto Ranking
				textSize(12);
				fill(255, 255, 0);
				text(recordista, 0, 12);
				text(recorde, 10, 25);
				//Texto Score
				textSize(24);
				fill(0);
				if(bola.score < 10){text(bola.score, bola.x-6, bola.y+10);}
				else if(bola.score < 100){text(bola.score, bola.x-13, bola.y+10);}
				else if(bola.score < 1000){text(bola.score, bola.x-19, bola.y+10);}
				else{text(bola.score, bola.x-26, bola.y+10);}
				//Logo
				textSize(8);
				fill(255);
				text("Fabricio Junior", 5, altura-5);
				//Menu
				if(menuVisivel == true){
					//menu1X = (largura/2.0)-50;
					//menu1Y = (altura*0.75);
					//menu1Largura = 100;
					//menu1Altura = 40;
					//menu2X = (largura/2.0)-50;
					//menu2Y = (altura*0.9);
					//menu2Largura = 100;
					//menu2Altura = 40;

					textSize(26);
					fill(255);
					text(bola.score, (largura/2.0)-20, (altura*0.4))
					text("Enviar Pontuação?", (largura/2.0)-115, 100);
					rect(menu1X, menu1Y, menu1Largura, menu1Altura);
					rect(menu2X, menu2Y, menu2Largura, menu2Altura);
					fill(0);
					text("Sim", (largura/2.0)-22, (altura*0.6)+30);
					text("Não", (largura/2.0)-22, (altura*0.75)+30);
					
					if(hitMenu1 == true){
						fill(0, 255, 0);
						text("Carregando...", (largura/2.0)-78, 160);
						enviarRecorde(bola.score);
					}
					else if(hitMenu2 == true){
						//mouseX = largura/2.0;
						//mouseY = altura/2.0;
						gameOver(0);
					}
					//noLoop();
				}
			}

			function touchStarted(){
				hit = collidePointRect(mouseX , mouseY, bola.x-bola.raio, bola.y-bola.raio, bola.diametro, bola.diametro+25);

				hitMenu1 = collidePointRect(mouseX , mouseY, menu1X, menu1Y, menu1Largura, menu1Altura);
				hitMenu2 = collidePointRect(mouseX , mouseY, menu2X, menu2Y, menu2Largura, menu2Altura);

				if(hit == true && (frameCount > frameScore + framePausa)){
					frameScore = frameCount;
					barra.restante++;
					if(barra.restante == 0){barra.ativar(altura);}
					bola.pular(mouseX, mouseY);
				}
				return(false);
			}

			function gameOver(score){
				//Meu Recorde
				if(score > menorRecorde){
					enviarRecorde(score);
				}
				else{
					if(score > meuRecorde){
					meuRecorde = score;
					}
					//Recorde Online
					if(score >= 10){
						menu1X = (largura/2.0)-50;
						menu1Y = (altura*0.6);
						menu1Largura = 100;
						menu1Altura = 40;
						menu2X = (largura/2.0)-50;
						menu2Y = (altura*0.75);
						menu2Largura = 100;
						menu2Altura = 40;
						menuVisivel = true;
					}
					else{
						menu1X = -100;
						menu1Y = -100;
						menu2X = -100;
						menu2Y = -100;
						mouseX = largura/2.0;
						mouseY = altura/2.0;
						menuVisivel = false;
						setup(meuRecorde);
					}
				}
			}

			function enviarRecorde(score){
				input = document.getElementById("novo-recorde");
				input.value = score;
				document.forms["formulario"].submit();
			}

			//Classes

			function Bola(x, y, diametro){
				//Atributos
				this.x = x;
				this.y = y;
				this.diametro = diametro;
				this.raio = this.diametro / 2.0;
				this.velocidadeX = 0;
				this.velocidadeY = 0;
				this.gravidade = 0.5;
				this.forcaPulo = round(random(10, 16));
				this.start = false;
				this.score = 0;
				this.framePausa = 10;
				this.frameScore = -this.framePausa;

				//Metodos
				this.desenhar = function(){
					noStroke();
					fill(255);
					ellipse(this.x, this.y, this.diametro, this.diametro);
				}

				this.pular = function(x, y){
					if(this.start == false){this.start = true;}

					this.score++;
					this.frameScore = frameCount;
					if((this.x - x) == 0){
						this.velocidadeX += random(-0.2, 0.2);
					}
					else{
						this.velocidadeX += (this.x - x) * 0.5;
					}
					this.forcaPulo = round(random(10, 16));
					this.velocidadeY = -this.forcaPulo;
					this.x += this.velocidadeX;

					somAleatorio = round(random(1, 2));
					if(somAleatorio == 1){
						hit1.setVolume(0.2);
						hit1.play();
					}
					else{
						hit2.setVolume(0.2);
						hit2.play();
					}

					if(this.score != 0){
						if(this.score % 10 == 0 && this.score % 50 != 0){
							every10.setVolume(0.3);
							every10.play();
						}
						else if(this.score % 50 == 0  && this.score % 100 != 0){
							every50.setVolume(0.3);
							every50.play();
						}
						else if(this.score % 100 == 0){
							every100.setVolume(0.3);
							every100.play();
						}
					}

					//if(this.score > meuRecorde && this.score < meuRecorde+2){meuRecordeSom.play();}
					if(this.score > int(recorde) && this.score < int(recorde)+2){recordeOnline.play();}
				}

				this.atualizarPosicao = function(altura){
					if((this.x - this.raio) < 0 && this.velocidadeX < 0){
						this.velocidadeX *= -0.9;
					}
					else if((this.x + this.raio) > largura && this.velocidadeX > 0){
						this.velocidadeX *= -0.9;
					}


					this.velocidadeY += this.gravidade;
					this.x += this.velocidadeX;
					this.y += this.velocidadeY;

					if(this.y > altura+this.diametro){
						gameOver(this.score);
						//menuVisivel = true;
					}
				}
			}

			function Barra(largurab, altura, alturab){
				//Atributos
				this.x = largurab*2;
				this.y = altura*2;
				this.largura = largurab;
				this.altura = alturab;
				this.r = 255;
				this.g = 255;
				this.b = 255;

				this.razao = 15;
				this.n = 1;
				this.restante = (this.razao * this.n)*(-1);
				this.ativado = false;
				//Metodos
				this.desenhar = function(){
					if(frameCount % 5 == 0){
						this.r = round(random(20, 255));
						this.g = round(random(20, 255));
						this.b = round(random(20, 255));
					}
					fill(this.r, this.g, this. b);
					rect(this.x, this.y, this.largura, this.altura);
				}

				this.colidir = function(largura, altura){
					this.desativar(largura, altura);
					return -22;
					}

				this.ativar = function(altura){
					if(this.ativado == false){
						barraAtivarSom.setVolume(0.3);
						barraAtivarSom.play();
					}
					this.ativado = true;
					this.x = 0;
					this.y = altura - this.altura - 15;
					this.n++;
					this.restante = (this.razao * this.n)*(-1);
				}

				this.desativar = function(largura, altura){
					barraDesativarSom.setVolume(0.3);
					barraDesativarSom.play();
					this.ativado = false;
					this.x = largura*10;
					this.y = altura*10;
				}
			}

		</script>

	</body>

</html>