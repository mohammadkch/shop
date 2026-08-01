<?php

namespace App\Libraries\Sms;

use JsonException;

class SmsAuditLogger
{
    private const ALLOWED_FIELDS = [
        'request_id',
        'mobile_masked',
        'mobile_format',
        'template_id',
        'parameter_name',
        'endpoint',
        'http_status',
        'provider_status',
        'provider_message',
        'message_id',
        'cost',
        'error',
        'exception',
        'code_length',
    ];

    public function __construct(private readonly bool $enabled = true)
    {
    }

    public function write(string $event, array $context = []): void
    {
        if (! $this->enabled) {
            return;
        }

        $safeContext = array_intersect_key($context, array_flip(self::ALLOWED_FIELDS));
        $record = array_merge([
            'timestamp' => date('c'),
            'event' => $event,
        ], $safeContext);

        try {
            $line = json_encode($record, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            $line = json_encode([
                'timestamp' => date('c'),
                'event' => 'audit_encoding_failed',
            ]);
        }

        $path = WRITEPATH . 'logs' . DIRECTORY_SEPARATOR . 'sms-' . date('Y-m-d') . '.log';
        $written = @file_put_contents($path, $line . PHP_EOL, FILE_APPEND | LOCK_EX);

        if ($written === false) {
            // Critical is visible even with the project's current logger.threshold=3.
            log_message('critical', 'SMS audit log could not be written to the writable logs directory.');
        }
    }
}
