<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TutorialRepository;
use App\Entities\Tutorial;
use App\Validators\TutorialValidator;

/**
 * Class TutorialRepositoryEloquent
 * @package namespace App\Repositories;
 */
class TutorialRepositoryEloquent extends BaseRepository implements TutorialRepository
{
	
	public function getTrashed(){
		return $this->model->onlyTrashed()->get();
	}
	
	public function restore($id){
		$this->model->withTrashed()->find($id)->restore();
	}
	
	public function deleteFromBD($id){
		$this->model->withTrashed()->find($id)->forceDelete();
	}
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tutorial::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return TutorialValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
