<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        // Tutaj normalnie byłaby integracja z płatnościami
        // My zrobimy tylko prosty komunikat

        return redirect()->back()->with('success', 'Płatność została zrealizowana! 🎉');
    }
}
