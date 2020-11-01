<?php

require_once("component/fieldset/FieldsetTs.php");


class FieldsetArrayTs_formGroup extends FieldsetTs_formGroup {

  protected function end() {
    $formGroupAsyncValidation = $this->formGroupAsyncValidation();
    $this->string .= "      _delete: [null, {}]
    }" . $formGroupAsyncValidation . ");
    return fg;
  }

";
  }


}
