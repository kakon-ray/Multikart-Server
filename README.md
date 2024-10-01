# Introduction

This is a e-commerce application. This application has two user role 'User' and 'Admin'.

# Features

-   Admin can create, update and delete products which will be shown in the shop page.
-   Users can see all the products and can do add to cart and make orders.
-   Users can also their orders list.

# How to install

#### Pre-requisite

XAMPP installed is the primary requisition.

#### Next-Steps

To install this app just download or clone the repository and open a terminal in the same folder directory and run the following commands one by one:

```
composer install
```

```
cp .env.example .env
```

```
php artisan key:generate
```

```
npm install
```

before running the following command configure the **DB_DATABASE** in .env file

```
php artisan migrate --seed
```

```
php artisan serve
```

```
npm run dev
```

**First of all login as admin the credentials are given in the admin login page. Then create some category, colors, sizes and products. Then login as user.**

Now enjoy the app. ❤
