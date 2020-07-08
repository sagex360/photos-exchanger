<?php


namespace App\DTO\Auth\Register;


use App\ValueObjects\Login;
use App\ValueObjects\Name;
use App\ValueObjects\Password;

final class RegisterClientDto
{
    protected Name $name;
    protected Login $login;
    protected Password $password;

    /**
     * RegisterClientDto constructor.
     * @param  string  $name
     * @param  string  $login
     * @param  string  $password
     */
    public function __construct(string $name, string $login, string $password)
    {
        $this->name = Name::create($name);
        $this->login = Login::create($login);
        $this->password = Password::create($password);
    }

    /**
     * @return Name
     */
    public function getName(): Name
    {
        return $this->name;
    }

    /**
     * @return Login
     */
    public function getLogin(): Login
    {
        return $this->login;
    }

    /**
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }
}
