//state keeps track of what page we are on
// 1 = obed selection
// 2 = obed score
// 3 = obed hodnoceni
// 4 = polevka score
// 5 = polevka hodnoceni
// 6 = hodnotit polevku

let state = 1;

let reset = function () {
  data = {};
  state = 1;
  $(".selected").each(function () {
    $(this).removeClass("selected");
  });
  $("#hlavni-chod").hide();
  $("#spatny-obed").hide();
  $("#hodnoceni-polevky").hide();
  $("#spatna-polevka").hide();
  $("#hodnotit-polevku").hide();
  $("#obed-select").show();
}

let sendData = function() {
  naja.uiHandler.submitForm($("#frm-scoreForm")[0])
    .then((payload) => {
      reset();
    }).catch((error) => {
      //TODO: render error
    });
}

let advanceToObedRating = function (type) {
  state = 2;
  //data.cisloObedu = type;
  $("#cisloObedu").val(type);
  $("#obed-select").hide();
  $("#hlavni-chod").show();
}

let advanceToSoupRating = function (score) {
  //data.scoreObed = score;
  $("#scoreObed").val(score);
  $("#hlavni-chod").hide();
  if (score <= 2) {
    state = 3;
    $("#spatny-obed").show();
  } else {
    state = 6;
    $("#hodnotit-polevku").show();
  }
}

let advanceToPolevkaRating = function(score) {
  //data.scorePolevky = score;
  $("#scorePolevky").val(score);
  $("#hodnoceni-polevky").hide();
  if (score <= 2) {
    state = 5;
    $("#spatna-polevka").show();
  } else {
    sendData();
  }
}

let setSelected = function (elem) {
  if (elem.hasClass('selected')) {
    elem.removeClass('selected');
  } else {
    $(".selected").each(function () {
      $(this).removeClass("selected");
    });
    elem.addClass("selected");
  }
}


$("div[id]").each(function () {
  let $input = $(this);
  if (this.id === 'hodnoceni-obed') {
    $input.click(() => {
      advanceToSoupRating($input.attr('score'));
    });
  } else if (this.id === 'obed') {
    $input.click(() => {
      advanceToObedRating($input.attr('obed-type'));
    })
  } else if (this.id === 'hodnoceni-obed-duvod') {
    $input.click(() => {
      //data.obedSpatyDuvod = $input.attr('reason');
      $("#obedSpatnyDuvod").val($input.attr('reason'));
      setSelected($input);
    });
  } else if (this.id === 'hodnoceni-polevka-duvod') {
    $input.click(() => {
      //data.polevkaSpatnaDuvod = $input.attr('reason');
      $("#polevkySpatnaDuvod").val($input.attr('reason'));
      setSelected($input);
    });
  } else if (this.id === 'button-hodnotit-polevku') {
    $input.click(() => {
      if ($(".selected").length === 0 && state === 3) {
        return false;
      }
      $(".selected").each(function () {
        $(this).removeClass("selected");
      });
      $("#spatny-obed").hide();
      $("#hodnotit-polevku").hide();
      $("#hodnoceni-polevky").show();
      state = 5;
    });
  } else if (this.id === 'hodnoceni-polevka') {
    $input.click(() => {
      advanceToPolevkaRating($input.attr('score'));
    })
  } else if (this.id === 'button-odeslat') {
    $input.click(() => {
      if ($(".selected").length === 0 && (state === 5 || state == 3)) {
        return false;
      }
      sendData();
    });
  }
});