<?php
class User{
    public $user_name;
    public $USERS_ID;
    public $email;
    public $password;

    function filter($postArray){
        $filteredArray = [];
        foreach ($postArray as $key => $value) {
            // Sanitizes each input
            $filteredArray[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        
        return $filteredArray;
    }
    function validate_input($inputArray){
      
    }
}