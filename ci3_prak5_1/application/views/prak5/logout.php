<?php
// =============================================
// logout.php — Keluar & Hapus Session
// =============================================
require_once 'config.php';

$_SESSION = [];
session_destroy();

redirect('login.php');
