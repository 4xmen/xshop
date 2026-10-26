# xShop Panel — Design Rules

The panel's look is built from two sources:

- **Structure, scales and component shapes** come from the Gamepaign design system
  (`Gamepaign-Website/src/app/shared/design-system`): semantic tokens, an 8px spacing rhythm,
  8px control / 12px card radii, hairline borders, tinted "subtle" fills, one focus ring.
- **Colours** are the *Crimson night* palette: xShop's red / magenta identity modernised into a
  rose-crimson primary and an orchid accent, on deep ink-navy surfaces (dark) or cool mist greys (light).
- **Structure** keeps the original xShop panel layout: top bar, icon rail with a slide-out section drawer,
  breadcrumb, filter column + table for lists, side widgets + main card for forms, floating action button.

## 1. The logic boundary

A redesign changes how the panel looks, never what it does.

| Allowed | Not allowed |
| --- | --- |
| SCSS under `resources/sass/panel/` | Anything under `app/`, `routes/`, `config/`, `database/`, `lang/` |
| Markup structure and classes in Blade views | Removing or renaming a Blade echo/directive (`{{ }}`, `@if`, `@error`, `route()`…) |
| `<template>` classes and `<style>` blocks in `.vue` files | Any change to a `.vue` `<script>` block |
| New wrapper elements, new presentational classes | Changing `id`, `name`, `value`, `action`, `method`, `href`, `data-*`, inline `on*` handlers, Vue props |
| Icons, spacing, order of purely visual elements | Removing a class that JavaScript selects (see `logic:guard` hook list) |
| | Editing `resources/js/**/*.js` or inline `<script>` in views |

Some CSS is behaviour, not decoration. These rules must keep working:

| Selector | Contract |
| --- | --- |
| `#panel.sided #sidebar-panel` | Drawer is hidden until `navbar.js` adds `.sided` |
| `#panel-navbar > ul li ul` | Section menus stay hidden in the rail; the drawer shows a clone |
| `#bulk-from` | `max-height: 0`; `list-checkboxs.js` sets `max-height` inline |
| `.table-list td input` | Hidden; the `label` next to it is the checkbox |
| `#step-tabs > div` / `.active` | Only the active product step is displayed |
| `#setting-sections section` | Hidden; `setting-section-controller.js` shows one |
| `#iframe-modal` | `display: none`; `fast-edit.js` shows it |
| `#attaching-form` | Fixed, `bottom: -50vh`; `fast-attachment.js` sets `bottom` inline |
| `#panel-preloader` | Fixed overlay with `overflow: hidden`; the loader animates `height` to 0 |
| `#upload-image-select`, `#avatar-input` | Hidden inputs opened by script |
| `[data-bs-theme] .theme-switch` | Shows the sun in dark, the moon in light |
| `--panel-primary`, `--panel-secondary` | Read by the dashboard charts at load; must resolve to a 6-digit hex |
| `@media (max-width: 620px)` table rules | Pair with `responsive-control.js`, which injects `span.th` labels |

### Verifying the boundary

```bash
php artisan logic:guard snapshot   # once, on code you trust
php artisan logic:guard check      # after every design change
```

`snapshot` freezes a copy of the SQLite database and the clock, renders every safe panel page twice
and stores a fingerprint of its behaviour (forms, fields, buttons, links, ids, `data-*`, inline handlers,
Vue props, scripts, JS-hook class counts, copy). `check` re-renders against the same frozen data and also
diffs the working tree against `master`: protected paths, plain JavaScript, Vue `<script>` blocks and every
Blade echo/directive. Errors mean logic changed; warnings are additions worth a look. Reports land in
`storage/logic-guard/report.md`.

## 2. Tokens

Only semantic tokens are used in component styles. Primitive ramps live in `tokens/_palette.scss` and are
read by `foundation/_root.scss` alone. Dark is the default theme; `[data-bs-theme='light']` is a full peer.

### Colour

