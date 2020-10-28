<?php
namespace App\Http\Controllers;

use Exception;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = userRepo;
    }


    public function register($parameters)
    {
        $decrypted_password = $parameters['password'];
        $parameters['password'] = bcrypt($parameters['password']);
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

    /**
     * login - Method to realize the Login
     *
     * @param string $email Email from the user
     * @param string $password Password from the user
     *
     * @return mixed
     */
    public function login(string $email, string $password)
    {
        $credentials = ["email" => $email, "password" => $password];
        if (!$token = auth()->attempt($credentials)) {
            return false;
        }

        $data_return = [
            'name' => Auth::user()->name,
            'token' => $token
        ];

        return $data_return;
    }
}
