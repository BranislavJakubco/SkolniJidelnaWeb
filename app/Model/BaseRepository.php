<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Database\Explorer;

abstract class BaseRepository {

    use Nette\SmartObject;

    /** @var Explorer */
    protected $database;

    public function __construct(Explorer $database) {
        $this->database = $database;
    }

}
