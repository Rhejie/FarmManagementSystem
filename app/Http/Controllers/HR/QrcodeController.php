<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QrcodeController extends Controller
{
    public function __construct() {

    }

    public function index() {

        return view('HR.qrcode.index');

    }
}
