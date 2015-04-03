<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Auth extends Application{
    function _construct(){
        parent::_construct();
        $this->load->helper('url');
    }
    
    function index(){
        $this->data['pagebody'] = 'login';
        $this->render();
    }
    
    function submit(){
        $key = $_POST['userid'];
        //echo var_dump($key);die();
        //echo var_dump($_POST['password']);die();
        //$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        //echo var_dump($password);die();
        $user = $this->users->get($key);
        if(password_verify($this->input->post('password'), $user->password)){
            $this->session->set_userdata('userID', $key);
            $this->session->set_userdata('userName', $user->name);
            $this->session->set_userdata('userRole', $user->role);
        }
        redirect('/');
    }
    
    function logout(){
        $this->session->sess_destroy();
        redirect('/');
    }
}