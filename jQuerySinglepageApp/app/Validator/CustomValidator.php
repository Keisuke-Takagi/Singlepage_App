<?php
namespace App\Validator;
 
class CustomValidator extends \Illuminate\Validation\Validator
{
 
    public function validateZipcode($attribute, $value, $parameters)
    {
        return preg_match('/^\d{3}-\d{4}$/', $value);
    }
     
    public function validatePasswordCheck($attribute, $value, $parameters)
    {
        return preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{5,18}+\z/i', $value);
    }
}
?>