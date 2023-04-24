<?php

namespace App\Services;

use App\Entity\Users;
use App\Validator\UserValidator;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use function PHPUnit\Framework\isEmpty;

class AuthService extends UserValidator
{
  /**
   * Instance of Entity Manager Interface
   * @var EntityManagerInterface
   */
  private $em = null;


  /**
   * Function to initilize the values, achieved.
   * 
   */
  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }


  /**
   * Function to register new user a
   * 
   * @param Request $request;
   * Contains data as request of client.
   *
   */
  public function register(Request $request) {
    $result["status"] = "";
    $result["message"] = "";

    // If no user found register new user.
    if ($this->isUserExist($request->request->get('email'))==NULL) {
      try {
        //The hash of the password that can be stored in the database
        $encryped_password = password_hash($request->request->get('password'), PASSWORD_DEFAULT);
        
        //Contains element to be validated.
        $data = [
          'name' => $request->request->get('name'),
          'email' => $request->request->get('email'),
          'password', $request->request->get('password')
        ];

        #contains rules for each element.
        $rules = [
          'name' => ['required', 'minLen' => 4, 'maxLen' => 150, 'alpha'],
          'email' => ['required', 'maxLen' => 150, 'reg_email'],
          'password' => ['required', 'minLen' => 6, 'reg_password']
        ];

        // Validate the form data.
        $validatior = new UserValidator();
        $validatior->validate($data, $rules);
        $error_mgs = $validatior->error();

        // Exicute this block if contains any php validation error.
        if (!isEmpty($error_mgs)) {
          $result['status'] = 'error';
          $result['message'] = $error_mgs;
        } else {
          $user = new Users();
          $user->setName($request->request->get('name'));
          $user->setEmail($request->request->get('email'));
          $user->setPassword($encryped_password);

          $this->em->persist($user);

          if ($this->em->flush() == null) {
            $result['status'] = "success";
            $result['message'] = "User created successfully";
            setCookie('uid', $request->request->get('email'));
          } else {
            $result['status'] = "failed";
            $result['message'] = "User creation failed";
          }
        }
      } catch (Exception $e) {
        $result["status"] = "failed";
        $result["message"] = "what is it";
      }
    } else {
      $result["status"] = "failed";
      $result["message"] = "User Already Exist";
    }
    return $result;
  }


  /**
   * Function to login new user a
   * 
   * @param Request $request;
   * Contains data as request of client.
   *
   */
  public function login(Request $request){
    $result["status"] = "";
    $result["message"] = "";

    //get the existing usser
    $user = $this->isUserExist($request->request->get('email'));

    // If  user found in db move ahed
    if ($user!=NULL) {
      try {

        //Contains element to be validated.
        $data = [
          'email' => $request->request->get('email'),
          'password', $request->request->get('password')
        ];

        //Contains rules for each element.
        $rules = [
          'email' => ['required', 'maxLen' => 150, 'reg_email'],
          'password' => ['required', 'minLen' => 6, 'reg_password']
        ];
        // Validate the form.
        $validatior = new UserValidator();
        $validatior->validate($data, $rules);
        $error_mgs = $validatior->error();

        //check for server validation error
        if (!isEmpty($error_mgs)) {
          $result['status'] = 'error';
          $result['message'] = $error_mgs;
        } else {

          // Check for password match for the same user found.
          if ($this->isPasswordCorrect($request->request->get('password'), $user)) {
            $result["status"] = "success";
            $result["message"] = "User loged in success";
            setCookie('uid', $request->request->get('email'));
          } else {
            $result["status"] = "failed";
            $result["message"] = "User Password do not match";
          }
        }
      } catch (Exception $e) {
        $result["status"] = "failed";
        $result["message"] = $e->getMessage();
      }
    } else {
      $result["status"] = "failed";
      $result["message"] = "No user found with the given mail";
    }
    return $result;
  }

  //return $user obj if user exist and NULL if not.
  public function isUserExist($email)
  {
    $user = $this->em->getRepository(Users::class)->findOneBy(['email' => $email]);
    return $user ? $user : NULL;
  }

  //return true if user password is matched and false if not.
  public function isPasswordCorrect($password, $user)
  {
    return password_verify($password, $user->getPassword());
  }

  //function to set cookies for 12 hr.
  public function setCookie($cookie_name, $cookie_value)
  {
    setcookie($cookie_name, $cookie_value, time() + (4320));
  }
}
