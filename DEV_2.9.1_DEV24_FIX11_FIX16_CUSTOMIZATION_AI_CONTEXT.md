# 2.9.1-dev24-fix11-fix16 — Customization example + AI context alignment

This update keeps the frozen dev24 architecture and improves developer/AI guidance without reintroducing dynamic relation resolution.

## ServiceExtension example

New persistent `app/Services/Extensions/<Entity>ServiceExtension.php` files contain a disabled/commented `exampleApplyBusinessRule(array $data): array` helper. It is documentation code, not runtime behavior. A developer may uncomment, rename and adapt it, then call it explicitly from `beforeCreate()` or `beforeUpdate()`.

Rules:

- do not edit `app/Generated/` for persistent custom behavior;
- ServiceExtension owns application rules and side effects, not SQL;
- queries remain in the concrete Model;
- cross-resource writes use concrete generated Services explicitly;
- no `new $serviceClass`, `new $modelClass`, dynamic table maps or relation resolvers.

## AI context

`mycrud:ai-context` now exports per-CRUD customization metadata and Markdown guidance including the persistent extension path, hook ordering contract, query owner and example workflow. The project context also reflects the current REST/MCP boundaries and BaseCrudModel architecture.
