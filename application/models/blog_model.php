<?php

class Blog_model extends CI_Model{
    public $commentCount = 0;

    function __construct()
    {
        parent::__construct();
    }
    
    function getRole()
    {
        return $this->session->userdata('role');
    }
    
    function getArticle($pid)
    {
        $data = array();

        $this->db->where('id', $pid);
        $query = $this->db->get('posts');

        if($query->num_rows() == 1)
        {
            foreach ($query->result() as $row)
                $data[] = $row;
            return $data;
        }
    }
    
    function getComments($pid)
    {
        $data = array();
        $this->db->select('*');
        $this->db->where('post_id', $pid);
        $this->db->order_by('id', 'desc');
        $query = $this->db->get('comments');

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
                $data[] = $row;
            return $data;
        }
    }
    
    function getCommentCount($pid)
    {
        $this->db->where('post_id', $pid);
        $this->db->from('comments');
        return $this->db->count_all_results();	
    }
    
    function getUserData()
    {
        $this->db->where('id', $this->session->userdata('id'));
        $query = $this->db->get('users');

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
                $data[] = $row;
            return $data;
        }
    }
    
    function contactSubmit($valid = false)
    {
        if ($valid)
            $data['page']='contact_submitted_view';
        else
            $data['page']='contact_view';
        $this->load->view('includes/template_view',$data);  
    }
    
    function feed($uid, $limit, $offset)
    {
        $data = array();

        $query = $this->db->query("SELECT id,user_id,title,date,published, left(`content`, 300) as preview FROM posts WHERE user_id = ".$uid." ORDER BY date DESC LIMIT $offset, $limit");
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
               $data[] = $row;
            return $data;
        }
        else
            return false;
    }
    
    function globalFeed($limit, $offset)
    {
        $data = array();
        
        $querystring = "SELECT id,user_id,title,date,left(`content`, 300) as preview FROM posts WHERE published = 1 AND ";
        
        //loop through subscribership
        $query = $this->db->select("*");
        $query = $this->db->where("subscriber_id", $this->session->userdata('id'));
        $query = $this->db->get('subscribership');
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
               $querystring .= "user_id = ".$row->owner_id." OR ";
        }
        $querystring .= " published = 1 AND user_id = ".$this->session->userdata('id')." ORDER BY date DESC LIMIT $offset, $limit";

        $query = $this->db->query($querystring);
        
        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
               $data[] = $row;
            return $data;
        }
        else
            return false;
    }
    
    function setupPagination($uid)
    {
        $config['base_url'] = base_url().'feed/'.$uid;
        
        if ($uid != 'all')
        {
            $this->db->where('posts.user_id', $uid);
            $this->db->where('posts.published', 1);
            $this->db->from('posts');
            $config['total_rows']       = $this->db->count_all_results();
        }
        else
        {
            $uid=  $this->session->userdata('id');
            $query = $this->db->query("SELECT * FROM `posts` WHERE user_id in (SELECT owner_id  FROM `subscribership` WHERE subscriber_id =$uid OR owner_id = $uid)");
            $config['total_rows'] = $query->num_rows();
        }
        $config['per_page']         = 10;
        $config['num_links']        = 10;
        $config['full_tag_open']    = '<div id="pagination">';
        $config['full_tag_close']   = '</div>';
        $config['uri_segment']      = 3;
        return $config;
    }
    
    function contact()
    {
        $this->load->library('email');
        $this->email->set_newline("\r\n");

        $this->email->from($this->input->post('email'), $this->input->post('name'));
        $this->email->to('david@davidbrownucf.com');		
        $this->email->subject('Message from blog');		
        $this->email->message($this->input->post('message'));

        return $this->email->send();
    }
           
    function postEntry()
    {
        if($this->input->post('published')==0)
            $published = 0;
        else
            $published = 1;
        $post = array(
                'user_id'   => $this->session->userdata('id'),
                'title'     => $this->input->post('title'),
                'content'   => $this->input->post('content'),
                'date'      => time(),
                'content'   => nl2br(htmlspecialchars($this->input->post('content'))),
                'published' => $published
            );
        $this->db->insert('posts', $post);
        
        redirect(base_url().'index');
    }
    
    function postComment()
    {
        $comment = array(
                'user_id'   => $this->session->userdata('id'),
                'post_id'   => $this->input->post('pid'),
                'date'      => time(),
                'content'   => nl2br(htmlspecialchars($this->input->post('comment')))
            );
        $this->db->insert('comments', $comment);
    }
    
    //input id return username
    function userFromID($id, $field)
    {
        $this->db->select($field);
        $this->db->where('id',$id);
        $query = $this->db->get('users');
        
        foreach ($query->result() as $row)
        {
            if ($field=="username")
                return $row->username;
            if ($field=="firstname")
                return $row->firstname;
            if ($field=="lastname")
                return $row->lastname;
            if ($field=="about")
                return $row->about;
        }
    }
    
    function getSubscriptions()
    {
        if (!$this->session->userdata('id'))
            redirect(base_url()."index");
        $data = array();
        $this->db->select('*');
        $query = $this->db->where("subscriber_id",$this->session->userdata('id'));
        $query = $this->db->get("subscribership");

        if($query->num_rows() > 0)
        {
            foreach ($query->result() as $row)
                $data[] = $row;
            return $data;
        }
    }
    
    function getSubscribers()
    {
        if (!$this->session->userdata('id'))
            redirect(base_url()."index");
        $data = array();
        $this->db->select('*');
        $query = $this->db->where("owner_id",$this->session->userdata('id'));
        $query = $this->db->get("subscribership");

        if($query->num_rows() > 0)
        {
            
            foreach ($query->result() as $row)
                $data[] = $row;
            return $data;
        }
    }
    
    function isSubscribed()
    {
        $this->db->select('*');
        $this->db->where('subscriber_id',  $this->session->userdata('id'));
        $this->db->where('owner_id',  $this->uri->segment(2));
        $query = $this->db->get('subscribership');

        if($query->num_rows() == 1)
            return true;
    }
   
    function getCount($subscription)
    {
        if ($subscription=='subscriptions')
            $this->db->where('subscriber_id', $this->session->userdata('id'));
        else if ($subscription=='subscribers')
            $this->db->where('owner_id', $this->session->userdata('id'));
        $this->db->from('subscribership');
        return $this->db->count_all_results();	
    }
    
    function subscribe($uid)
    {
        $data = array(
            'owner_id' => $uid,
            'subscriber_id' => $this->session->userdata('id')
        );
        
        $this->db->insert("subscribership",$data);
        redirect(base_url().'feed/'.$uid);
    }
        
    function unsubscribe($uid)
    {
        $this->db->where("subscriber_id",  $this->session->userdata('id'));
        $this->db->where("owner_id",  $uid);
        $this->db->delete("subscribership");
        redirect(base_url().'feed/'.$uid);
    }
    
    function editPost($pid)
    {
        if($this->input->post('published')==0)
            $published = 0;
        else
            $published = 1;
        echo $this->input->post('published');
        $data = array(
               'title' => $this->input->post('title'),
               'content' => nl2br(htmlspecialchars($this->input->post('content'))),
               'published' => $published
            );
        
        $this->db->where('id',  $pid);
        $this->db->update('posts',$data);
        redirect(base_url().'article/'.$pid);
    }
    
    function deletePost($pid)
    {
        $this->db->where('id',$pid);
        $this->db->where('user_id',  $this->session->userdata('id'));
        if($this->db->delete('posts'))
            return true;
        else
            return false;
    }
    
    function deleteComment($cid)
    {
        $this->db->where("id", $cid);
        $this->db->where("user_id",  $this->session->userdata('id'));
        if ($this->db->delete("comments"))
            return true;
        else
            return false;
    }
    
    function searchPeople()
    {
        $data = array();
        $searchString = $this->input->post('search');
        
        if (!isset($searchString) || $searchString === null)
            return 0;
        
        $searchLen=strlen($searchString);
        $tempWithWildCards = array();
        $searchString = str_split($searchString);
        
        if ($searchLen>0)
        {
            for($i=0;$i<$searchLen;$i++)
            {
                array_push($tempWithWildCards, "%");
                array_push($tempWithWildCards, $searchString[$i]);
            }
            array_push($tempWithWildCards, "%");
            
            $searchString = implode($tempWithWildCards);
            
            $searchString = explode(" ", $searchString);
            
            $dup=false;
            
            if(sizeof($searchString)>0)
            {
                for($i=0;$i<sizeof($searchString);$i++)
                {
                    $query = $this->db->query("SELECT id, username, lastname, firstname FROM users WHERE username LIKE '$searchString[$i]' OR lastname LIKE '$searchString[$i]' OR firstname LIKE '$searchString[$i]'");
                    if($query->num_rows() > 0)
                    {
                        foreach ($query->result_array() as $row)
                        {
                            foreach($data as $d)
                            {
                                if ($d == $row)
                                {
                                    $dup=true;
                                    break;
                                }
                            }
                            if(!$dup)
                                $data[] = $row;
                            $dup=false;
                        }
                    }
                }
                return $data;
            }
            else
                return false;
        }        
    }
    
    function br2nl($string)
    {
        return PREG_REPLACE('#<br\s*?/?>#i', "", $string); 
    }
    
    function updateProfile()
    {
        $data = array(
            'firstname' => $this->input->post('firstname'),
            'lastname' => $this->input->post('lastname'),
            'username' => $this->input->post('username'),
            'about' => $this->input->post('about')
        );
        
        $this->db->where('id', $this->session->userdata('id'));
        $this->db->update('users',$data);
        redirect(base_url().'feed/all');
    }
}
