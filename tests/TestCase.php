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
        $body = (string) ($email->getTextBody() ?: $email->getHtmlBody());
        $this->assertMatchesRegularExpression('/\b[0-9]{6}\b/', $body);
        preg_match('/\b[0-9]{6}\b/', $body, $matches);

        return $matches[0];
    }
}
