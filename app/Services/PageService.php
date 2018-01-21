<?php

namespace App\Services;
use Illuminate\Database\QueryException;
use Exception;
use Prettus\Validator\Contracts\ValidatorInterface;	
use Prettus\Validator\Contracts\ValidatorException;	
use App\Repositories\PageRepository;
use App\Validators\PageValidator;
use Illuminate\Support\Facades\Input;

class PageService{
	private $respository;
	private $validator;
	
	public function __construct(PageRepository $repository, PageValidator $validator){
		$this->repository = $repository;
		$this->validator = $validator;
	}
	
	public function store(array $data){
		try{
			$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
			$page = $this->repository->create($data);
			
			return [
				'success'   => true,
				'messages'  => "Página criada com sucesso!",
				'data'     => $page
			];
		} catch(Exception $e){
			return [
				'success' => false,
				'messages' => $e->getMessage(),
			];
		}
	}
	
	public function update(){}
	public function delete(){}
}