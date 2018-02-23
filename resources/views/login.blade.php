<?php echo view('header', ['title' => "Login - Stephenson"]); ?>

<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Entrar</h1>
  </div>
</div>

<div class="container">
	<?php 
		if (session('login_message')){
			if (session('success')['login_message'] == false){
				echo '<div class="alert alert-danger" role="alert">' . session('login_message')['messages'] . '</div>';
			}
		}
	?>
<form method="post" action="<?php echo URL::route('login');?>">
  <div class="form-group">
    <label for="input-email">E-mail</label>
    <input name="login_email" type="email" class="form-control" id="input-email" placeholder="E-mail">
  </div>
  <div class="form-group">
    <label for="input-password">Senha</label>
    <input name="login_senha" type="password" class="form-control" id="input-password" placeholder="Senha">
  </div>
  <div class="form-check">
    <input name="login_rememberme" type="checkbox" class="form-check-input" id="input-rememberme">
    <label class="form-check-label" for="input-rememberme">Matenha-me Conectado</label>
  </div>
  <button type="submit" class="btn btn-primary">Entrar</button>
	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
</form>
</div>

<?php echo view('footer'); ?>