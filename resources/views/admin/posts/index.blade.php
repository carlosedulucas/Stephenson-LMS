
{{-- Chama a template pré pronta --}}
@extends('admin.templates.template')

@section('viewMain')
    @parent
    <!-- Bread crumb -->
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-primary">Postagens</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active">Postagens</li>
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

					<ul class="nav nav-tabs customtab mb-3">
						<li class="nav-item"><a class="nav-link {{($loop == "all") ? "active " : null}}" href="{{URL::route('posts.index')}}">Publicados</a></li>
						<li class="nav-item"><a class="nav-link {{($loop == "trash") ? "active " : null}}" href="{{URL::route('posts.trash')}}">Lixeira</a></li>
					</ul>

				<div class="card-body">
						@if(count($posts) < 1)
							@if($loop == "trash")
								Nenhuma postagem encontrada na lixeira
							@else
								Nenhuma postagem criada. <a href="{{URL::route('posts.create')}}">Criar uma postagem</a>
							@endif
						@else
						<table class="table table-hover">
							<thead>
								<tr>
									<td style="width:40px;"><input type="checkbox" id="check_all" class="filled-in" /><label for="check_all"></label></td>
									<td>
										{{__('messages.title')}}
									</td>
									<td>
										{{__('messages.author')}}
									</td>
									<td>
										{{__('messages.date')}}
									</td>
									<td style="width:100px">
										{{__('messages.actions')}}
									</td>
								</tr>
							</thead>

							<tbody>
								@foreach($posts as $post)
								<tr>
									<td><input type="checkbox" class="filled-in item-checkbox" id="test{{$post->id}}" /><label for="test{{$post->id}}"></label></td>

									<td>
										<a href="{{URL::route('posts.edit', ['post_id' =>  $post['id']])}}">
											{{$post['title']}}
										</a>
									</td>

									<td>
										{{$post->author->firstname . " " . $post->author->lastname}}
									</td>

									<td>
										{{$post->created_at}}
									</td>
									<td>
										@if($loop == "trash")
										<div class="btn-group action-buttons" role="group">
											<div class="action">
												<form method="post" action="{{URL::route('posts.restore', ['id' =>  $post['id']])}}">
													<button type="submit" class="btn btn-primary"><i class="material-icons">restore</i></button>
													<input type="hidden" name="_token" value="{{csrf_token()}}">
												</form>
											</div>

											<div class="action">
												<form method="post" action="{{URL::route('posts.deletefrombd', ['id' =>  $post['id']])}}">
													<button type="submit" class="btn btn-danger"><i class="material-icons">remove</i></button>
													<input type="hidden" name="_token" value="{{csrf_token()}}">
												</form>
											</div>
										</div>
                  @else
										<div class="btn-group action-buttons" role="group">
											<a href="{{URL::to('/posts/'. $post['id'] )}}">
												<button type="button" class="btn btn-primary"><i class="material-icons">visibility</i></button>
											</a>

											<form method="post" action="{{URL::route('posts.destroy', ['id' =>  $post['id']])}}">
												<button type="submit" class="btn btn-danger"><i class="material-icons">remove_circle_outline</i></button>
												<input type="hidden" value="DELETE" name="_method">
												<input type="hidden" name="_token" value="{{csrf_token()}}">
											</form>
										</div>
                  @endif
									</td>
								</tr>
              @endforeach
							</tbody>
						</table>
          @endif
				</div>
			</div>
		</div>
@endsection
