<?php

function startsWith($haystack, $needle) {
    // search backwards starting from haystack length characters from the end
    return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
}

function endsWith($haystack, $needle) {
  // search forward starting from end minus needle length characters
  return $needle === "" || strpos($haystack, $needle, strlen($haystack) - strlen($needle)) !== FALSE;
}

class AddPunctuationLinter extends ArcanistLinter {

  const LINT_NOT_PUNCTUATED = 1;

  public function getLinterName() {
    return 'AddPunctuationLinter';
  }

  public function lintPath($path) {
    // $console = PhutilConsole::getConsole();
    $data = $this->getData($path);
    $lines = explode("\n", $data);

    $offset = 0;
    foreach ($lines as $index => $line) {
      $trimmed = trim($line);
      $len = strlen($trimmed);

      if ($len !== 0 && !(endsWith($line, '.'))) {
        $this->raiseLintAtOffset(
          $offset,
          self::LINT_NOT_PUNCTUATED,
          'Line must end with a full stop.',
          $line,
          $line . '.');
      }

      $offset += $len + 1; // +1 for newline.
    }
  }

}
