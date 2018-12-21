<?php
/**
 * Created by PhpStorm.
 * User: Sarfraz
 * Date: 12/6/2018
 * Time: 11:27 PM
 *
 * Example Usage in below comment:
 */

//    class ExampleImporter extends CoreImport
//    {
//        protected static $mappings = [
//            'column_name_in_csv' => 'column_name_in_db_table',
//        ];
//
//        public function import()
//        {
//            foreach ($this->getRow() as $row) {
//                $model = Customer::firstOrNew(['email' => $row['email']]);
//
//                $model->fill($row);
//
//                if (!$model->save()) {
//                    $this->setFailedRowReason($model->errors()->all(), $row);
//                }
//            }
//        }
//    }

namespace Modules\Core\Importer;

use Illuminate\Support\Facades\DB;

abstract class CoreImport
{
    protected static $csvPath = '';
    protected static $deleteProcessedFile = false;

    protected static $header = [];
    protected static $totalRows = 0;
    protected static $failedRows = [];

    protected static $chunkSize = 500;

    protected static $mappings = [];

    abstract public function import();

    public function __construct(string $csvPath, $deleteProcessedFile = false)
    {
        // memory stuff
        ini_set('memory_limit', '-1');
        ini_set('max_input_time', '-1');
        ini_set('max_execution_time', '0');
        set_time_limit(0);

        // query optimization
        DB::disableQueryLog();

        static::$csvPath = $csvPath;
        static::$deleteProcessedFile = $deleteProcessedFile;
    }

    /**
     * Gets all rows from CSV file
     *
     * @return \Generator
     * @throws \Exception
     */
    protected function getRow(): \Generator
    {
        if (!file_exists(static::$csvPath)) {
            throw new \RuntimeException(static::$csvPath . ' not found');
        }

        $rows = array_map('str_getcsv', file(static::$csvPath));

        array_walk($rows, function (&$a) use ($rows) {
            $a = array_combine($rows[0], $a);
        });

        static::$header = $rows[0];

        # remove header row since we added it as keys
        array_shift($rows);

        static::$totalRows = count($rows);

        # apply csv --> db column name mappings
        $rows = $this->applyMappings($rows);

        yield from $rows;
    }

    /**
     * Normalizes CSV header names into DB table names
     *
     * @param $rows
     * @return mixed
     */
    protected function applyMappings($rows)
    {
        if (static::$mappings) {
            foreach ($rows as &$row) {
                foreach (static::$mappings as $key => $mapping) {
                    if (!array_key_exists($key, $row)) {
                        continue;
                    }

                    $keys = array_keys($row);
                    $keys[array_search($key, $keys, true)] = $mapping;
                    $row = array_combine($keys, $row);
                }
            }
        }

        return $rows;
    }

    /**
     * Add extra columns to fail CSV that gets generated.
     * Call this function in error/validation handler to create
     * failed CSV if needed.
     *
     * @param $messages
     * @param $row
     * @return array
     */
    protected function setFailedRowReason($messages, $row): array
    {
        if (!is_array($messages)) {
            $messages = [$messages];
        }

        $messages = implode(' | ', array_values($messages));

        # remove custom added columns
        $row = array_slice($row, 0, count(static::$header));

        $row[] = '[' . $messages . ']';

        static::$failedRows[] = $row;

        return static::$failedRows;
    }

    /**
     * write CSV for any failed rows
     */
    protected function writeFailedCsvFile()
    {
        if (count(static::$failedRows)) {
            $fileName = basename(static::$csvPath);
            $failedDir = dirname(static::$csvPath) . DIRECTORY_SEPARATOR . 'failed';

            @mkdir($failedDir, 0700);

            $path = $failedDir . DIRECTORY_SEPARATOR . $fileName;

            $csv = fopen($path, 'wb');

            fputcsv($csv, static::$header);

            foreach (static::$failedRows as $row) {
                fputcsv($csv, $row);
            }

            fclose($csv);
        }
    }

    /**
     * Returns results of import.
     */
    public function getResults(): array
    {
        $this->writeFailedCsvFile();

        if (static::$deleteProcessedFile) {
            @unlink(static::$csvPath);
        }

        return [
            'total' => static::$totalRows,
            'pass' => static::$totalRows - count(static::$failedRows),
            'fail' => count(static::$failedRows),
        ];
    }
}
