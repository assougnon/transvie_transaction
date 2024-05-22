<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TransactionCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $transaction ;

    public $message;

    /**
     * Create a new event instance.
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction ;
        $this->message = "Transaction Nº {$transaction->numero} crée";
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('transaction-created'),
        ];
    }
  /**
   * The event's broadcast name.
   */
  public function broadcastAs(): string
  {
    return 'transaction.created';
  }
}
