<?php

namespace App\Events\Tags;

use App\Models\Tag;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class TagFinished
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \App\Models\Tag */
    public $tag;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Tag  $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }
}
