<?php
// =============================================
// index.php — Entry Point
// =============================================
require_once 'config.php';

if (isLoggedIn()) {
    redirect('forum.php');
} else {
    redirect('login.php');
}
