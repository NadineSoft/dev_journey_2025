# Birthday Reminder
Aplicație Laravel + Livewire pentru gestionarea aniversărilor și trimiterea de notificări automate.

## Requirements
- PHP >= 8.2
- Laravel 12
- MySQL >= 8
- Composer
- Node.js & npm

## Installation
```bash
git clone git clone https://github.com/NadineSoft/dev_journey_2025.git
cd project
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run dev
php artisan serve

## Environment Setup
Update `.env` file with your own values:


---

#### 5. **Instrucțiuni de rulare**
- Cum rulezi serverul local (`php artisan serve`).
- Cum compilezi assets (`npm run dev`).
- Cum rulezi queue workers (`php artisan queue:work`).

---

#### 6. **Testing**
- Cum rulezi testele (ex. PHPUnit sau Pest).

```md
## Testing
```bash
php artisan test
```

## ✅ Features

- [x] Auth (Breeze)
- [x] CRUD Birthdays + Media (Spatie)
- [x] Filtre + sortări + search
- [x] Policies + `@can` + toasts
- [x] Export CSV/ICS
- [ ] Notificări email (S2)
- [ ] API read-only (Sanctum)

<details>
  <summary>Detalii</summary>

- **Auth (Breeze):** login/register, protecție rute.
- **CRUD & Media:** Spatie Medialibrary pentru avatar/poze.
- **Filtre/Sort/Search:** `this_week`, `upcoming`, order by `name`/`date`, search cu reset pe pagina 1.
- **Policies & UI:** `@can` în Blade + `$this->authorize()` în Livewire.
- **Data isolation per user”** (UI @can + backend authorize + filtre user_id).
- **Export:** `GET /export/csv`, `GET /export/ics` (day/month păstrate cu zero în față).
- **Notificări (S2):** job + scheduler (în lucru).
- **API (S2):** Sanctum token + rate limit (în lucru).
</details>
