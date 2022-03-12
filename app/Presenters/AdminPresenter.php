<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\UserManager;
use Nette\Application\UI\Presenter;

final class AdminPresenter extends Presenter
{
  /** @var UserManager @inject */
  public $userManager;

  /** @persistent */
  private $id;

  protected function startup()
  {
    parent::startup();

    if (!$this->user->isLoggedIn()) {
      if ($this->isLinkCurrent("Admin:login")) {
        $this->redirect("Admin:login");
      }
    }
  }

  public function renderDefault() {
    // set stats data for main page
  }


}
