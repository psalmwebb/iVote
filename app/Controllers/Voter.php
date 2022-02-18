<?php

 namespace App\Controllers;

use App\Models\Candidate_model;
use App\Models\Voter_model;
 use App\Models\Election_model;
 use App\Models\Vote_model;
use CodeIgniter\API\ResponseTrait;

 class Voter extends BaseController
 {

    use ResponseTrait;

     public function __construct()
     {
         $this->election_model = new Election_model();
         $this->voter_model = new Voter_model();
         $this->candidate_model = new Candidate_model();
         $this->vote_model = new Vote_model();
     }
     
     public function login(){

        if($this->request->getMethod() === "post"){
          
            $email = $this->request->getVar('email');
            $password = $this->request->getVar('password');
            
            $voterExist = $this->voter_model->where('email',$email)->first();
  
            if(!$voterExist)
               return view('voter/login',['error'=>'Invalid credentials']);
             
            if(!($password === $voterExist['password']))
               return view('voter/login',['error'=>'Invalid credentials']);
  
             session()->set('userLoggedIn',['email'=>$email]);
  
             return redirect()->to(base_url('voter/dashboard'));
         }
         else{
             return view('voter/login');
         }
     }

     public function dashboard(){
        
        return view('voter/dashboard');
     }

     public function ballot(){

        $data = [];

        $voter = $this->voter_model->where('email',$this->userLoggedIn['email'])->first();

        $voter['election'] = $this->election_model->where('id',$voter['electionId'])->first();

        $voter['voted'] = $this->vote_model->where("voterId",$voter['id'])->first() ? true : false;
        
        $voter['election']['candidates'] = $this->candidate_model->where('electionId',$voter['election']['id'])->findAll();

        $data['voter'] = $voter;
        
        return view('voter/ballot',$data);
     }

     public function logout(){
       
        session()->remove('userLoggedIn');

        session()->destroy();

        return redirect()->to(base_url('voter/login'));
     }

     public function vote(){

        $rules = [
            'voterId'=>'required',
            'electionId'=>'required',
            'candidateId'=>'required'
        ];

        if($this->validate($rules)){
            $payload = $this->request->getJSON();

            $this->vote_model->save($payload);

            return $this->response->setJSON(['success'=>'Voted successfully']);
        }
        else{
            return $this->response->setJSON(['error'=>$this->validator->listErrors()]);
        }
     }
 }