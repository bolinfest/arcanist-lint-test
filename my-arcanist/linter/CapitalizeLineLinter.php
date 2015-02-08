<?php

class CapitalizeLineLinter extends ArcanistLinter {

  const LINT_NOT_CAPITALIZED = 1;

  public function getLinterName() {
    return 'CapitalizeLineLinter';
  }

  public function lintPath($path) {
    // $console = PhutilConsole::getConsole();
    $data = $this->getData($path);
    $lines = explode("\n", $data);

    $offset = 0;
    foreach ($lines as $index => $line) {
      $trimmed = trim($line);
      $len = strlen($trimmed);

      if ($len !== 0 && $trimmed[0] !== strtoupper($trimmed[0])) {
        $this->raiseLintAtOffset(
          $offset,
          self::LINT_NOT_CAPITALIZED,
          'Line must be capitalized.',
          $line,
          strtoupper($trimmed[0]) . substr($trimmed, 1));
      }

      $offset += $len + 1; // +1 for newline.
    }
  }

}
