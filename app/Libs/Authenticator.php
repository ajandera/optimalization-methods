<?php

use Nette\Security\IAuthenticator;

/**
 * Class Authenticator
 */
class Authenticator implements IAuthenticator
{
    /** @var \Nette\Database\Context  */
    private $database;

    /** @var \Nette\Security\Passwords  */
    private $passwords;

    /**
     * Authenticator constructor.
     * @param \Nette\Database\Context $database
     * @param \Nette\Security\Passwords $passwords
     */
    public function __construct(Nette\Database\Context $database, Nette\Security\Passwords $passwords)
    {
        $this->database = $database;
        $this->passwords = $passwords;
    }

    /**
     * @param array $credentials
     * @return \Nette\Security\IIdentity
     * @throws \Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials): Nette\Security\IIdentity
    {
        [$email, $password] = $credentials;

        $row = $this->database->table('users')
            ->where('email', $email)->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('EEmail nie je registrovaný.');
        }

        if (!$this->passwords->verify($password, $row->password)) {
            throw new Nette\Security\AuthenticationException('Zadali ste zlé heslo.');
        }

        return new Nette\Security\Identity($row->id, $row->role, ['email' => $row->email]);
    }
}
