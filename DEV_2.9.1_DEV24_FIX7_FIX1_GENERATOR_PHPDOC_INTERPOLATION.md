# myCrudCI4 2.9.1-dev24-fix7-fix1

## Generator PHPDoc interpolation fix

The dev24-fix7 PHPDoc cleanup introduced two generator-time interpolation bugs.

### ControllerGenerator
An interpolated heredoc contained the generated PHPDoc token `$isUpdate` without escaping it. PHP therefore attempted to resolve a generator variable named `$isUpdate` while building the generated Controller.

### ServiceGenerator
Interpolated heredocs for explicit related-Service helpers contained `$payload` in PHPDoc without escaping it. PHP attempted to resolve `$payload` in the generator itself.

Both PHPDoc variables are now emitted literally (`$isUpdate`, `$payload`) in generated files by escaping them in generator heredocs.

No generated architecture or runtime behavior is otherwise changed.
