<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['title'] = "Top Secret Government Site";    // our default title
        $this->errors = array();
        $this->data['pageTitle'] = 'welcome';   // our default page
    }

    /**
     * Render this page
     */
    function render() {
        //$this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'),true);
        $this->data['menubar'] = $this->makemenu();
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        
        // session id
        $this->data['sessionid'] = session_id();
        
        $this->parser->parse('_template', $this->data);
    }
    
    /*
     * access control
     */
    function restrict($roleNeeded = null){
        $userRole = $this->session->userdata('userRole');
        if($roleNeeded != null){
           if(is_array($roleNeeded)){
               if(!in_array($userRole, $roleNeeded)){
                   redirect("/");
                   return;
               }
           }else if($userRole != $roleNeeded){
               redirect("/");
               return;
           }
        }
    }
    
    /*
     * generates the menu bar depending on user authority
     */
    
    function makemenu(){
        $userRole = $this->session->userdata('userRole');
        $userName = $this->session->userdata('userName');
        $menu = array();
        $alpha = array('name' => "Alpha", 'link' => '/alpha');
        $beta = array('name' => "Beta", 'link' => '/beta');
        $logout = array('name' => "Logout", 'link' => '/auth/logout');
        $login = array('name' => "Login", 'link' => '/auth');
        $gamma = array('name' => "Gamma", 'link' => '/gamma');
        $menu['menubar'] = $alpha;

        // if not logged in
        if($userRole === null){
            $menu[] = $login;
        }
        // if logged in as user
        if($userRole === ROLE_USER){
            $menu[] = $beta;
            $menu[] = $logout;
        }
        // if logged in as admin
        if($userRole === ROLE_ADMIN){
            $menu[] = $beta;
            $menu[] = $gamma;
            $menu[] = $logout;
        }

        return $menu;

    }

}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */