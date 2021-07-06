# Тема: Система, визуализираща финални надписи и реферати
### Предмет: Приложно-програмни интерфейси за работа с облачни архитектури с Амазон Уеб Услуги (AWS) 
### Изготвил: Радина Динева, ФН: 62179, имейл: rdineva@mail.bg
### Лектор: доц. Милен Петров, година: 2021

---
### Съдържание
#### Условие
#### Въведение
#### Използвани технологии
#### Инсталация и настройки
#### Кратко ръководство на потребителя 
#### Примерни данни 
#### Описание на програмния код 
#### Приноси на студента, ограничения и възможности за бъдещо разширение 
#### Какво научих
#### Използвани източници
---

## Условие
Приложението е система, която визуализира надписи и реферати тип "star wars". 

## Въведение
Приложението е качено на AWS EC2 сървър. На сървъра има MySQL база данни, в която се пази информация за качените файлове - тип и име. Приложението може да се достъпва през съответният URL на EC2 инстанцията. Потребител може да качва реферати или финални надписи, след което те да се визуализират под формата на анимация тип "star wars". Информацията (типа и името) на файловете, които потребителят избира да качи, се запазват в MySQL базата на EC2 сървъра. Докато самите файлове се запазват в S3 bucket. 

Системата поддържа възможност за качване на:
 1. текстов файл 
 2. архиви със съдържание реферати  съдържащи в себе си html, css, js файлове и снимки

При качване на файл системата проверява по име на файла дали такъв вече е добавен. Не се позволява качването на еднакви файлове.
При качване на файлове има възможност да се избере стилизация на анимацията с контроли за цвят на текста, на фона, шрифт, скоростта на възпроизвеждане и типа на анимацията - линейна или star wars.
Системата поддържа списък на качени файлове, откъдето може да се пуска предишно качен файл. Файловете могат да се филтрират по тип - кредити или реферат.
Системата поддържа търсене на файлове във вече качените. Има възможност за въвеждане на текст, според който се показват файловете, чиито имена го съдържат.
Основна функционалност на системата е пускането на кредити/реферат под формата на анимация, с която се визуализира и може да се чете съдържанието им. Поддържат се два вида анимации. Има възможност за паузиране и пускане на анимацията.

## Използвани технологии
### AWS
* EC2
* S3
* AWS S3 SDK for PHP

### DEV
* PHP - сървърна част
* SQL - база данни
* HTML5 - за семантично маркиране на текста
* CSS - стилизация
* JavaScript - динамични изчисления и event listeners

## Инсталация и настройки
```bash
# Инсталиране на Apache web server
$ yum install httpd 
$ service httpd start

# Инсталиране на PHP и клониране на проекта от гитхъб
$ sudo amazon-linux-extras install php7.2
$ service httpd restart
$ git clone <repo_name>

# Инсталиране на MySQL Server
$ yum update
$ wget https://dev.mysql.com/get/mysql57-community-release-el7-9.noarch.rpm
$ md5sum mysql57-community-release-el7-9.noarch.rpm
$ sudo rpm -ivh mysql57-community-release-el7-9.noarch.rpm
$ sudo yum install mysql-server

# Кoнфигуриране и стартиране на MySQL server
$ chkconfig mysqld on
$ systemctl start mysqld.service
$ systemctl status mysqld.service

# Взимане на дефолтната парола за базата
$ sudo grep 'temporary password' /var/log/mysqld.log

# Настройване на MySQL
$ mysql_secure_installation 
$ sudo systemctl restart mysqld.service

# Създаване на база данни и таблица
$ mysql -u root -p
> CREATE DATABASE mediadb;
> USE mediadb;
> CREATE TABLE Files (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `name` VARCHAR(50) NOT NULL UNIQUE,
                `type` VARCHAR(10) NOT NULL,
                created_on DATETIME DEFAULT CURRENT_TIMESTAMP
              );
              
# Сваляне на AWS S3 SDK for PHP пакета
$ wget https://docs.aws.amazon.com/aws-sdk-php/v3/download/aws.phar
```

## Кратко ръководство на потребителя 
На началната страница потребителя има достъп до всички функционалности на системата. 
![main](../images/main.png "Main Screen")

Може да избере дали иска да качи файл или да разгледа вече наличните файлове - тези функционалности се достъпват и от основното меню и от съдържанието на началната страница. 
След избирането на опция за качване потребителя бива поставен пред избор за типа на файла, който иска да добави - текстов или реферат. 

С направата на този избор бива пренасочен към страница, където може да качи файла си. За текстови файлове ограничението е да са в doc, docx или txt формат. За реферати ограничението е да са в zip формат.
![upload](../images/upload.png "Upload")

Ако потребителя избере да разгледа вече съществуващи файлове му се предоставя списък от качените файлове с пояснение от какъв тип са и кога са качени.

При клик на името на файла потребителя е пренасочен към страница за избор на опциите за анимацията. Потребителя достъпва същата страница и при успешно качване на файл. 

След избор на опциите за анимацията тя бива зареждана на нова страница с възможност за спиране и пускане.
![controls](../images/controls.png "Controls")

Потребителя може да търси по име на файл, което се осъществява от основното меню на сайта. Налични са линкове само към кредити и само към реферати.
![animation](../images/visual.png "Animation")

## Примерни данни 
Входни данни на приложението са файлове във формати doc, docx и txt при избор за качване на кредити. Системата приема и архив във формат zip при избор за качване на реферат. 

## Описание на програмния код 
Програмният код се състои от файлове с основните функционалности на системата:
* index.php - основна страница с възможност за избиране на действие - качване на файл или разглеждане на списък от всички файлове
* upload-choose.php - избиране на тип качване (кредити или реферат)
* upload.php - качване на файлове в S3 bucket според избрания тип - кредити (doc, docx, txt) или реферат (zip)
* read.php - функции за сваляне на файлове от S3 bucket,  четене на различните видове файлове и извличане на информацията от тях
* list.php - визуализиране на списък с всички качени файлове
* controls.php -  изглед и функционалност за въвеждане на css настройки за анимацията
* viewer.php - анимация, която визуализира текст от файл - кредити и реферат 
* database.php - клас, който предоставя възможност за връзка с базата данни.
* header.php - общ за всички страници header файл, който съдържа и навигационен бар
* footer.php - общ за всички страници footer файл
* /css/style.css - css файл за стилизация на приложението
* /images - папка с иконки, използвани в приложението
* /js - функционалност, с която се контролира визуализацията на кредитите/реферата
    
## Приноси на студента, ограничения и възможности за бъдещо разширение 
Като бъдещо разширение може да бъде добавено изтриване на файл с надписи или реферат, да се премахва от MySQL базата и от S3 бъкета. Може да се разшири и с модифициране на съдържанието на текстовите файлове в текстов редактор. 

## Какво научих
Научих се да създавам и конфигурирам MySQL база данни в EC2. Научих се как с помощта на AWS S3 SDK-to за PHP да качвам и да свалям обекти от S3 bucket.  

## Използвани източници
[1] [AWS S3 SDK for PHP  Docs](https://docs.aws.amazon.com/aws-sdk-php/v2/guide/index.html) - документация за работа с S3 на PHP

[2] [Tutorial: Install a LAMP web server on Amazon Linux 2](https://docs.aws.amazon.com/AWSEC2/latest/UserGuide/ec2-lamp-amazon-linux-2.html) - създаване на PHP сървър в EC2

