<?php

namespace App\Heybot;

use App\Models\Contact;
use App\Models\Message;
use Carbon\Carbon;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Str;

class Botman extends Heybot
{
    public int $messagesSent = 0;

    public $messageList = [];

    public function saveIncomeMessage(Contact $contact, array $request)
    {
        return Message::create([
            'direction' => 'inbound',
            'payload_type' => 'message',
            'contact_id' => $contact->id,
            'payload' => $request,
        ]);
    }

    /**
     * @throws ConnectionException
     */
    public function sendMessage($message)
    {
        $this->messagesSent++;
        $message = $message->toArray();
        $this->messageList[] = $message;

        return $this->__send($message);
    }

    /**
     * @throws ConnectionException
     */
    public function sendManyMessages(array $messages)
    {
        $data = [];

        foreach ($messages as $message) {
            $data[] = $message->toArray();
            $this->messagesSent++;
        }

        $this->messageList = array_merge($this->messageList, $data);

        return $this->__bulkSend($data);
    }

    public function saveReplyMessagesTo(Contact $contact)
    {
        $ts = Carbon::now()->timestamp;

        $data = collect($this->messageList)->map(function ($message) use ($ts, $contact) {

            $event = array_merge($message, [
                'timestamp' => $ts,
                'event' => 'message',
                'contact' => [
                    'phone' => null,
                    'displayName' => null,
                ],
                'object' => [
                    'type' => 'text',
                    'id' => null,
                ],
            ]);

            return [
                'ulid' => Str::ulid()->toString(),
                'contact_id' => $contact->id,
                'direction' => 'outbound',
                'payload_type' => 'message',
                'payload' => json_encode($event),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ];
        });

        Message::insert($data->toArray());
    }
}
