# Hiraku Terminal Lab

A dark terminal lab styled WordPress theme for [hiraku.dev](https://hiraku.dev/), a Traditional Chinese developer blog.

## Requirements

- WordPress 6.0+
- PHP 8.0+

## Features

- Dark terminal aesthetic with monospace typography (JetBrains Mono)
- Optimized for Traditional Chinese content
- Responsive layout
- Custom logo support
- Featured image sizes: `hiraku-terminal-featured` (960x640), `hiraku-terminal-row` (360x240)
- Primary navigation menu

## File Structure

```
hiraku-terminal/
├── assets/
│   ├── fonts/          # JetBrains Mono webfonts
│   ├── theme.js        # Main JavaScript
│   └── *.svg           # Logo variants
├── functions.php       # Theme setup and enqueues
├── header.php
├── footer.php
├── index.php
├── single.php
├── page.php
├── archive.php
├── search.php
├── searchform.php
├── comments.php
├── 404.php
└── style.css           # Theme metadata and styles
```

## Installation

Copy the `hiraku-terminal` directory to `wp-content/themes/` and activate via WordPress admin.

## Theme Info

- **Version:** 1.0.0
- **Text Domain:** `hiraku-terminal`
- **Author:** Hiraku + Codex
