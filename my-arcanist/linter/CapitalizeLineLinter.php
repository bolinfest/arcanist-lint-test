<?php

class CapitalizeLineLinter extends ArcanistLinter {

  const LINT_NOT_CAPITALIZED = 1;

  public function getLinterName() {
    return 'CapitalizeLineLinter';
  }

  public function lintPath($path) {
    $this->raiseLintAtOffset(
      /* offset */ 0, // This is 0-based and is a char offset into the file. 
      self::LINT_NOT_CAPITALIZED,
      'Line must be capitalized.',
      'i start with a lowercase letter and do not end with a full stop',
      'I start with a lowercase letter and do not end with a full stop');
  }

}
