<?php

declare(strict_types=1);

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;

final class UserManager implements Authenticator {

  private $database;
	private $passwords;

	public function __construct(
		Explorer $database,
		Passwords $passwords
	) {
		$this->database = $database;
		$this->passwords = $passwords;
	}

  public function authenticate(string $username, string $password): IIdentity
	{
    $row = $this->database->table('users')
			->where('username', $username)
			->fetch();

		if (!$row) {
			throw new AuthenticationException('User not found.');
		}

		if (!$this->passwords->verify($password, $row->password)) {
			throw new AuthenticationException('Invalid password.');
		}

    return new SimpleIdentity($row->id,
      "admin",
      [ 'name' => $row->username]
    );
  }
}