# MalayaBits — Development Notes

## Branch
All customizations live on `feature/autofeaturedtorrent` in the forked repo.
No pull requests are opened — changes stay on the fork.

---

## Login Page Background

- Poster image location: `public/img/poster.png`
- Served at: `/img/poster.png`
- To replace the poster, upload a new file via SCP then rebuild assets:
  ```
  scp "E:\path\Poster.png" root@<server>:/var/www/html/public/img/poster.png
  npm run build
  ```
- Dark overlay is set in `resources/sass/pages/_auth.scss`:
  ```scss
  body::before { background: rgba(0, 0, 0, 0.5); }
  ```
  Adjust the last value: `0.3` = lighter, `0.7` = darker.

---

## Site Logo Color

- Gold/orange gradient applied in two places:
  - Top nav: `resources/sass/layout/_top_nav.scss`
  - Login page: `resources/sass/pages/_auth.scss`
- Gradient: `radial-gradient(circle, gold, orange 44%, #ff8c00 86%)`

---

## Group Rename: User → Pengguna

| File | Change |
|------|--------|
| `database/seeders/GroupSeeder.php` | Name changed to `Pengguna`, slug stays `user` |
| `app/Http/Controllers/Staff/GroupController.php` | Default group lookup uses `Pengguna` |
| `app/Http/Requests/Staff/UpdateGroupRequest.php` | Simplified name validation |

---

## Site Config

| Setting | Value | File |
|---------|-------|------|
| Locale | `ms` (Bahasa Melayu), fallback `en` | `config/app.php` |
| Sub-title / Meta description | `Arkib` | `config/other.php` |
| Global Freeleech | `false` | `config/other.php` |
| Global Double Upload | `false` | `config/other.php` |
| Invite Only | `true` | `config/other.php` |

---

## Login Page Footer

- Contact link added: `mailto:bantuan@malayabits.cc`
- Label: *"Problem logging in? Contact us!"*
- Located in: `resources/views/auth/login.blade.php`

---

## Build

After any SCSS or JS change, run:
```bash
npm run build
```
Then hard-refresh the browser (`Ctrl+Shift+R`) to bypass cache.
