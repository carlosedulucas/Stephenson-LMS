<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Repositories\CourseRepository;
use App\Repositories\CategoriesRepository;
use App\Repositories\ModuleRepository;
use App\Validators\CourseValidator;
use App\Services\CourseService;
use App\Services\UserActivitiesService;
use Auth;

class CoursesController{

  protected $repository;
  protected $validator;
  protected $service;

  public function __construct(CourseRepository $repository, CourseValidator $validator, CourseService $service, CategoriesRepository $categoriesRepository, ModuleRepository $moduleRepository, UserActivitiesService $user_activities_service){
    $this->repository = $repository;
    $this->validator  = $validator;
    $this->service  = $service;
    $this->categoriesRepository  = $categoriesRepository;
    $this->moduleRepository  = $moduleRepository;
    $this->userActivitiesService  = $user_activities_service;
  }

  /* USUÁRIO */

  public function all(){
    $courses = $this->repository->all();
    $title = "Cursos - Stephenson";

    return view('courses.all', [
      'title' => $title,
      'courses' => $courses
    ]);
  }

  public function single($course){
    $course = $this->repository->findByField('id', $course)->first();
    if(count($course) == 0){
      return redirect()->route('error404');
    } else {
      $modules_list = $this->moduleRepository->findByField('course_id',$course['id']);
      $title =  $course['title']." - Stephenson";

      if(Auth::user()){
        $user_joined = $this->repository->user_joined($course->id, Auth::user()->id);
        if($user_joined){
          return view('courses.panel', [
            'page' => "single",
            'title' => $title,
            'course' => $course,
            'modules' => $modules_list,
            'user_joined' => $user_joined
          ]);
        } else{
          return view('courses.single', [
            'title' => $title,
            'course' => $course,
            'modules' => $modules_list,
            'user_joined' => $user_joined
          ]);
        }
      } else{
        return view('courses.single', [
          'title' => $title,
          'course' => $course,
          'modules' => $modules_list
        ]);
      }
    }
  }

  public function panel($course, $page){
    $course = $this->repository->find($course);
    $modules_list = $this->moduleRepository->findByField('course_id',$course['id']);
    $categories = $this->categoriesRepository->getPrimaryCategories();
    $user_joined = $this->repository->user_joined($course->id, Auth::user()->id);

    if($page == "content"){
      return view('courses/panel_content', [
        'title' => $course['title']." | Conteúdo - Stephenson",
        'course' => $course,
        'page' => $page,
        'user_joined' => $user_joined
      ]);
    }

    if($page == "notices"){
      return view('courses.panel_notices', [
        'title' => $course['title']." | Avisos - Stephenson",
        'course' => $course,
        'page' => $page,
        'user_joined' => $user_joined
      ]);
    }

    if($page == "rating"){
      return view('courses.panel_rating', [
        'title' => $course['title']." | Avaliações - Stephenson",
        'course' => $course,
        'page' => $page,
        'user_joined' => $user_joined
      ]);
    }
  }

  public function enterOrFavoriteCourse(Request $request){

    $course_id = $request->query->get('course_id');
    $course_name = $this->repository->find($course_id, ['title']);
    $user = Auth::user()->id;
    $type = $request->query->get('type');
    $data = serialize(['course_name' => $course_name->title, 'course_id' => $course_id]);
    
    if($type == 1){
      $activity = array('user_id' => $user, 'type' => 'favorite_course','data' => $data);
    } elseif($type == 2){
      $activity = array('user_id' => $user, 'type' => 'enter_course','data' => $data);
    }

    $new_activity = $this->userActivitiesService->store($activity);
    return  $this->repository->enter_or_favorite_course($course_id, $user, $type);
  }

  public function leaveCourse(Request $request){
    $user = Auth::user()->id;
    $course = $request->query->get('course_id');
    $activity = array('user_id' => $user, 'type' => 'leave_course');

    $new_activity = $this->userActivitiesService->store($activity);
    return  $this->repository->leave_course($course);
  }

  /* ADMINISTRAÇÃO */

  public function index(){
    $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
    $courses = $this->repository->all();
    $title = "Cursos - Stephenson";

    return view('admin.courses.index',['title' => $title, 'courses' => $courses]);
  }

  public function create(){
    $categories_list = $this->categoriesRepository->selectBoxList();
    $title = "Adicionar Curso - Stephenson";

    return view('admin.courses.create', ['title' => $title, 'categories'=> $categories_list])->render();
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  CourseCreateRequest $request
  *
  * @return \Illuminate\Http\Response
  */
  public function store(CourseCreateRequest $request){
    $request = $this->service->store($request->all());
    $course = $request['success'] ? $request['data'] : null;

    session()->flash('success',[
      'success' =>	$request['success'],
      'messages' =>	$request['messages']
    ]);

    return redirect()->back();
  }

  public function edit($course){
    $categories_list = $this->categoriesRepository->selectBoxList();
    $modules_list = $this->moduleRepository->selectBoxList();
    $course = $this->repository->find($course);
    $atual_category = $this->categoriesRepository->getAtualCategoryInfo($course['category_id']);
    $title = "Editar " . $course['title']." - Stephenson";

    return view('admin.courses.edit', [
      'title' => $title,
      'course' => $course,
      'categories' => $categories_list,
      'atual_category' => $atual_category
    ]);
  }

  public function manage($course){
    $course = $this->repository->find($course);
    $title = "Gerenciar " . $course['title']." - Stephenson";

    return view('admin.courses.manage', [
      'title' => $title,
      'course' => $course
    ]);
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  CourseUpdateRequest $request
  * @param  string            $id
  *
  * @return Response
  */
  public function update(Request $request, $id){
    $request = $this->service->update($request->all(), $id);
    $course = $request['success'] ? $request['data'] : null;

    session()->flash('success',[
      'success' =>	$request['success'],
      'messages' =>	$request['messages']
    ]);

    return redirect()->back();
  }

  /**
  * Remove the specified resource from storage.
  *
  * @param  int $id
  *
  * @return \Illuminate\Http\Response
  */
  public function destroy($id){
    $request = $this->service->delete($id);
    $course = $request['success'] ? $request['data'] : null;

    session()->flash('success',[
      'success' =>	$request['success'],
      'messages' =>	$request['messages']
    ]);

    return redirect()->back();
  }
}
