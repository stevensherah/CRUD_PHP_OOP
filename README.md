## **PHP CRUD Example using OOP with Bootstrap**

In this instruction, keeping in mind Bootstrap framework CRUD Example, I will examine a simple database application with a PHP Object Oriented concept. In order to do that, I have applied here Bootstrap framework for front-end design and the MySQL database operations. The aim of this instruction is to provide the best PHP Object Oriented CRUD Example for beginners. 

The CRUD grid makes possible for users to create/read/update/delete data. Normally data is stored in MySQL Database. PHP will act as the server-side language, which enables to establish the contact with backend MySQL Database and control MySQL Database tables to support front-end users power to perform CRUD actions.

The following chapters will be included in PHP and MySQL instruction.

--
### **Creating a Database table Users and Categories**

I will deal with a simple Database table that you can see below. By taking this Database table as an example, you can generate CRUD on your database and implement this in your phpMyAdmin.

```mysql
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `mobile` varchar(30) CHARACTER SET utf8 NOT NULL,
  `category_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
```
As categories, I will take „Students“, „Pensioners“, „Employees“ and „Unemployed“  in the example.

```mysql
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
```


