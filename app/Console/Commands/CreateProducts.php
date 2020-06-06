<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class CreateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create_products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create products';

    private $words = [];

    private $images = [];

    private $maxProducts = 55;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $timeStart = microtime(true);
        for ($i = 0; $i < $this->maxProducts; $i++) {
            $product = new Product();
            $product->fill([
                'name' => $this->generateName(),
                'description' => $this->generateDescription(),
                'price' => $this->generatePrice(),
                'availability' => $this->generateAvail(),
                'image' => $this->generateImage()
            ]);
            $product->save();
        }

        $diff = microtime(true) - $timeStart;
        $sec = intval($diff);
        $micro = $diff - $sec;
        dd("Time: " . round($micro * 1000, 4) . " ms");
    }

    private function generateName()
    {
        return $this->generateString(2, 4);
    }

    private function generateDescription()
    {
        return $this->generateString(10, 20);
    }

    private function generatePrice()
    {
        return rand(10, 10000);
    }

    private function generateAvail()
    {
        return rand(0, 1);
    }

    private function generateImage()
    {
        $images = $this->getImages();
        $key = array_rand($images);
        return $images[$key];
    }

    private function getImages()
    {
        if (!$this->images) {
            $path = storage_path('app/public/uploads');
            foreach (new \DirectoryIterator($path) as $fileInfo) {
                if ($fileInfo->isDot() || $fileInfo->isDir()) {
                    continue;
                }
                $this->images[] = $fileInfo->getBasename();
            }
        }
        return $this->images;
    }

    private function generateString($minCountWords, $maxCountWords)
    {
        $words = $this->getWords();
        $countWords = rand($minCountWords, $maxCountWords);
        $keys = array_rand($words, $countWords);
        $values = array_map(function ($key) use ($words) {
            return $words[$key];
        }, $keys);
        return Str::ucfirst(Str::lower(implode(' ', $values)));
    }

    private function getWords()
    {
        if (!$this->words) {
            $text = $this->clearText($this->getLorem());
            $exploded = explode(' ', $text);
            $this->words = array_filter($exploded, function ($value) {
                return !empty($value);
            });
        }
        return $this->words;
    }

    private function clearText($text)
    {
        $text = str_replace(["\n", "\r"], ' ', $text);
        return str_replace([',', '.', '!'], '', $text);
    }

    private function getLorem()
    {
        return 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip 
                ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
                mollit anim id est laborum';
    }
}
