<?php

namespace App\Services;
use Illuminate\Database\QueryException;
use Exception;
use Prettus\Validator\Contracts\ValidatorInterface;	
use Prettus\Validator\Contracts\ValidatorException;	
use App\Repositories\TutorialRepository;
use App\Validators\TutorialValidator;
use Illuminate\Support\Facades\Input;

class TutorialService{
	private $respository;
	private $validator;
	
	public function __construct(TutorialRepository $repository, TutorialValidator $validator){
		$this->repository = $repository;
		$this->validator = $validator;
	}
	
	public function store(array $data){
		try{
			$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
			$tutorial = $this->repository->create($data);
			
			return [
				'success'   => true,
				'messages'  => "Tutorial criado com sucesso!",
				'data'     => $tutorial
			];
		} catch(Exception $e){
			return [
				'success' => false,
				'messages' => $e->getMessage(),
			];
		}
	}
	
	public function update($data, $tutorial_id){
		try{
			$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
			$tutorial = $this->repository->update($data, $tutorial_id);
			
			return [
				'success'   => true,
				'messages'  => "Tutorial editado com sucesso!",
				'data'     => $tutorial
			];
		} catch(Exception $e){
			return [
				'success' => false,
				'messages' => $e->getMessage(),
			];
		}
		
	}
	
	public function delete($tutorial_id){
		try{

			$tutorial = $this->repository->delete($tutorial_id);
			
			return [
				'success'   => true,
				'messages'  => "Tutorial movido para lixeira com sucesso!",
				'data'     => $tutorial
			];
		} catch(Exception $e){
			return [
				'success' => false,
				'messages' => $e->getMessage(),
			];
		}
	}
	
		
	public function restore($tutorial_id){
		try{

			$tutorial = $this->repository->restore($tutorial_id);
			
			return [
				'success'   => true,
				'messages'  => "Tutorial restaurado com sucesso!",
				'data'     => $tutorial
			];
		} catch(Exception $e){
			return [
				'success' => false,
				'messages' => $e->getMessage(),
			];
		}
	}
	
	public function deleteFromBD($tutorial_id){
		try{

			$tutorial = $this->repository->deleteFromBD($tutorial_id);
			
			return [
				'success'   => true,
				'messages'  => "Tutorial excluído com sucesso!",
				'data'     => $tutorial
			];
		} catch(Exception $e){
			return [
				'success' => false,
				'messages' => $e->getMessage(),
			];
		}
	}
}