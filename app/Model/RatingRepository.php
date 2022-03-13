<?php

declare(strict_types=1);

namespace App\Model;

final class RatingRepository extends BaseRepository {

  public function save(FoodScoreFormData $data) {
    $this->database->query('INSERT INTO hodnoceni ?', [
      'typ_obeda' => $data->cisloObedu,
      'hodnoceni_obed' => $data->scoreObed,
      'hodnoceni_polevka' => $data->scorePolevky,
      'hodnoceni_obed_reason' => $data->obedSpatnyDuvod,
      'hodnoceni_polevka_reason' => $data->polevkaSpatnaDuvod
    ]);
  }

}
