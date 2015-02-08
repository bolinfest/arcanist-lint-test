<?php

class AddPunctuationLinter extends ArcanistLinter {

  const LINT_NOT_PUNCTUATED = 1;

  public function getLinterName() {
    return 'AddPunctuationLinter';
  }

  public function lintPath($path) {
    $this->raiseLintAtOffset(
      0,
      self::LINT_NOT_PUNCTUATED,
      'Line must be capitalized.',
      'i start with a lowercase letter and do not end with a full stop',
      'i start with a lowercase letter and do not end with a full stop.');
  }

}
