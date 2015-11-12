#!/usr/bin/php -q
<?php
	/* Cliente */
	error_reporting(E_ALL);
	
	echo "Conexao TCP/IP em PHP\n";

	/* Defina a porta */
	$porta = 12004;

	/* Define o host */
	$host = gethostbyname("localhost");

	/* Crie um socket */
	$funcao = array("LER","ESCREVER");

	for ($n = 0; $n < 2; $n++)
	{
		$socket_cliente = socket_create(AF_INET,SOCK_STREAM,0);
		print "$socket_cliente\n";

		if ($socket_cliente < 0)
		{
			print "Nao foi possivel obter socket para conexao com $host\n";
			exit;
		}

		/* De um connect na porta */
		$connect = socket_connect($socket_cliente,$host,$porta);

		if ($connect < 0)
		{	
			print "Nao foi possivel conectar no $host:$porta\n";
			exit;
		} 

		print "Conexao $n $host:$porta Funcao : $funcao[$n]\n";
		socket_write($socket_cliente,$funcao[$n],strlen($funcao[$n]));

		switch($n)
		{
			case 0 :
				$msg = socket_read($socket_cliente,100);
				
				if ($msg)
				{
					print "Mensagem recebida: $msg\n";
				}
			break;
			
			case 1 :
				$msg = "Minha mensagem";
				
				socket_write($socket_cliente,$msg,strlen($msg));
				print "Mensagem enviada\n";
			break;
		}
		
		socket_close($socket_cliente);
		print "Conexao fechada\n";

	}

	print "Cliente finalizou normal";
?>