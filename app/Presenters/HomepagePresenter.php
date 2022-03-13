<?php

declare(strict_types=1);

namespace App\Presenters;

use App\Model\FoodScoreFormData;
use App\Model\RatingRepository;
use ErrorException;
use JsonException;
use Nette\Application\Responses\TextResponse;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;
use Nette\Utils\Json;

final class HomepagePresenter extends Presenter
{
  /** @var RatingRepository @inject */
  public RatingRepository $repository;

  public function renderDefault() {
    $reasons = [
      1 => "Rozvařené/nedovařené",
      2 => "Neodpovídá objednávce",
      3 => "Nízká kvalita",
      4 => "Nedochucené",
      5 => "Přesolené",
      6 => "Jiné"
    ];

    $this->template->reasons = $reasons;
  }

  protected function createComponentScoreForm(): Form {
    $form = new Form;

    $form->addInteger('cisloObedu')
      ->addRule($form::RANGE, arg: [1, 2])
      ->setRequired();
    $form->addInteger('scoreObed')
      ->addRule($form::RANGE, arg: [1, 4])
      ->setRequired();

    $form->addInteger('scorePolevky')
      ->addRule($form::RANGE, arg: [1, 4]);

    $form->addInteger('obedSpatnyDuvod')
      ->addConditionOn($form['scoreObed'], $form::MIN, 2)
        ->addRule($form::RANGE, arg: [1, 6]);

    $form->addInteger('polevkaSpatnaDuvod')
      ->addConditionOn($form['scorePolevky'], $form::MIN, 2)
        ->addRule($form::RANGE, arg: [1, 6]);

    $form->onSuccess[] = [$this, 'formSuccess'];

    return $form;
  }

  public function formSuccess(Form $form, FoodScoreFormData $data): void {
    if ($this->isAjax()) {
      $this->repository->save($data);
      $this->terminate();
    }
  }
}
