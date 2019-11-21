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
        // 英数字一文字以上含みかつ、全てが英数文字のみ
        return preg_match('/^([a-zA-Z]+(?=[0-9])|[0-9]+(?=[a-zA-Z]))[0-9a-zA-Z]+$/', $value);
    }
    public function validateMinLength($attribute, $value, $parameters){
                // 英数字一文字以上含みかつ、全てが英数文字のみ
                return preg_match('/[!-~]{5,10}/', $value);
    }

}
?>