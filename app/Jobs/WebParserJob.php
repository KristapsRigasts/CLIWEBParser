<?php

namespace App\Jobs;

use DOMDocument;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;

class WebParserJob
{
    use Dispatchable, SerializesModels;

    private DOMDocument $domDocument;
    private string $tag;
    private string $attribute;
    private array $allValues;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DOMDocument $domDocument, string $tag, string $attribute)
    {
        $this->domDocument = $domDocument;
        $this->tag = $tag;
        $this->attribute = $attribute;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $getTags = $this->domDocument->getElementsByTagName($this->tag);

        foreach ($getTags as $tag) {
            if (!empty($tag->getAttribute($this->attribute))) {
                $this->allValues[$this->tag][] = $tag->getAttribute($this->attribute);
            }
        }

        if (file_exists('output.json')) {
            $readDataFromJson = file_get_contents('output.json');
            $dataFromJsonFile = json_decode($readDataFromJson, true);
            $addDataToJson = array_merge($dataFromJsonFile,$this->allValues);
            $createJson = json_encode($addDataToJson, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }
        else {
            $createJson = json_encode($this->allValues, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }
            file_put_contents("output.json", $createJson );
    }
}
