# Domain Analyzer → AI Project Context

Domain Analyzer v2 now feeds a compact structural resource map into the existing AI context.

```text
DB schema
  -> Domain Analyzer
  -> docs/ai/project.json: domainAnalysis
  -> AI_PROJECT_CONTEXT.md guidance
  -> AI + explicit application requirement
  -> proposed business operation
  -> developer confirmation
  -> implementation
```

No business method is generated automatically.

The AI must distinguish **schema facts**, **interpretation derived from the user's requirement**, and **missing domain information**. A newly inferred business operation requires confirmation before implementation.
