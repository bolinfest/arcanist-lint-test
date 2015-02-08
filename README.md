# Testing `arc lint`

`arc lint` does not appear robust to multiple autofixes applied to the same
line, or even autofixes applied in reverse order.

Reading through the source of [ArcanistLintPatcher.php](https://github.com/phacility/arcanist/blob/38502ba9102c9dc843b2f9e1eb67231535d46fc2/src/lint/ArcanistLintPatcher.php),
the logic to apply autofix patches lives in
[`buildModifiedFile()`](https://github.com/phacility/arcanist/blob/38502ba9102c9dc843b2f9e1eb67231535d46fc2/src/lint/ArcanistLintPatcher.php#L63).
As each fix is applied, the `$dirty` offset is increased through the original
file to indicate the last line where a lint was applied. If this offset
exceeds the offset for the current lint to be patched, it is ignored:

```c
$orig_offset  = $this->getCharacterOffset($lint->getLine() - 1);
$orig_offset += $lint->getChar() - 1;

$dirty = $this->getDirtyCharacterOffset();
if ($dirty > $orig_offset) {
  continue;
}
```

In particular, it appears to be ignored silently. I created this repo to test
this out. The file to be linted is `example.txt`:

```
i start with a lowercase letter and do not end with a full stop.
```

`CapitalizeLineLinter` is a hardcoded lint to capitalize the first line while
`AddPunctuationLinter` is a hardcoded lint to add a period at the end of the
line. Here is what happens when I use Arc's autofix:

```
$ cp clean-example.txt example.txt
$ arc lint --apply-patches
$ cat example.txt
i start with a lowercase letter and do not end with a full stop.
```

As you can see, only the `AddPunctuationLinter` is applied.
