# 2.9.1-dev24-fix11-fix27 — Dashboard Recent DTO guard false-positive fix

## Problem

`mycrud:test-dashboard` treated every `->toArray()` call found in the generated `DashboardService` as a DTO-boundary violation. Relation-aware Recent widgets legitimately normalize source Entities to raw record data before calling `RecentRecord::collection()`, so a valid Dashboard could report `Dashboard recent-record DTO boundary` as FAIL.

## Correct contract

The protected boundary is not “no `toArray()` anywhere”. The contract is:

1. generated Model results may be arrays, Entities, or ordinary objects;
2. those source records may be normalized before DTO construction;
3. `RecentRecord::collection()` creates the presentation DTOs;
4. the resulting `RecentRecord` objects must not be flattened before the View.

The structural guard now checks for DTO construction and direct typed-record transport, while rejecting explicit `RecentRecord` array mapping. The runtime smoke test continues to verify that Recent widget records are actual `RecentRecord` instances.

No runtime behavior changed.
