<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Constructs the user object from secrets db users table
 *
 * @author Peter
 */
class Users extends MY_Model{
    public function _construct(){
        parent::_construct('users', 'id');
    }
}
