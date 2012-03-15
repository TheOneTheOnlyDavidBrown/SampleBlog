<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Site extends CI_Controller {
    
    public $is_logged_in;
    public $user_role;
    public $is_owner;

    function __construct()
    {
        parent::__construct();
        $this->load->model('blog_model');
    }

    public function index()
    {
        if($this->session->userdata('is_logged_in'))
            redirect(base_url().'feed/all');
        else
            redirect(base_url().'register');
    }
    
    function error($message)//old. renamed to informer
    {
        $this->informer($message);
    }
    
    function informer($message)
    {
        $data = array();
        $data['error'] = $message;
        $data['page']='error_view';
        $this->load->view('includes/template_view',$data);  
    }
    
    public function contact()
    {
        $data = array();
        $data['page']='contact_view';
        $this->load->view('includes/template_view',$data);  
    }
    
    public function validateEmail()
    {
            $this->load->library('form_validation');
            $this->load->model('membership_model');
            
            $this->form_validation->set_rules('name', 'Name', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
            $this->form_validation->set_rules('message', 'Message', 'trim|required');

            if($this->form_validation->run() == true)
            {
                if($this->blog_model->contact())
                    $this->blog_model->contactSubmit(true);
                else
                    $this->blog_model->contactSubmit(false);
            }
            else
                $this->blog_model->contactSubmit(false);
    }

    function register()
    {
        $data = array();
        $data['page']='register_view';
        $this->load->view('includes/template_view',$data);
    }
    
    function subscribe()
    {
        if ($this->uri->segment(2))
            $this->blog_model->subscribe($this->uri->segment(2));
        else
            $this->informer('Could not subscribe');
    }
    
    function unsubscribe()
    {
       if ($this->uri->segment(2))
            $this->blog_model->unsubscribe($this->uri->segment(2));
       else
            $this->informer('Could not unsubscribe');
    }
    
    function subscriptions()
    {   
        $data = array();
        
        $query = $this->blog_model->getSubscriptions();
        if ($query)
            $data['results'] = $query;
        
        $data['page']='subscriptions_view';
        $this->load->view('includes/template_view',$data);
    }
    
    function subscribers()
    {   
        $data = array();
        
        $query = $this->blog_model->getSubscribers();
        if ($query)
            $data['results'] = $query;
        
        $data['page']='subscribers_view';
        $this->load->view('includes/template_view',$data);
    }   
    
    function deletepost()
    {
        if($this->blog_model->deletePost($this->uri->segment(3)))
            redirect(base_url().'feed/'.$this->uri->segment(2));
        else
            $this->informer('Could not delete post');
    }
    
    function deletecomment()
    {
        $uid=$this->uri->segment(2);
        $pid=$this->uri->segment(3);
        $cid=$this->uri->segment(4);
        
        if($uid!=$this->session->userdata('id'))
            redirect(base_url().'article/'.$pid);
        
        if($this->blog_model->deleteComment($cid) == true)
            redirect(base_url().'article/'.$pid);
        else
            $this->informer('Could not delete comment');
    }

    function loginValidation()
    {
        $data = array();
        $this->load->model('membership_model');
        $query = $this->membership_model->validate();
        
        //need to clean this up
	if ($query)
        {
            foreach ($query as $row)
            {
                $data= array(
                    'id'            => $row->id,
                    'firstname'     => $row->firstname,
                    'lastname'      => $row->lastname,
                    'email'         => $row->email,
                    'username'      => $this->input->post('username'),
                    'role'          => $row->role,
                    'is_logged_in'  => true
                );
            }
            $this->session->set_userdata($data);
            $this->index();
        }
        else
            $this->informer('Incorrect username or password. Please try again.');
    }

    function logout()
    {   
        if($this->session->sess_destroy())
            unset($this->is_logged_in);
           
        redirect(base_url().'index');
    }

    function registrationValidation()
    {
        $this->load->library('form_validation');
        $this->load->model('membership_model');

        $this->form_validation->set_rules('firstname', 'First name', 'trim|required');
        $this->form_validation->set_rules('lastname', 'Last name', 'trim|required');
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('password_conf', 'Password Confirmation', 'trim|required|min_length[5]|matches[password]');

        if($this->form_validation->run() == false)
            $this->register();
        else
        {
            if ($this->membership_model->createUser() == true)
                $this->informer('User created successfully. Please log in.');
            else
                $this->informer('Username or email address is already in use. Please try another.');
        }
    }
    
    function article($pid = null)//read article
    {
        $data = array();
        if (!$pid)
            $pid=$this->uri->segment(2);
        
        $query = $this->blog_model->getArticle($pid); //pull post
        
        if ($query)
            $data['results'] = $query;
        
        $query = $this->blog_model->getComments($pid);
        if ($query)
            $data['comments'] = $query;

        $data['page']='article_view';
        $this->load->view('includes/template_view',$data);
    }

    function editpost()
    {
        $data = array();
        $data['uid']=$this->uri->segment(2);
        $data['pid']=$this->uri->segment(3);  
        
        $this->db->where('id',$data['pid']);
        $query = $this->db->get('posts');
        if ($query->num_rows() == 1)    
            $data['results'] = $query->result();
        else
            redirect(base_url().'index');
        
        $data['page']='edit_post_view';
        $this->load->view('includes/template_view',$data);
    }
    
    function editPostValidation()
    {
        $pid = $this->input->post('pid');
        $uid = $this->input->post('uid');
        
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Content', 'trim|required');

        if($this->form_validation->run() == false)
            redirect(base_url().'editpost/'.$uid."/".$pid);
        else
            $this->blog_model->editPost($pid);
    }
    
    function editprofile()
    {
        if(!$this->session->userdata('id'))
            redirect(base_url().'index');

        $data['page']='edit_profile_view';
        $data['uid']=$this->session->userdata('id');
        $data['results'] = $this->blog_model->getUserData();
        $this->load->view('includes/template_view',$data);
    }    
    
    function editProfileValidation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('firstname', 'first name', 'trim|required');
        $this->form_validation->set_rules('lastname', 'last name', 'trim|required');
        $this->form_validation->set_rules('username', 'username', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('email', 'email address', 'trim|required|valid_email');
        $this->form_validation->set_rules('about', 'about me', 'trim');

        if($this->form_validation->run() == false)
            $this->editprofile();
        else
            $this->blog_model->updateProfile();
    }
    
    function searchpeople()
    {
        if ($this->input->post('search'))
            $data['searchString'] = $this->input->post('search');
        $data['results'] = $this->blog_model->searchPeople();
        $data['page'] = 'search_people_view';
        $this->load->view('includes/template_view',$data);
    }
    
    function feed()
    {
        if($this->uri->segment(2) == 'all' && !$this->session->userdata('id'))
            redirect(base_url().'index');
        
        $this->load->library('pagination');
        $data = array();
        
        if(!$this->uri->segment(2))
            $this->informer("This page does not exist");
        
        if($this->uri->segment(2) == 'all')
            $uid='all';
        else
            $uid = $this->uri->segment(2);

        if($this->session->userdata('id') != $uid)
            $data['isSubscribed'] =  $this->blog_model->isSubscribed();
        
        if($this->uri->segment(3))
            $offset =  $this->uri->segment(3);
        else
            $offset =  0;

        $config = array();
        $config = $this->blog_model->setupPagination($uid);

        $this->pagination->initialize($config);
        
        if($this->uri->segment(2) != 'all')//if accessing my feed with my id in the url
        {
            $data['results']=$this->blog_model->feed($uid, $config['per_page'], $offset);
            $data['page']='personal_feed_view';
        }
        else
        {
            $data['results']=$this->blog_model->globalFeed($config['per_page'], $offset);
            $data['page']='subscription_feed_view';
        }

        $this->load->view('includes/template_view',$data);
    }
    
    function settings()
    {
        
    }
    
    function privacy()
    {
        
    }
    
    function addentry()
    {
        $data = array();
        $data['page']='add_entry_view';
        $this->load->view('includes/template_view',$data);
    }
    
    function entryValidation()
    {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('content', 'Post Content', 'trim|required');

        if($this->form_validation->run() == false)
            $this->addEntry();
        else
            $this->blog_model->postEntry();
    }
    
    function commentValidation()
    {
        $this->load->library('form_validation');
        $this->load->model('blog_model');

        $this->form_validation->set_rules('comment', 'Comment', 'trim|required');

        if($this->form_validation->run() == true)
            $this->blog_model->postComment();
        $this->article($this->uri->segment(2));
    }
    
    function recoverpassword()
    {
        
    }
}
