<div id="course-header">
	<div class="container">
		<h2>Gerenciar <?php echo $course['title'];?></h2>	
		      <ul class="tabs">
        <li class="tab col s3"><a href="<?php echo URL::route('courses.edit', ["course" => $course->id]) ?>" target="_self" class="active">Editar</a></li>
        <li class="tab col s3"><a href="<?php echo URL::route('courses.manage', ["course" => $course->id]) ?>" target="_self">Gerenciar</a></li>
        <li class="tab col s3"><a href="<?php echo URL::route('courses.statistics', ["course" => $course->id]) ?>" target="_self">Estatísticas</a></li>
      </ul>
	</div>
</div>
<div class="section">
<div class="container">
	<div class="row">
		<form method="post" action="<?php echo URL::route('courses.update', ['course_id' =>  $course['id']]);?>" enctype="multipart/form-data">
			<div class="col s9">
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
				
				<div class="col s12 input-field">
					<input type="text" name="title" id="course-title" value="<?php echo $course['title']?>">
					<label for="tutorial-title">Titulo</label>
				</div>

				<div class="col s12 input-field">
					<textarea name="description" id="course-description" class="tinymce">
					<?php echo $course['description']?>
					</textarea>
				</div>

				<div class="col s12 input-field" style="margin-top:40px;">
					<textarea name="resume" id="course-resume" class="materialize-textarea" >
					<?php echo $course['resume']?>
					</textarea>
					<label for="course-resume"><?php echo __('messages.resume'); ?></label>
				</div>

				<input type="hidden" name="author_id" value="<?php echo Auth::user()->id;?>">
			</div>
			</div>

			<div class="col s3">
				<div class="row">
					<div class="col s12">
						<button type="submit" class="btn-large full-btn cyan darken-2"><?php echo __('messages.edit'); ?></button>
					</div>
				</div>
				
				<div class="row">
					<div class="col s12">
						<div class="widget card">
							<h3 class="widget-title"><?php echo __('messages.tags'); ?></h3>

							<div class="widget-content">
								<div class="chips chips-placeholder"></div>
							</div>
						</div>
					</div>
				</div>
					
				<div class="row">
					<div class="col s12">
						<div class="widget card">
							<h3 class="widget-title"><?php echo __('messages.category'); ?></h3>

							<div class="widget-content">
								<select name="category_id">
									<option value="<?php if($atual_category == NULL){echo "0";} else{echo $atual_category['id'];}?>" disabled selected><?php if($atual_category == NULL){echo "Sem Categoria";} else{echo $atual_category['name'];}?></option>

									<?php foreach ($categories as $category) { ?>
									<option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
				</div>
					
				<div class="row">
					<div class="col s12">
						<div class="widget card">
							<h3 class="widget-title"><?php echo __('messages.thumbnail'); ?></h3>

							<div class="widget-content">
								<div class="file-upload">
									<a id="lfm" data-input="thumbnail" data-preview="holder" class="btn"><i class="material-icons">file_upload</i></a>
									<input id="thumbnail" type="text" name="cover" value="<?php echo $course['cover']?>">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>	

			<input type="hidden" value="PUT" name="_method">
			<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
		</form>
	</div>
</div>
</div>