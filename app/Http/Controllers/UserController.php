<?php
namespace App\Http\Controllers;

use Exception;
use App\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository
    }


    public function register()
    {
        //$decrypted_password = $parameters['password'];
        //$parameters['password'] = bcrypt($parameters['password']);
        /*
                $userExists = $this->userRepository->findByEmail($parameters["email"]);

                if ($userExists) {
                    throw new Exception("There is a user registered with that same email, maybe you completed registration before?", 400);
                }

                $user = $this->userRepository->create($parameters);

                $credentials = ["email" => $parameters['email'], "password" => $decrypted_password];
                if (!$token = auth()->attempt($credentials)) {
                    return false;
                }

                $data_return = [
                    'name' => Auth::user()->name,
                    'token' => $token
                ];
        */
        return "hola";
    }


}
