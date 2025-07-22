<?php

namespace App\Dto;

use App\Models\Contact;
use App\Models\Message;
use App\Options\WhatsAppMessageType;

class WhatsAppMessage
{
    public ?Contact $contact = null;
    public ?Message $message = null;
    public array $responses = [];

    public int $timestamp {
        get => $this->request['timestamp'];
    }

    public string $contactPhone {
        get => $this->request['contact']['phone'];
    }

    public string $contactName {
        get => $this->request['contact']['displayName'];
    }

    public string $messageId {
        get => $this->request['object']['id'];
    }

    public WhatsAppMessageType $messageType {
        get => WhatsAppMessageType::tryFrom($this->request['object']['type']);
    }

    public array $payload {
        get => $this->request['payload'];
    }

    public function __construct(
        public array $request
    ) {}

    public function withContact(Contact $contact)
    {
        $this->contact = $contact;
        return $this;
    }

    public function saveIncomeMessage()
    {
        if (!is_null($this->contact)) {
            $this->message = Message::create([
                'wamid' => $this->messageId,
                'direction' => 'inbound',
                'payload_type' => 'message',
                'contact_id' => $this->contact->id,
                'payload' => $this->request,
            ]);
        }

        return $this;
    }

    public function getTextMessage(): ?string
    {
        return (string) $this->request['payload']['body'] ?? null;
    }

    public function getFileUrl(): ?string
    {
        return $this->request['payload']['url'] ?? null;
    }

    public function getFileMimeType(): ?string
    {
        return $this->request['payload']['mimeType'] ?? null;
    }

    public function getFileSize(): ?string
    {
        return $this->request['payload']['fileSize'] ?? null;
    }

    public function getClickedButtonValue(): ?string
    {
        return (string) $this->request['payload']['id'] ?? null;
    }

    public function getLocation(): array
    {
        $latitude = $this->request['payload']['latitude'];
        $longitude = $this->request['payload']['longitude'];

        return [$latitude, $longitude];
    }
}
