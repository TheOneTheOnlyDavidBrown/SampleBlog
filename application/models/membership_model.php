<?php

class Membership_model extends CI_Model
{
    private $_salt = "53ou4k8o8a4i5;12aou###oaeu11111";//don't modifiy!!!!!!!!!
    
    function validate()
    {
        $password = $this->input->post('password')."".$this->_salt;
        $this->db->where('username',$this->input->post('username'));
        $this->db->where('password',openssl_digest($password, 'sha512'));
        $query = $this->db->get('users');
        
        if($query->num_rows == 1)
        {
            return $query->result();
        }
    }
    
    function createUser()
    {
        $password=$this->input->post('password')."".$this->_salt;
            $userdata = array(
                'firstname' => $this->input->post('firstname'),
                'lastname'  => $this->input->post('lastname'),
                'email'     => $this->input->post('email'),
                'username'  => $this->input->post('username'),
                'password'  => openssl_digest($password, 'sha512')
            );
        
        //checks if there is already that username or password in the database
        $this->db->select('email');
        $this->db->select('username');
        $this->db->where('email', $userdata['email']);
        $this->db->or_where('username', $userdata['username']);
        
        $query = $this->db->get('users');
        
        if($query->num_rows>0)//member exists
        {
            //send to error page
            return false;
        }
        else//member does not exist...
        {
            ////sets up db query
            $this->db->set('firstname',$userdata['firstname']);
            $this->db->set('lastname',$userdata['lastname']);
            $this->db->set('email',$userdata['email']);
            $this->db->set('username',$userdata['username']);
            $this->db->set('password',$userdata['password']);
            $this->db->insert('users');
            //redirect(base_url()."index");
            return true;
        }
    }
    
    function passwordChange()
    {
        //needs to be written
    }
}