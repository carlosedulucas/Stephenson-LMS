
{{-- Chama a template pré pronta --}}
@extends('admin.templates.template')

@section('viewMain')
    @parent
		<nav aria-label="breadcrumb" id="page-nav">
			<div class="container">
				<ol class="breadcrumb">
					<li class="breadcrumb-item">
						<a href="<?php echo URL::route('users.index');?>">
							<?php echo __('messages.users'); ?>
						</a>
					</li>
					<li class="breadcrumb-item active" aria-current="page">
						<?php echo __('messages.create_user'); ?>
					</li>
				</ol>
			</div>
		</nav>

		<div class="jumbotron jumbotron-fluid">
			<div class="container">
				<h1 class="display-4">
					<?php echo __('messages.create_user'); ?>
				</h1>
			</div>
		</div>


		<div class="container">
			<?php
				if (session('success')){
					if (session('success')['success'] == false){
						echo '<div class="alert alert-danger" role="alert">' . session('success')['messages'] . '</div>';
					} else {
						echo '<div class="alert alert-success" role="alert">' . session('success')['messages'] . '</div>';
					}
				}
			?>


			<form  method="post" action="<?php echo URL::route('users.store');?>">

				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="txtTitle">Nome</label>
						<input type="text" class="form-control" id="txtTitle" placeholder="Nome" name="firstname">
					</div>

					<div class="form-group col-md-6">
						<label for="txtTitle">Sobrenome</label>
						<input type="text" class="form-control" id="txtTitle" placeholder="Sobrenome" name="lastname">
					</div>
				</div>

				<div class="form-group">
						<label for="txtUser">Usuário</label>
						<input id="txtUser" type="text" name="user" class="form-control" placeholder="Usuário">

				</div>

				<div class="form-group">
						<label for="emlEmail">E-mail</label>
						<input id="emlEmail" type="email" name="email" class="form-control" placeholder="E-mail">
				</div>

				<div class="form-group">
						<label for="pasPassword">Senha</label>
						<input id="pasPassword" type="password" name="password" class="form-control" placeholder="Senha">
				</div>

				<button type="submit" class="btn btn-primary btn-lg btn-block mt-4">Adicionar</button>
				<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
			</form>
		</div>
@endsection