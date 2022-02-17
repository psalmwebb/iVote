<?php

namespace App\Controllers;

use App\Models\Admin_model;
use Exception;

class Register extends BaseController
{
    private Admin_model $admin_model;

    public function __construct(){
       
        $this->admin_model = new Admin_model();
    }
    public function index(){

        $data = [];
        if($this->request->getMethod() === "post"){
            $rules = [
                "firstname" =>"required",
                "lastname" =>"required",
                "email" => "valid_email|required",
                "password"=>"required|min_length[6]",
                "confpassword"=>'required|matches[password]'
            ];

            if($this->validate($rules)){

                $emailExist = $this->admin_model->where('email',$this->request->getVar('email'))->first();

                if($emailExist)
                   return view('register',['error'=> 'Email address already exist']);

                $this->admin_model->insert([...$this->request->getVar()]);

                return redirect()->to(base_url('admin/login'));
            }
            else{
               $data['validator'] = $this->validator;

               return view('register',$data);
            }
        }
        else{
            return view('register',$data);
        }
    }
}


?>