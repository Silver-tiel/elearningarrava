<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Mail;

abstract class TestCase extends BaseTestCase
{
    protected function latestRegistrationCode(): string
    {
        $transport = Mail::mailer('array')->getSymfonyTransport();
        $email = $transport->messages()->last()->getOriginalMessage();
        $this->assertMatchesRegularExpression('/\b[0-9]{6}\b/', $email->getTextBody());
        preg_match('/\b[0-9]{6}\b/', $email->getTextBody(), $matches);

        return $matches[0];
    }
}
