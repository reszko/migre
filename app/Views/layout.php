<!DOCTYPE html>
<html lang="pt-BR">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>mig.re - encurtador de URL simpático</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}

		body {
			padding-top: 5rem;
		}

		.navbar {
			background-color: #3e6a88;
		}
	</style>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-Z3MLB074YQ"></script>
	<script>
		window.dataLayer = window.dataLayer || [];

		function gtag() {
			dataLayer.push(arguments);
		}
		gtag('js', new Date());

		gtag('config', 'G-Z3MLB074YQ');
	</script>
</head>

<body>
	<nav class="navbar navbar-dark navbar-expand-md fixed-top">
		<a class="navbar-brand" href="<?php echo base_url() ?>"><img src="<?php echo base_url('assets/imagens/logo-top.png') ?>" alt="Logotipo mig.re" style="max-height: 30px;"></a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarsExampleDefault">
			<ul class="navbar-nav mr-auto">
				<?php if (session()->isLoggedIn) : ?>
					<li class="nav-item  nav-link">Seja bem-vindo <?php echo session()->email ?></li>
					<li class="nav-item"><?php echo anchor(base_url('user/changepass'), 'Mudar Senha', ['class' => 'nav-link']) ?></li>
				<?php endif; ?>
			</ul>
			<div class="form-inline my-2 my-lg-0">
				<ul class="navbar-nav mr-auto">
					<?php if (session()->isLoggedIn) : ?>
						<li class="nav-item"><?php echo anchor('user', 'Meus Links', ['class' => 'nav-link']) ?></li>
						<li class="nav-item"><?php echo anchor(base_url('login/signout'), 'Sair', ['class' => 'nav-link']) ?></li>
					<?php else : ?>
						<li class="nav-item"><?php echo anchor(base_url('login'), 'Entrar', ['class' => 'nav-link']) ?></li>
					<?php endif; ?>
					<li class="nav-item"><a href="javascript:;" class="nav-link" data-toggle="modal" data-target="#modalSobre">Sobre</a></li>
				</ul>
			</div>
		</div>
	</nav>
	<div class="container">
		<?php $message = session()->getFlashdata('message'); ?>
		<?php if (is_array($message) && count($message) > 0) : ?>
			<div class="alert alert-<?php echo $message['tipo'] ?>">
				<?php echo $message['message']; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php echo $this->renderSection('content') ?>



	<div class="modal fade" id="modalSobre" tabindex="-1" aria-labelledby="modalSobreLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalSobreLabel">Sobre o mig.re</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<h4>Encurtador de URL feito em CodeIgniter 4</h4>
					<p>Veja no vídeo abaixo como baixar o código fonte:</p>
					<p><a href="https://mig.re/Ev" target="_blank">Vídeo sobre o migre.me</a></p>
					<p>Envie sua dúvida ou sugestão para: <?php echo safe_mailto('fabio@mig.re') ?></p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
				</div>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
</body>

</html>