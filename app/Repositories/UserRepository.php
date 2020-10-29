<?php
namespace App\Repositories;

use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class UserRepository extends BaseRepository
{
    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function register($parameters)
    {
        $decrypted_password = $parameters['password'];
        $parameters['password'] = bcrypt($parameters['password']);

        $userExists = $this->findByEmail($parameters["email"]);

        if ($userExists) {
            throw new Exception("There is a user registered with that same email, maybe you completed registration before?", 400);
        }

        $user = $this->create($parameters);

        return $this->login($parameters['email'], $decrypted_password);
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
        if (!$token = auth()->attempt($credentials, true)) {
            return false;
        }

        $data_return = [
            'name' => Auth::user()->name,
            'token' => $token
        ];

        return $data_return;
    }

    /**
     * isLogged - Method to check if user is logged and send a message
     *
     * @param BotMan $botman BotMan instance
     *
     * @return bool
     */
    public function isLogged($botman): bool
    {
        if (!Auth::check()) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * User search using the email
     *
     * @param string $user
     *
     * @return object
     */
    public function findByEmail(string $email)
    {
        $user = $this->model->where("email", $email)->first();
        return $user;
    }
}
