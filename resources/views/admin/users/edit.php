<div class="container">
	
	<nav class="z-depth-0 transparent breadcrumbs">
		<div class="nav-wrapper">
			<div class="col s12">
				<a href="<?php echo URL::route('users.index') ?>" class="breadcrumb">Usuários</a>
				<a href="#" class="breadcrumb">Editar Usuário</a>
			</div>
		</div>
	</nav>
	
	<h2>Editar <?php echo $user['firstname'] . " " . $user['lastname'];?></h2>

	<div class="row">
		<div class="col s12">
			<?php 
				if (session('success')){
					if (session('success')['success'] == true){
						echo "<div class='success-message'>" . session('success')['messages'] . "</div>";
					} else{
						echo "<div class='error-message'>" . session('success')['messages'] . "</div>";
					}
				}
			?>
		</div>
	</div>
	<form  method="post" action="<?php echo URL::route('users.update', ['user_id' => $user['id']]);?>">
		
		<div class="row">
			<div class="col s6 input-field">
				<input id="txtFirstName" type="text" name="firstname" value="<?php echo $user['firstname'] ?>">
				<label for="txtFirstName">Nome</label>
			</div>

			<div class="col s6 input-field">
				<input id="txtLastName" type="text" name="lastname" value="<?php echo $user['lastname'] ?>">
				<label for="txtLastName">Sobrenome</label>
			</div>
		</div>

		<div class="row">
			<div class="col s12 input-field">
				<input id="txtUser" type="text" name="user" value="<?php echo $user['user'] ?>">
				<label for="txtUser">Usuário</label>
			</div>
		</div>

		<div class="row">
			<div class="col s12 input-field">
				<input id="emlEmail" type="email" name="email" value="<?php echo $user['email'] ?>">
				<label for="emlEmail">E-mail</label>
			</div>
		</div>

		<div class="row">
			<div class="col s12 input-field">
				<input id="pasPassword" type="password" name="password" value="<?php echo $user['password'] ?>">
				<label for="pasPassword">Senha</label>
			</div>
		</div>
		<div class="row">
			<div class="col s12">
				<button type="submit" class="btn">EDITAR</button>
			</div>
		</div>
		<input type="hidden" value="PUT" name="_method">
		<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	</form>
</div>