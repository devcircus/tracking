<?php

use App\Models\Color;
use App\Models\Fabric;
use App\Models\Ink;
use App\Models\Tag;
use App\Models\InventoryItem;
use App\Models\Printer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedInventory();

        $this->seedInks();
        $this->seedPrinters();
        $this->seedColors();
        $this->seedFabrics();
    }

    /**
     * Seed the inventory.
     *
     * @return void
     */
    private function seedInventory(): void
    {
        $items = factory(InventoryItem::class, 20)->create();

        foreach ($items as $item) {
            factory(Tag::class, rand(4, 12))->create(['item_id' => $item->id]);
        }
    }

    /**
     * Seed inks.
     */
    private function seedInks(): void
    {
        factory(Ink::class)->create([
            'manufacturer' => 'Gans',
            'version' => 'G8',
            'type' => 'standard'
        ]);
        factory(Ink::class)->create([
            'manufacturer' => 'Axiom',
            'version' => 'ADSV4',
            'type' => 'standard',
        ]);
        factory(Ink::class)->create([
            'manufacturer' => 'Gans',
            'version' => 'G2',
            'type' => 'standard',
        ]);
        factory(Ink::class)->create([
            'manufacturer' => 'Gans',
            'version' => 'G2',
            'type' => 'neon',
        ]);
    }

    /**
     * Add printers to the database.
     */
    private function seedPrinters(): void
    {
        factory(Printer::class)->create([
            'name' => 'Printer 1',
            'model' => 'JV33',
            'manufacturer' => 'Mimaki',
            'ink_id' => Ink::where('type', 'neon')->where('version', 'G2')->first()->id,
        ]);

        factory(Printer::class)->create([
            'name' => 'Printer 2',
            'model' => 'JV33',
            'manufacturer' => 'Mimaki',
            'ink_id' => Ink::where('type', 'standard')->where('version', 'G2')->first()->id,
        ]);

        factory(Printer::class)->create([
            'name' => 'Printer 3',
            'model' => 'JV150',
            'manufacturer' => 'Mimaki',
            'ink_id' => Ink::where('type', 'standard')->where('version', 'G8')->first()->id,
        ]);

        factory(Printer::class)->create([
            'name' => 'Printer 4',
            'model' => 'JV150',
            'manufacturer' => 'Mimaki',
            'ink_id' => Ink::where('type', 'standard')->where('version', 'ADSV4')->first()->id,
        ]);
    }

    /**
     * Seed colors.
     */
    private function seedColors(): void
    {
        $colors = factory(Color::class, 40)->create();
        $printers = Printer::all();

        foreach($colors as $color) {
            foreach($printers as $printer) {
                if ($printer->ink->type === $color->type) {
                    $color->printers()->attach($printer->id, [
                        'cyan' => rand(0, 100),
                        'magenta' => rand(0, 100),
                        'yellow' => rand(0, 100),
                        'black' => rand(0, 100),
                        'approved' => $color->id % 4 === 0 ? false : true,
                    ]);
                }
            }
        }
    }

    /**
     * Seed fabrics.
     */
    private function seedFabrics(): void
    {
        factory(Fabric::class, 20)->create();
    }
}
