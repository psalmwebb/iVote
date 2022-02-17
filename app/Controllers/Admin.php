<?php

namespace App\Controllers;

use App\Models\Admin_model;
use App\Models\Candidate_model;
use App\Models\Election_model;
use App\Models\Voter_model;
use CodeIgniter\API\ResponseTrait;
use Exception;

class Admin extends BaseController
{

    use ResponseTrait;

    public function __construct()
    {
        $this->admin_model = new Admin_model();
        $this->election_model = new Election_model();
        $this->candidate_model = new Candidate_model();
        $this->voter_model = new Voter_model();
    }

    public function login()
    {

       if($this->request->getMethod() === "post"){
          
          $email = $this->request->getVar('email');
          $password = $this->request->getVar('password');
          
          $adminExist = $this->admin_model->where('email',$email)->first();

          if(!$adminExist)
             return view('admin/login',['error'=>'Invalid credentials']);
           
          if(!($password === $adminExist['password']))
             return view('admin/login',['error'=>'Invalid credentials']);

           session()->set('userLoggedIn',['email'=>$email]);

           return redirect()->to(base_url('admin/dashboard'));
       }
       else{
           return view('admin/login');
       }
    }

    public function dashboard(){
        // print_r($this->userLogin);

        $data = [];

        $admin = $this->admin_model->where('email',$this->userLoggedIn['email'])->first();

        $admin['elections'] = $this->election_model->where('adminId',$admin['id'])->findAll();

        $data['admin'] = $admin;
        echo view('admin/dashboard',$data);
    }

    public function candidates(){
        $data = [];

        $admin = $this->admin_model->where('email',$this->userLoggedIn['email'])->first();

        $admin['elections'] = $this->election_model->where('adminId',$admin['id'])->findAll();

        foreach($admin['elections'] as $key=>$election){
           $admin['elections'][$key]['candidates'] = $this->candidate_model->where('electionId',$election['id'])->findAll();
        }
        $data['admin'] = $admin;
        return view('admin/candidates',$data);
    }

    public function voters(){
        $data = [];

        $admin = $this->admin_model->where('email',$this->userLoggedIn['email'])->first();

        $admin['elections'] = $this->election_model->where('adminId',$admin['id'])->findAll();

        foreach($admin['elections'] as $key=>$election){
           $admin['elections'][$key]['voters'] = $this->voter_model->where('electionId',$election['id'])->findAll();
        }
        $data['admin'] = $admin;
        return view('admin/voters',$data);
    }

    public function votes(){
        return view('admin/votes');
    }

    public function ballot(){
        return view('admin/ballot');
    }
   

    public function createElection(){

       $rules = [
           'name'=>'required',
           'adminId'=>'required'
       ];

       if(!$this->validate($rules)){
           return $this->response->setJSON(["error"=>$this->validator->listErrors()]);
       }
       else{
           $this->election_model->insert($this->request->getJSON());

           return $this->response->setJSON(['success'=>'Election created']);
       }
    }

    public function createVoter(){
        $rules = [
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required|valid_email',
            'password'=>'required|min_length[4]',
            'electionId'=>'required'
        ];
 
        if(!$this->validate($rules)){
            return $this->response->setJSON(["error"=>$this->validator->listErrors()]);
        }
        else{
            $this->voter_model->insert($this->request->getJSON());
            return $this->response->setJSON(['success'=>'Voter created']);
        }
    }

    public function createCandidate(){
        $rules = [
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required|valid_email',
            'password'=>'required|min_length[4]',
            'electionId'=>'required'
        ];
 
        if(!$this->validate($rules)){
            return $this->response->setJSON(["error"=>$this->validator->listErrors()]);
        }
        else{
            $this->candidate_model->insert($this->request->getJSON());
 
            return $this->response->setJSON(['success'=>'Candidate created']);
        }
    }
}


?>