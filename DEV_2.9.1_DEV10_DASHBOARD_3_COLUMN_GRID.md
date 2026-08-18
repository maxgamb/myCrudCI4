# myCrudCI4 2.9.1-dev10 — Dashboard 3-column grid

Baseline: `2.9.1-dev9`.

The Dashboard Builder widget list is now a responsive Bootstrap grid:

```text
col-12 col-md-6 col-xl-4
```

This results in:

- 3 cards per row on desktop;
- 2 cards per row on tablet;
- 1 card per row on mobile.

The internal widget form was compacted for the narrower card width. Advanced
sections remain collapsible.

Sortable ordering now works on the grid slot rather than the inner card, so
persistent widget ordering remains correct.
