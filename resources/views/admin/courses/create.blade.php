{{-- Chama a template pré pronta --}}
@extends('admin.templates.template')

@section('viewMain')
    @parent
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Criar Curso</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{URL::route('courses.index')}}">Cursos</a></li>
                <li class="breadcrumb-item active">Editar Curso</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->

		<div class="container-fluid">
			<?php
				if (session('success')){
					if (session('success')['success'] == false){
						echo '<div class="alert alert-danger" role="alert">' . session('success')['messages'] . '</div>';
					} else {
						echo '<div class="alert alert-success" role="alert">' . session('success')['messages'] . '</div>';
					}
				}
			?>

			<div class="row">
				<form  class="col-12" method="post" action="{{ URL::route('courses.store')}}" enctype="multipart/form-data">
					<div class="row">
					<div class="col-9">
							<div class="form-group">
								<label for="txtTitle">Título</label>
								<input type="text" class="form-control" id="txtTitle" placeholder="Título" name="title">
							</div>

							<div class="form-group">
								<textarea type="text" class="form-control tinymce" rows="8" id="txtContent" placeholder="Conteúdo" name="description"></textarea>
							</div>

							<div class="form-group">
								<label for="txtTitle">Resumo</label>
								<textarea type="text" class="form-control" id="txtTitle" placeholder="Resumo" name="resume"></textarea>
							</div>


						<input type="hidden" name="author_id" value="{{ Auth::user()->id }}">
					</div>

						<div class="col-3">

							<button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Adicionar</button>

							<div class="card mt-3">
							  <h5 class="card-header">Categoria</h5>
							  <div class="card-body">
									<select name="category_id">
										<option value="0" disabled selected>Sem categoria</option>
										@foreach ($categories as $category)
										<option value="{{ $category['id']}}">{{ $category['name']}}</option>
                    @endforeach
									</select>
							  </div>
							</div>

							<div class="card mt-3">
							  <h5 class="card-header">Capa</h5>
							  <div class="card-body">
									<div class="file-upload">
										<a id="lfm" data-input="thumbnail" data-preview="holder" class="btn"><i class="material-icons">file_upload</i></a>
										<input id="thumbnail" type="text" name="cover">
									</div>
							  </div>
							</div>
						</div>
					</div>

					<input type="hidden" name="_token" value="{{ csrf_token()}}">
				</form>
			</div>
		</div>
@endsection