| Token | Dark | Light | Use |
| --- | --- | --- | --- |
| `--color-background` | `#0f1321` | `#f5f6fa` | Page |
| `--color-rail` | `#0b0e19` | `#ffffff` | Top bar and icon rail |
| `--color-surface` | `#171c2f` | `#ffffff` | Cards, drawer |
| `--color-surface-raised` | `#1e2439` | `#ffffff` | Menus, modals, toasts |
| `--color-field` | `#12162a` | `#f8f9fc` | Inside inputs, table head, metric tiles, chips |
| `--color-hover` | `#1b2135` | `#f2f4f8` | Row and item hover |
| `--color-text` | `#eef1f8` | `#141827` | Body copy |
| `--color-text-muted` | `#9aa3bd` | `#5b6478` | Labels, secondary copy |
| `--color-text-disabled` | `#6b7596` | `#8c94ab` | Placeholders, disabled |
| `--color-border` | `#283050` | `#e4e7ef` | Hairlines between regions |
| `--color-border-strong` | `#6b7596` | `#8c94ab` | Control edges (≥ 3:1) |
| `--color-primary` | `#e11d48` | `#be123c` | Primary fill (crimson), white text |
| `--color-primary-hover` | `#f43f5e` | `#9f1239` | |
| `--color-primary-text` | `#fb7185` | `#be123c` | Crimson as text/icon on surfaces |
| `--color-primary-subtle` | `#3d1a32` | `#fff1f3` | Tonal fill, icon chips, active nav item |
| `--color-accent` / `-text` / `-subtle` | `#c026d3` / `#e879f9` / `#35193f` | `#a21caf` / `#a21caf` / `#fdf4ff` | Orchid accent |
| `--color-success-*` | green `#4ade80` | `#15803d` | Answered, completed |
| `--color-warning-*` | amber `#fbbf24` | `#a16207` | Pending, orders to process |
| `--color-caution-*` | orange `#fb923c` | `#c2410c` | Canceled |
| `--color-danger-*` | red `#f87171` | `#b91c1c` | Closed, failed, destructive |
| `--color-info-*` | cyan `#22d3ee` | `#0e7490` | Paid, tickets, info alerts |
| `--color-focus-ring` | `#fb7185` | `#be123c` | The only focus treatment |
| `--color-chart-1…4` | crimson, orchid, amber, cyan | | Chart series (`--panel-primary/-secondary` = 1, 2) |

Rules: text on `--color-primary` is white (`--color-text-on-primary`). Crimson text on surfaces always uses
`--color-primary-text`. Status is never shown by colour alone: dots keep their tooltip, named statuses render
as a labelled pill, alerts keep an icon.

### Scales

| Scale | Steps |
| --- | --- |
| Spacing | `3xs` 2 · `2xs` 4 · `xs` 8 · `sm` 12 · `md` 16 · `lg` 24 · `xl` 32 · `2xl` 48 · `3xl` 64 px |
| Radius | `sm` 4 (checkbox, id chip) · `md` 8 (controls, buttons, menus) · `lg` 12 (cards) · `xl` 16 (auth card) · `full` |
| Control height | `xs` 32 (small/icon buttons, pagination) · `sm` 40 (default control) · `md` 48 (auth) · `lg` 56 (FAB, steps) |
| Type | Vazirmatn; body `sm` 14px; `xs` 12 for meta and table heads; `md` 16 card titles; `lg`/`xl` page titles |
| Icons | Remix icons at 16px beside 14px text (1.15×), 20–22px in the rail and FAB; always flex-centred with their label |
| Weight | 400 copy · 500 labels and buttons · 600 headings · 700 page titles and figures |
| Motion | 120 / 200 / 320 ms, `cubic-bezier(0.2, 0, 0, 1)`; collapses under `prefers-reduced-motion` |
| Z-index | `sticky` 100 · `drawer` 900 · `dropdown` 1000 · `modal` 1200 · `toast` 1300 · `tooltip` 1400 |

Vazirmatn ships Persian-first vertical metrics (ascent 1.025em, descent 0.537em), which sit Latin capitals
0.11em above the centre of their line box and make every centred icon look low. LTR pages therefore use
`Vazirmatn UI` (`foundation/_fonts.scss`): the same files with `ascent-override: 112.25%` and
`descent-override: 43.95%`, which keep the line height and put the box centre on the cap-height centre, the way
Roboto-style UI fonts do. RTL pages keep plain Vazirmatn, whose metrics suit Persian.

Breakpoints match Bootstrap's grid (`sm` 576, `md` 768, `lg` 992, `xl` 1200, `2xl` 1400) because the views use it.

## 3. Components

Existing Bootstrap classes are restyled in place, so markup keeps working and every page inherits the system.

