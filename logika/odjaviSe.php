<?php

session_start();
session_destroy();

header('Location: ../stranice/prijava.php');