# myCrudCI4 2.9.1-dev9 — Dashboard Builder UI Consolidation

Baseline: `2.9.1-dev8`.

This release changes Dashboard Builder presentation only.

## Widget card

Always visible:

- Type
- Source CRUD
- Widget title
- Width
- Relevant primary options

Advanced options are grouped as:

- Presentation
- Global period
- Local filter

Configured advanced panels open automatically when loading the Builder.

## Header summary

Each widget shows:

```text
Title
Type badge
Source CRUD badge
Main operation/detail
```

The summary updates while editing.

## Drag and drop

A dedicated grip handle is used for reordering, with clearer chosen/ghost
states.

No Dashboard query, DTO, Service, filter, or persistence contract is changed.