| Markup | Design-system variant |
| --- | --- |
| `.btn-primary` | Primary: crimson fill, white text |
| `.btn-secondary`, `.btn-outline-secondary/-light/-dark`, `.btn-dark` | Secondary: transparent, strong edge |
| `.btn-light` | Neutral tonal |
| `.btn-outline-primary`, `.btn-info` | Primary tonal |
| `.btn-success`, `.btn-outline-success` | Success tonal |
| `.btn-warning` | Warning tonal |
| `.btn-danger` | Destructive fill |
| `.btn-outline-danger` | Danger tonal |
| `.btn-link` | Ghost |
| `.circle-btn` | Round primary; `.action-btn` pins it as the page FAB beside the rail and, from `lg`, extends it with its tooltip text as a label |

- **Fields** (`.form-control`, `.form-select`, `select.form-control`): field fill, strong 1px edge, 8px radius,
  40px tall; focus = focus-ring edge + 1px ring; `.is-invalid` = danger edge; readonly = dashed edge.
  Labels sit above controls, 14px / 500.
- **Checkbox / switch**: native input restyled; checked = crimson fill.
- **Cards** (`.card`, `.item-list`, `.general-form`): surface, 1px border, 12px radius, small shadow;
  headers are a 16px/600 title row with a hairline under it and an icon in `--color-primary-text`.
- **Tables** (`.table-list`, `.table`): field-tinted head with 12px muted labels, hairline rows, hover tint,
  ID chip as the row checkbox, 32px square icon actions.
- **Status** (`.model-status.status-*`): numeric statuses (0/1) are a 10px dot with a halo; named statuses
  (`PENDING`, `PAID`, `COMPLETED`…) are a pill showing the status text from `data-bs-title`.
- **Row actions**: quiet 32px icon buttons; the hover tint carries the meaning (crimson edit, red delete,
  green approve).
- **Card headers**: a 30px tinted icon chip, then the title.
- **Menus, tooltips, modals, alerts, pagination, tabs, toasts**: raised surface, 8px radius, tokens only.

## 4. Layout

The original xShop structure is kept; each region was refined, not replaced.

- **Top bar** — sticky, 60px, translucent rail colour with blur; the xShop mark sits above the rail column,
  then the shop name; theme switch and account menu are round controls on the end side.
- **Rail** — 80px (64px under `md`), sticky. Every item is a 68×66 tile with its icon and a visible label
  (taken from the item's tooltip text), so sections are readable without hovering. The shop-front link sits
  first, divided from the sections. The section whose drawer is open is tinted crimson.
- **Drawer** — 256px overlay beside the rail, opened by a rail tile. It starts with the section title, then
  40px rows with an icon chip and label.
- **Content** — up to 1600px wide, 24–32px padding, extra bottom space so the FAB never covers content.
- **Breadcrumb** — plain trail with chevrons (mirrored in RTL); the current page is bold.
- **List page** — one header card holds the title, the trash link, the *Total* and *From – To* counts as
  chips, and the search/filter form; bulk actions follow in their own card; the table card fills the rest.
- **Form page** — tips and side widgets on the start column; the main `general-form` card with a title bar;
  its save row is a sticky bar pinned to the bottom of the viewport while the form scrolls.
- **FAB** — bottom start, beside the rail; labelled ("Add another one", "Show list", "Save all settings")
  from `lg`, icon-only below.

## 5. Writing styles

- Use tokens: `var(--color-*)`, `var(--spacing-*)`, `var(--radius-*)`, `var(--font-size-*)`,
  `var(--control-height-*)`, `var(--shadow-*)`. No raw hex outside `tokens/_palette.scss`.
- Use logical properties (`inline-size`, `margin-inline-start`, `inset-inline-end`) — the panel runs RTL and LTR.
- Every interactive element keeps a visible `:focus-visible` ring.
- Prefer restyling an existing class over adding markup; add markup only when a layout needs a wrapper.
- No comments in code; rationale belongs here.

## 6. File map

```
resources/sass/app.scss                entry
resources/sass/panel/tokens/           palette, scales, breakpoints, mixins (no CSS output)
resources/sass/panel/foundation/       root (theme tokens + Bootstrap bridge), base (elements)
resources/sass/panel/components/       button, field, card, table, overlays
resources/sass/panel/layout/           shell (top bar, rail, drawer, main), breadcrumb, page containers
resources/sass/panel/pages/            auth, dashboard, workflow (steps, settings, reports, SEO)
```
