<?php
namespace App\Repositories;

use App\User;
use Illuminate\Support\Collection;

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
        $user = $this->obj->where("email", $email)->first();
        return $user;
    }
}
