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
herd composer install
```

## 🔐 Copy & Configure Environment

```bash
cp .env.example .env
```

## 🔑 Generate Application Key

```bash
herd php artisan key:generate
```

## 🗄️ Run Migrations

```bash
herd php artisan migrate

# Or with seeds
# herd php artisan migrate --seed
```

## 🍔 Make your stage's

```bash
herd php artisan make:stage ExampleStage

# INFO  [app/Actions/Journey/Stages/ExampleStage.php] created successfully.
```

## 🔥 With Laravel Herd
- **Laravel herd** for local development (https://herd.laravel.com/)
```
# Visit the link to see inbound events
http://atd-whatsapp-bot-api.test/repl/whatsapp
```

## 🤝 Contributing

Feel free to fork this repo and submit pull requests. Make sure to follow Laravel's best practices!