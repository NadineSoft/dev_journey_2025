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
git clone https://github.com/username/project.git
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
