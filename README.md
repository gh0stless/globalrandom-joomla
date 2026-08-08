# com_globalrandom — GLOBAL RANDOM for Joomla

A Joomla component wrapper that embeds **[GLOBAL RANDOM](https://github.com/gh0stless/global-random)** — a self-contained HTML radio that plays music from 247 countries via real, fairness-weighted randomness (MusicBrainz + Spotify), with live translation into up to 87 languages.

Live reference (original, non-Joomla deployment): **[crazy-midi.de/global-random](https://crazy-midi.de/global-random/)** — this component is also deployed as its own separate, live Joomla installation.

## What this repo is

This is a thin **wrapper**, not the app itself: `com_globalrandom/site/global-random.html` is a synced, unmodified copy of the canonical [global-random](https://github.com/gh0stless/global-random) source. All actual feature work happens there and is manually synced here (see commit history — "Sync: ..." commits).

## Structure

| Path | Purpose |
|---|---|
| `com_globalrandom/globalrandom.xml` | Joomla extension manifest |
| `com_globalrandom/site/global-random.html` | Synced copy of the canonical app |
| `com_globalrandom/site/beschreibung.html` / `description.html` | Synced project description (DE/EN) |
| `com_globalrandom/site/src`, `tmpl` | Joomla site view/controller code |
| `com_globalrandom/admin` | Joomla backend (manifest-required, minimal) |
| `com_globalrandom/media/css` | Component-specific styling |

## Install

Standard Joomla extension install: package `com_globalrandom` (or the folder directly) via the Joomla admin **Extensions → Manage → Install**.

## License

This wrapper component (Joomla integration code) is licensed under **AGPL-3.0-or-later**.

The embedded artwork (`global-random.html`) is licensed separately under **[CC BY-NC-ND 4.0](https://creativecommons.org/licenses/by-nc-nd/4.0/)** — no derivatives/modifications permitted. See the [canonical repo](https://github.com/gh0stless/global-random) for details.

© 2026 Andreas S.
