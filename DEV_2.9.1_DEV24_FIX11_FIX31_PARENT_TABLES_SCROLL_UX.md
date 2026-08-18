# 2.9.1-dev24-fix11-fix31 — Parent database tables scroll UX
> **Superseded by fix34:** the internal table-list scroller was removed. The current Builder keeps only the sticky card behavior.


UI-only Builder refinement.

## Change

The `Parent database tables` card keeps its header fixed while only the table list scrolls. This prevents databases with many parent tables from stretching the full Builder page.

Desktop uses a maximum list height of 360px (bounded by the viewport). On smaller screens the card is no longer sticky and the list may use up to 50vh.

## Boundaries

No configuration schema, generator, Model, Service, DTO, API, Dashboard runtime, or publish behavior is changed.
