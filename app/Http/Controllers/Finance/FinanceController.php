<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Repositories\Finance\PayrollRepository;
use Illuminate\Http\Request;

class FinanceController extends Controller
{

    private $payrollRepository;

    public function __construct(PayrollRepository $payrollRepository) {

        $this->payrollRepository = $payrollRepository;

    }

    public function index() {

        return view('finance.payroll.index');

    }

    public function getPayrolls(Request $request) {

        $page = $request->page ? $request->page : 1;
        $count = $request->count ? $request->count : 10;
        $search = $request->search && $request->search != '' && $request->search !== 'null' ? $request->search : null;
        $date = $request->date ? $request->date : null;

        $params = [
            'page' => $page,
            'count' => $count,
            'search' => $search,
            'date' => $date,
        ];

        $payrolls = $this->payrollRepository->getPayrolls(json_decode(json_encode($params)));

        return response()->json($payrolls, 200);

    }

    public function storePayroll(Request $request) {

        $payrrol = $this->payrollRepository->storePayroll(json_decode(json_encode($request->all())));

        return response()->json($payrrol, 200);

    }

    public function generatePayroll(Request $request) {

        $payroll = $this->payrollRepository->generatePayroll(json_decode(json_encode($request->all())));

        return response()->json($payroll, 200);

    }
}
