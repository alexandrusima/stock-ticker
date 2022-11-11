<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Services\Communication\Receivers\TickerReceiverInterface;

class CompanyController extends Controller
{
    private ?TickerReceiverInterface $receiver = null;
    private array $rules =  [
        'symbol' => [
            'required',
            'exists:companies,symbol'
        ],
        'start_date' => [
            'required',
            'date',
            'date_format:Y-m-d',
            'before_or_equal:today'
        ],
        'end_date' => [
            'required',
            'date',
            'date_format:Y-m-d',
            'after_or_equal:start_date'

        ],
        'email' => [
            'required',
            'email:rfc,dns'
        ]
    ];

    public function __construct(TickerReceiverInterface $receiver)
    {
        $this->receiver = $receiver;
    }

    public function index(Request $request)
    {
        $symbol = old('symbol', $request->get('symbol', 'ADES'));

        $company = Company::query()
            ->where('symbol', '=', $symbol)
            ->first();

        $tickerData = $this->receiver->fetch(
            [
                'symbol' => $symbol,
                'region' => 'US'
            ]
        );

        if ($request->isMethod('POST')) {
            $validated = $request->validate($this->rules);
            $tickerData = $this->filterData($tickerData, $validated['start_date'], $validated['end_date']);
        }

        return View::make(
            'welcome',
            [
                'company' => $company,
                'ticker' => $tickerData,
                'request' => $request,
                'validated' => $validated ?: [],
            ],
        );
    }

    private function filterData(array $tickerData, $startDate, $endDate)
    {
        $startDate = $startDate instanceof \DateTimeInterface ? $startDate :
            \DateTime::createFromFormat('Y-m-d', $startDate);
        $endDate = $endDate instanceof \DateTimeInterface ? $endDate :
            \DateTime::createFromFormat('Y-m-d', $endDate);

        return array_filter(
            $tickerData,
            function ($item) use ($startDate, $endDate) {
                if (empty($item) || !isset($item['x'])) {
                    return false;
                }

                return (float) $startDate->format('U') < $item['x']  &&
                    $item > (float) $endDate->format('U');
            }
        );
    }


    public function post(Request $request)
    {


        if ($request->isMethod('POST')) {
            $request->validate(
                $this->rules
            );
        }

        return redirect()->back()->withInput();
    }
}
