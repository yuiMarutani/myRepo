<?php
class User{
    protected $user_name;
    protected $USERS_ID;
    protected $email;
    protected $password;
    protected $mode;

    //モードなし
    function __construct($user_name,$USERS_ID, $email,$password,$mode){
		$this->user_name = $user_name;
		$this->USERS_ID = $USERS_ID;
		$this->email = $email;
		$this->password = $password;
        $this->mode = $mode;
	}

    function setUsername(){
        $this->user_name = $user_name;
    }

    function getUsername(){
        return $this->username;
    }

    function setUsers_id(){
        $this->USERS_ID = $USERS_ID;
    }
    function getUsers_id(){
        return $this->USERS_ID;
    }
    function setEmail(){
        $this->email = $email;
    }

    function getEmail(){
        return $this->email;
    }

    function setPassword(){
        $this->password = $password;
    }

    function getPassword(){
        return $this->password;
    }
    //modeなしのフィルタ
    function filter(){
        $dlist=array();
        $user_name=$this->user_name;
        $USERS_ID=$this->USERS_ID;
        $email=$this->email;
        $password=$this->password;
        $mode=$this->mode;
        $required=array('user_name'=>$user_name,'USERS_ID'=>$USERS_ID,'email'=>$email,'password'=>$password,'mode'=>$mode);
        foreach($required as $k=>$v){
            $dlist[$k]=htmlspecialchars($v);
        }
        
        return $dlist;
    }
   
    function validate_input($dlist){
      
    }
}