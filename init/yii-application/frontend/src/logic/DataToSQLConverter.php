<?php


namespace src\logic;
use SplFileObject;

class DataToSQLConverter
{
    public string $sql_data;
    private string $directory_path;
    function __construct(string $directory_path)
    {
        $this->directory_path = $directory_path;
        $this->sql_data = '';
        foreach ($this->getData($directory_path) as $data)
        {$this->sql_data = $this->sql_data.$data;
        }
    }

    /*protected function loadCsvFiles(string $directory)
    {foreach(newDirectoryIterator($directory)) as $file)
        { if ($file->getExtention() == 'csv') {
        $this->filesToConvert[] = $file->getFileInfo();
        }
        }*/


    public function getData ()
    {
        $filenames = scandir($this->directory_path, SCANDIR_SORT_DESCENDING);
        $filenames = array_diff($filenames, ['.', '..']);
        foreach ($filenames as $filename) {
            $path = $this->directory_path . '/' . $filename;
            $file = new SplFileObject($path, "r");
            $tablename = substr($filename, 0, -4);
            $k = 0;
            $keys = [];
            $types = [];
            $data = '';
            while (!$file->eof()) {
                $k++;
                $line = rtrim($file->fgets());
                if ($k == 1) {
                    $keys = explode(',', $line);
                    foreach ($keys as $key) {
                        $types = array_merge($types, array($key =>
                            ['type' => '',
                                'biggest_number' => 0,
                                'lowest_number' => 0,
                                'negate_nums' => false,
                                'longest_value' => 0]));
                        $$key = [];
                    }
                    $types = array_shift($types);
                } else {
                    $values = explode(',', $line);
                    for ($i = 0; $i < count($keys); $i++) {
                        $key = $keys[$i];
                        $value = &$values[$i];
                        array_push($$key, $value);
                        $types = $this->typeSelector($key, $value, $types);
                        if (!is_numeric($value))
                        {
                            $value = "'".$value."'";
                        }

                    }
                    $line = implode(',', $values);
                    $data = $data . '(' . $line . '), ';
                }
            }
            $columns = '';
            $columnsWithTypes = '';
            for ($i = 0; $i < count($keys); $i++) {
                if ($i != 0) {
                    $columns = $columns . ', ';
                    $columnsWithTypes = $columnsWithTypes . ', ';
                }
                $columns = $columns."`".$keys[$i]."`";
                $columnsWithTypes = $columnsWithTypes ."`". $keys[$i] ."`". ' ' . $types[$keys[$i]]['type'];
            }
            $sql_data = "USE taskforce; 
            CREATE TABLE `$tablename`
            ($columnsWithTypes);";

            $sql_data = $sql_data . "INSERT INTO $tablename ($columns) VALUES $data;";
            yield ($sql_data);
        }
    }

        private function typeSelector ($key, $value, $types)
        { $type = &$types[$key]['type'];
          $biggest_number = &$types[$key]['biggest_number'];
          $lowest_number = &$types[$key]['lowest_number'];
          $negate_nums = &$types[$key]['negate_nums'];
          $longest_value = &$types[$key]['longest_value'];
          $length = strlen($value);
            if (!(strripos($type??'','VARCHAR')) && is_numeric($value)) {
                if (ctype_digit($value)) {
                    if ($value > $biggest_number) {
                        if (!$negate_nums) {
                            $biggest_number = (int)$value;
                            if ($biggest_number < 256) {
                                $type = 'TINYINT';
                            } elseif ($biggest_number < 65536) {
                                $type = 'SMALLINT';
                            } elseif ($biggest_number < 16777216) {
                                $type = 'MEDIUMINT';
                            } elseif ($biggest_number < 4294967296) {
                                $type = 'INT';
                            } else {
                                $type = 'BIGINT';
                            }
                        } else {
                            $biggest_number = (int)$value;
                            if ($biggest_number < 128) {
                                $type = 'TINYINT';
                            } elseif ($biggest_number < 32768) {
                                $type = 'SMALLINT';
                            } elseif ($biggest_number < 8388608) {
                                $type = 'MEDIUMINT';
                            } elseif ($biggest_number < 2147483648) {
                                $type = 'INT';
                            } else {
                                $type = 'BIGINT';
                            }
                        }
                    }
                }
                elseif (0 < strripos($value, '.') and strripos($value, '.') < ($length - 1)) {
                        $type = 'DOUBLE';
                    }
                elseif (strripos($value, '-') == 0) {
                        $negate_nums = true;
                        if ($value < $lowest_number) {
                            $lowest_number = (int)$value;
                            if ($lowest_number > -128) {
                                $type = 'TINYINT';
                            } elseif ($lowest_number > -32768) {
                                $type = 'SMALLINT';
                            } elseif ($lowest_number > -8388608) {
                                $type = 'MEDIUMINT';
                            } elseif ($lowest_number > -2147483648) {
                                $type = 'INT';
                            } else {
                                $type = 'BIGINT';
                            }
                        }
                    }
                }
            /**
             * ЕСЛИ ЭТО НЕ ЧИСЛО
             */
            else {
                $value = "'".$value."'";
                if ($length > 65535) {
                    $type = 'MEDIUMTEXT';
                } elseif ($length > 16777215) {
                    $type = 'LONGTEXT';
                } else
                {
                    if (strripos($type??'', 'CHAR') != false) {
                        if (iconv_strlen($value) > $longest_value) {
                            $longest_value = iconv_strlen($value);
                            $type = 'VARCHAR(' . $longest_value . ')';
                        }
                    }
                    else {
                        $type = 'VARCHAR(' . $length . ')';
                    }
                }
                }

            return $types;
        }

        }