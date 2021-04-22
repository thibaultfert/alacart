<?php

namespace App\Service\User;

use App\Repository\UserRepository;

class UserService {

    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getOneItemById(int $id)
    {
        $user = $this->userRepository->find($id);

        return $user; 
    }

    public function getOneItemByToken(string $token)
    {
        $user = $this->userRepository->findOneBy(["token" => $token]);

        return $user; 
    }

}