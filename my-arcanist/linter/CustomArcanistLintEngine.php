<?php

class CustomArcanistLintEngine extends ArcanistLintEngine {

  public function buildLinters() {
    $linters = array();
    $linters[] = (new AddPunctuationLinter())->setPaths(array('example.txt'));
    $linters[] = (new CapitalizeLineLinter())->setPaths(array('example.txt'));
    return $linters;
  }
}
