<?php
namespace App\Validator;


use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;

/**
 * Global class to validate form data.
 * 
 */
class UserValidator 
{
  
  public $_errors =array();


  /**
   * Function to validate user data and return error
   *
   * @param $data  
   *  array containng key(html element name) value(element value) pair values.
   * 
   * @param $rules 
   *  2D array containg rules for specific key(html element name).
   * 
   */
  public function validate($data, $rules)
  {

    foreach ($data as $item => $item_value) {

      if (key_exists($item, $rules)) {

        foreach ($rules[$item] as $rule => $rule_value) {

          switch ($rule) {
            case 'required':
              if (empty($item_value) && $rule_value) {
                $this->addError($item, ucwords($item) . ' required');
              }
              break;

            case 'minLen':
              if (strlen($item_value) < $rule_value) {
                $this->addError($item, ucwords($item) . ' should be minimum ' . $rule_value . ' characters');
              }
              break;

            case 'maxLen':
              if (strlen($item_value) > $rule_value) {
                $this->addError($item, ucwords($item) . ' should be maximum ' . $rule_value . ' characters');
              }
              break;

            case 'numeric':
              if (!ctype_digit($item_value) && $rule_value) {
                $this->addError($item, ucwords($item) . ' should be numeric');
              }
              break;
            case 'alpha':
              if (!ctype_alpha($item_value) && $rule_value) {
                $this->addError($item, ucwords($item) . ' should be alphabetic characters');
              }
              break;
            case 'reg_email':
              if (!filter_var($item_value, FILTER_VALIDATE_EMAIL)){
                $this->addError($item,  'Invalid Email Format');

              }
              break;
            case 'reg_password':
              if (!preg_match('@[0-9]@', $item_value) || !preg_match('@[a-z]@', $item_value) || !preg_match('@[0-9]@', $item_value)) {
                $this->addError($item,  'Password Must contain uppercase + lowercase + digit character');
              }
              break;

          }
        }
      }
    }
  }


  /**
   * Function to add error to the $_error array
   * 
   * @return void
   */
  private function addError($item, $error){
    array_push($this->_errors,$error);
    // $this->_errors[$item][] = $error;
  }

  
  /**
   * Function to check for error present after validation.
   * 
   * @return string $_errors
   * Return string containing error message of perticular elements.
   */
  public function error(){
    $err_msg="";
    for ($row = 0; $row < count($this->_errors); $row++) {
      $err_msg=$err_msg+$this->_errors[$row];
      
    }
    return $err_msg;
  }
}
