<?php
$pdo = new PDO("mysql:host=localhost;dbname=phpcrud;port:3306", 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
