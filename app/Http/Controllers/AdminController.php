<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Wyświetla dashboard administratora
     */
    public function dashboard()
    {
        return view('admin.dashboard'); // zakładamy, że masz widok w resources/views/admin/dashboard.blade.php
    }
}
