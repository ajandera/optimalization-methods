<?php

namespace App\Model;

use Nette;

class UsersManager
{
    use Nette\SmartObject;

    /** @var Nette\Database\Context */
    private $database;

    /** @var Nette\Security\Passwords */
    private $passwords;

    /**
     * UsersManager constructor.
     * @param Nette\Database\Context $database
     * @param Nette\Security\Passwords $passwords
     */
    public function __construct(Nette\Database\Context $database, Nette\Security\Passwords $passwords)
    {
        $this->database = $database;
        $this->passwords = $passwords;
    }

    /**
     * @return Nette\Database\Table\Selection
     */
    public function getUsers()
    {
        return $this->database->table('users')
            ->order('last_login DESC');
    }

    /**
     * @param $email
     * @param $password
     */
    public function insert($email, $password)
    {
        $this->database->table('users')->insert([
            'email' => $email,
            'password' => $this->passwords->hash($password),
            'role' => 1
        ]);
    }
}