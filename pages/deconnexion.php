<?php
require_once 'functions/session.php';
Session::destroy();
header('Location:index.php?page=home');
