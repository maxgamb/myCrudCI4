# myCrudCI4 2.9.1-dev2-fix2 — Class-name repair

Fixes identifier corruption introduced by the full-English sweep.

Repaired:

- `GlobalGeneratedonService` → `GlobalGenerationService`
- `ConfiguredGeneratedonService` → `ConfiguredGenerationService`
- `GeneratedonDiffService` → `GenerationDiffService`
- user-facing `Generatedon` text → `Generation`

No generator/runtime behavior change beyond restoring the correct class names.
