# myCrudCI4 2.9.1-dev24-fix11-fix40

## RC contract gate alignment

This recovery keeps runtime architecture unchanged and updates only regression contracts that had drifted from the current generated architecture.

- API Resources remain output-only; the contract uses a namespace-safe regex.
- MCP read-only tools are expected to depend on generated Models, never Services or direct DB access.
- With a generated Service, cross-resource/pivot transactions are orchestrated through the Model transaction API by the Service. Model-owned create transactions are expected only without a Service layer.
- Unique nested-FK filtering is explicit generation-time PHP and must not reintroduce `uniqueConsumerTable`/`uniqueConsumerField` runtime metadata markers.
- CLI command documentation coverage no longer interpolates `$name` accidentally.
- Shield tests assert semantic `permission:` generation rather than a specific quote style.
