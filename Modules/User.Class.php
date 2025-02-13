<?php
class User{
    protected $user_name;
    protected $USERS_ID;
    protected $email;
    protected $password;
    protected $mode;

    function __construct($user_name,$USERS_ID, $email,$password,$mode){
        $this->user_name = $user_name;
		$this->USERS_ID = $USERS_ID;
		$this->email = $email;
		$this->password = $password;
		$this->mode = $mode;
	}  
    
    //filter
    function filter(){
        $dlist = array();
        $user_name = $this->user_name;
        $USERS_ID = $this->USERS_ID;
        $email = $this->email;
        $password = $this->password;
        $mode = $this->mode;
        $required = array('user_name'=>$user_name,'USERS_ID'=>$USERS_ID,'email'=>$email,'password'=>$password,'mode'=>$mode);
        foreach($required as $k=>$v){
            $dlist[$k]=htmlspecialchars($v);
        }
        
        return $dlist;
    }

   //filter
    function filter_param($param){
        $param = htmlspecialchars($param);
        return $param;
    }
    
    function registerValidation(){
        //validationのメッセージの表示
        $user_name=$this->user_name;
		$USERS_ID=$this->USERS_ID;
		$email=$this->email;
		$password=$this->password;

        $err_msg='';
        if($user_name == ''){
            $err_msg.= 'ユーザ名が入力されていません。<br>';
        }
        if($USERS_ID == ''){
            $err_msg.= 'ユーザIDが入力されていません。<br>';
        }
        if($email == ''){
            $err_msg.= 'メールアドレスが入力されていません。<br>';
        }
        if( filter_var( $email,  FILTER_VALIDATE_EMAIL ) ){
    
        }else{
            $err_msg.='メールアドレスは不正な形式のメールアドレスです。<br>';
        }
        if($password == ''){
            $err_msg.= 'パスワードが入力されていません。<br>';
        }else{
            if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,24}$/', $password)){
        
            } else {
                $err_msg.= 'パスワードが以下の条件を満たしていません。<br>';
            }
        }

        return $err_msg;
    }
   
    
}