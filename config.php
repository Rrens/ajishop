<?php
$db = mysqli_connect("localhost", "root", "", "baju");
(!$db) ? "Erorr di " . mysqli_connect_error() : null;
