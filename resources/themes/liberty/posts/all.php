<?php echo view('header', ['title' => $title]); ?>
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <h1 class="display-4">Postagens</h1>
  </div>
</div>
		<div class="container">
			<?php if(count($posts) > 0) { ?>
			<div class="row">
				<?php foreach($posts as $post) { ?>
					<div class="col-3">
						<div class="card">
								<?php if($post['thumbnail'] == NULL){?>
									<img class="card-img-top" src="<?php echo theme_url("images/thumbnail-default.jpg"); ?>" alt="<?php echo $post['title']; ?>">
								<?php } else {?>
									<img class="card-img-top" src="<?php echo theme_url($post['thumbnail']); ?>" alt="<?php echo $post['title']; ?>">
								<?php }?>
							<div class="card-body">
								<h5 class="card-title"><?php echo $post['title']; ?></h5>
								<p class="card-text"><?php echo $post['resume'] ?></p>
								<a href="<?php echo URL::route('posts.single', ['post' => $post->id]);?>" class="btn btn-primary">Ver</a>
							</div>
						</div>
					</div>  
				<?php } ?>
			</div>
			<?php } else { ?>
				<p>Nenhuma postagem cadastrada.</p>
			<?php }  ?>
		</div>

<?php echo view('footer'); ?>