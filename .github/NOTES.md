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

## Chatbox Bot Messages (Bahasa Melayu)

All NerdBot, AutoNerdStat, AutoFeatureTorrent, AutoRemoveFeaturedTorrent,
AutoRewardResurrection, and listener/controller chatbox messages are
hardcoded in PHP (not in language files). Files edited:

| File | Messages Translated |
|------|---------------------|
| `app/Bots/NerdBot.php` | NerdBot responses |
| `app/Console/Commands/AutoNerdStat.php` | Daily stat messages |
| `app/Console/Commands/AutoFeatureTorrent.php` | Featured torrent announcement |
| `app/Console/Commands/AutoRemoveFeaturedTorrent.php` | Remove featured announcement |
| `app/Console/Commands/AutoRewardResurrection.php` | Resurrection reward messages |
| `app/Http/Controllers/TorrentController.php` | Upload/freeleech messages |
| `app/Http/Controllers/API/TorrentController.php` | API upload/featured messages |
| `app/Http/Controllers/Staff/ModerationController.php` | Moderation messages |
| `app/Http/Controllers/SubtitleController.php` | Subtitle upload messages |
| `app/Http/Controllers/TorrentBuffController.php` | Buff/featured/double-upload messages |
| `app/Http/Controllers/TorrentReseedController.php` | Reseed request message |
| `app/Listeners/AchievementUnlocked.php` | Achievement unlock message |
| `app/Listeners/RegisteredListener.php` | Welcome messages (7 random) |

---

## Bahasa Melayu Language Files (`lang/ms/`)

All translation files are maintained locally in the fork (not Weblate).

### Files with added missing keys
`forum.php`, `auth.php`, `bon.php`, `common.php`, `graveyard.php`,
`notification.php`, `pm.php`, `poll.php`, `request.php`, `rss.php`,
`staff.php`, `stat.php`, `torrent.php`, `user.php`, `validation.php`

### New files created
`comment.php`, `event.php`, `mediahub.php`, `playlist.php`,
`regions.php`, `subtitle.php`, `ticket.php`

### Translation quality improvements (notable fixes)
| File | Key | Was | Now |
|------|-----|-----|-----|
| `torrent.php` | `seeders` | Peniaga (merchants!) | Seeder |
| `torrent.php` | `movies` | Wayang (theatre) | Filem |
| `torrent.php` | `commited` | Berjaya (successful) | Komited |
| `torrent.php` | `downloaded` | Dikemaskini (updated) | Dimuat Turun |
| `torrent.php` | `general` | Ketua (chief) | Am |
| `torrent.php` | `featured` | Disediakan | Ditonjolkan |
| `torrent.php` | `my-active-torrents` | Kuasa aktif saya | Torrent Aktif Saya |
| `stat.php` | `top-downloaded` | Dikemaskini | Dimuat Turun |
| `stat.php` | `top-seeders` | Seeders Top | Seeder Teratas |
| `stat.php` | `banned` | Kena 'ban' | Dilarang |
| `stat.php` | `disabled` | 'Disabled' | Dilumpuhkan |
| `staff.php` | `mass-pm` | Mass Mass | PM Berjisim |
| `staff.php` | `flush-ghost-peers` | Pejuang Hantu Flush | Buang Rakan Sebaya Hantu |
| `graveyard.php` | `howto` | Heres The Rule | Peraturan |
| `request.php` | `claim-as-anon` | Secara Maju | tanpa nama |
| `request.php` | `bounty` | Bounty | Ganjaran (standardised across all files) |
| `user.php` | `unlocked` | Dikunci (locked!) | Dibuka Kunci |
| `user.php` | `not-satisfied-not-immune` | Not Satisfied / Not Immune | Tidak Puas / Tidak Imun |
| `user.php` | `invites-count` | Anda Memiliki: mengira Mengimbas Token | Anda Mempunyai :count Jemputan |
| `common.php` | `username` | "Username" | Nama Pengguna |
| `common.php` | `sticked` | "Sticked" | Ditampal |
| `auth.php` | `banned` | di'ban' | dilarang |

---

## Build

After any SCSS or JS change, run:
```bash
npm run build
```
Then hard-refresh the browser (`Ctrl+Shift+R`) to bypass cache.
