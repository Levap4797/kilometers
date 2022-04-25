<?php

namespace App\Services;

use App\Interfaces\GenerationInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class GenerationXLS implements GenerationInterface
{
    /** @var string[]  */
    protected $excludeFields = ['user_id'];

    public function generate(array $data): string
    {
        $pathToFile = storage_path('hello world' . auth()->id() . 'xlsx');
        if (file_exists($pathToFile)) {
            @unlink($pathToFile);
        }
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $array = [
            0 => []
        ];
        $id = 1;
        foreach ($data as $object) {
            foreach ($object as $key => $value) {
                if (in_array($key, $this->excludeFields, true)) {
                    continue;
                }
                if (!in_array($key, $array[0], true)){
                    $array[0][] =  $key;
                }
                $array[$id][] = $value;
            }
            ++$id;
        }

        $spreadsheet->getActiveSheet()
            ->fromArray(
                $array,
                NULL,
                'A3'
            );

        $writer = new Xlsx($spreadsheet);
        $writer->save($pathToFile);

        return $pathToFile;
    }
}
