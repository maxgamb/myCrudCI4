# myCrudCI4 2.9.1-dev24-fix11-fix35 — Parent database tables sticky container fix

## Scope

UI-only correction for the Builder `Parent database tables` navigation panel.

## Problem

The previous implementation applied `position: sticky` to the card inside the Bootstrap `aside`. Because the `aside` had essentially the same height as the card, the sticky element had no usable vertical travel area and therefore did not follow the page scroll.

## Fix

Sticky positioning is now applied to the `aside` column itself:

- `position: sticky`
- `top: 1rem`
- `align-self: start`
- no internal vertical scroller
- normal static behavior below the Bootstrap `lg` breakpoint

The card inside the aside is a normal card. This lets the sticky column use the full height of the Builder row as its containing block.

## Contract

`Parent database tables` is desktop sticky navigation. It follows the page scroll and does not introduce a nested internal vertical scrollbar.
