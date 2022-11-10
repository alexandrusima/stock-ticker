<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $companies = Company::query()
            ->paginate(
                $request->get('perPage', 5),
                ['id', 'symbol', 'name'],
                'page',
                $request->get('page', 1)
            );

        $companies->useBootstrapFive();

        return View::make(
            'welcome',
            [
                'companies' => $companies
            ]
        );
    }
}
