<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CourseCreateRequest;
use App\Http\Requests\CourseUpdateRequest;
use App\Repositories\CourseRepository;
use App\Repositories\CategoriesRepository;
use App\Repositories\ModuleRepository;
use App\Validators\CourseValidator;
use App\Services\CourseService;


class CoursesController extends Controller
{

    /**
     * @var CourseRepository
     */
    protected $repository;
    protected $validator;
    protected $service;

    public function __construct(CourseRepository $repository, CourseValidator $validator, CourseService $service, CategoriesRepository $categoriesRepository, ModuleRepository $moduleRepository)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
        $this->service  = $service;
        $this->categoriesRepository  = $categoriesRepository;
        $this->moduleRepository  = $moduleRepository;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function index(){
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $courses = $this->repository->all();

	
		$title = "Cursos - Escola LTG";
		echo view('admin.header', ['title' => $title]);
		echo view('admin.courses.index',['courses' => $courses]);
		echo view('admin.footer');
    }
	
	public function create(){
		$categories_list = $this->categoriesRepository->selectBoxList();
		
		$title = "Adicionar Curso - Escola LTG";
		echo view('admin.header', ['title' => $title]);
		echo view('admin.courses.create', ['categories'=> $categories_list])->render();
		echo view('admin.footer')->render();
	}

    public function archive(){
      $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
      $courses = $this->repository->all();
		$categories = $this->categoriesRepository->getPrimaryCategories();

		$title = "Cursos - Escola LTG";
		echo view('header', ['title' => $title, 'categories' => $categories]);
		echo view('courses/courses', ['courses' => $courses]);
		echo view('footer');
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


    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $course,
            ]);
        }

        return view('courses.show', compact('course'));
    }

	public function edit($course){
		$categories_list = $this->categoriesRepository->selectBoxList();
		$modules_list = $this->moduleRepository->selectBoxList();
		$course = $this->repository->find($course);
		$atual_category = $this->categoriesRepository->getAtualCategoryInfo($course['category_id']);
		
		$title = "Editar " . $course['title']." - Escola LTG";
		echo view('admin.header', ['title' => $title]);
		echo view('admin.courses.edit', ['course' => $course, 'categories' => $categories_list, 'atual_category' => $atual_category])->render();
		echo view('admin.footer')->render();
	}
	
	public function manage($course){
		$course = $this->repository->find($course);
		$title = "Gerenciar " . $course['title']." - Escola LTG";
		
		echo view('admin.header', ['title' => $title]);
		echo view('admin.courses.manage', ['course' => $course])->render();
		echo view('admin.footer')->render();
	}
	
	public function single($course){
		$course = $this->repository->find($course);
		$modules_list = $this->moduleRepository->findByField('course_id',$course['id']);
		$categories = $this->categoriesRepository->getPrimaryCategories();
		$title =  $course['title']." - Escola LTG";
		
		echo view('header', ['title' => $title, 'categories' => $categories]);
		echo view('courses/course', ['course' => $course, 'modules' => $modules_list])->render();
		echo view('footer')->render();
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  CourseUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     */
    public function update(CourseUpdateRequest $request, $id)
    {

        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $course = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Course updated.',
                'data'    => $course->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Course deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Course deleted.');
    }
}
