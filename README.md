# 🚀 Laravel Project Installation Guide

Welcome! Follow these steps to install and run the Laravel project on your local machine.

---

## ✅ Requirements

- **PHP** >= 8.4.x
- **Composer** >= 2.x
- **MySQL** or **PostgreSQL**
- **Git**
- **Laravel herd** for local development (https://herd.laravel.com/)
- **Read and Setup Laravel Herd** (https://herd.laravel.com/docs)

---

## 📦 Clone the Repository

```bash
git clone http://10.0.44.18/celula-zapata/whatsapp-bot-api.git
cd whatsapp-bot-api
```

## ⚙️ Install PHP Dependencies

```bash
composer install
```

## 🔐 Copy & Configure Environment

```bash
cp .env.example .env
```

## 🔑 Generate Application Key

```bash
php artisan key:generate
```

## 🗄️ Run Migrations

```bash
php artisan migrate

# Or with seeds
# php artisan migrate --seed
```

## 🍔 Make your stage's

```bash
php artisan make:stage ExampleStage

# INFO  [app/Actions/Journey/Stages/ExampleStage.php] created successfully.
```


## 🤝 Contributing

Feel free to fork this repo and submit pull requests. Make sure to follow Laravel's best practices!