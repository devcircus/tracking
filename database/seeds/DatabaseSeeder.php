<?php

use App\Models\Tag;
use App\Models\InventoryItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $items = factory(InventoryItem::class, 20)->create();

        foreach ($items as $item) {
            factory(Tag::class, rand(4, 12))->create(['item_id' => $item->id]);
        }
    }
}
