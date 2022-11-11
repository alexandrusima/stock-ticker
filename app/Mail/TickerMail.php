<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class TickerMail extends Mailable
{
    use Queueable, SerializesModels;


    public $to;

    private ?string $symbol;
    private ?Company $company;
    private array $ticker = [];

    private $startDate;
    private $endDate;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email, string $symbol, ?Company $company, array $ticker, $startDate, $endDate)
    {
        $this->symbol = $symbol;
        $this->company = $company;
        $this->ticker = $ticker;

        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->email = $email;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: strtr('[{symbol}] Ticker Mail {companyName}', [
                '{symbol}' => $this->symbol,
                '{companyName}' => $this->company->name ?? '',
            ])
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'emails.ticker',
            with: [
                'symbol' => $this->symbol ?? '',
                'startDate' => \DateTime::createFromFormat('Y-m-d', $this->startDate),
                'endDate' => \DateTime::createFromFormat('Y-m-d', $this->endDate),
                'company' => $this->company,
                'ticker' => $this->ticker,
            ]
        );
    }

    public function build()
    {
        $this->to($this->email)->subject(strtr('[{symbol}] Ticker Mail {companyName}', [
            '{symbol}' => $this->symbol,
            '{companyName}' => $this->company->name ?? '',
        ]));

        return $this;
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
