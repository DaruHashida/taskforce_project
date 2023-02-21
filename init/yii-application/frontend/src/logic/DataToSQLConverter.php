<?php


namespace src\logic;

class DataToSQLConverter
{
    public string $sql_data;
    private string $directory_path;
    function __construct(string $directory_path)
    {
        $this->directory_path = $directory_path;
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
        var_export($filenames);
        $filenames = array_diff($filenames, ['.', '..']);
        echo($filenames);
        /*foreach ($filenames as $filename) {
            $path = sprintf($this->directory_path, $filename);
            #echo($path);
            #$csvappendix = strripos($filename, '.csv');
            #echo($csvappendix);*/
            /* $file = new SplFileObject($path, "r");
               $tablename = substr($filename,$csvappendix,4);
               $k = 0;
               $keys = [];
               $types = [];
               $data = [];
               while (!$file->eof()) {
                   $k++;
                   // get the current line
                   $line = $file->fgets();
                   if ($k === 1) {
                       $keys = explode(',', $line);
                       foreach ($keys as $key) {
                           array_merge($types, array($key =>
                               ['type' => '',
                                   'biggest_number' => 0,
                                   'lowest_number' => 0,
                                   'negate_nums' => false]));
                       }
                   } else {
                       $values = explode(',', $line);
                       array_push($data,'('.$line.'), ');
                       for ($i = 0; $i < count($keys); $i++) {
                           $key = $keys[$i];
                           $value = $values[$i];
                           array_push($$key, $values[$i]);
                           $types = $this->typeSelector($key, $value, $types);
                       }
                   }
               }
               $columns = '';
               $columnsWithTypes = '';
               for ($i=0; $i<count($keys); $i++) {
                   if ($i != 0) {
                       $columns = $columns . ', ';
                       $columnsWithTypes = $columnsWithTypes.', ';
                   }
                   $columns = $columns . $keys[$i];
                   $columnsWithTypes = $columnsWithTypes.' '.$types[$keys[$i]];
               }
               $this->sql_data = "USE taskforce;
               CREATE TABLE $tablename
               ($columnsWithTypes);";

               $this->sql_data = $this->sql_data."INSERT INTO $tablename ($columns) VALUES $data;";
           }*/
        return ($filenames);
    }

        private function typeSelector ($key, $value, $types)
        { $type = &$types[$key]['type'];
          $biggest_number = &$types[$key]['biggest_number'];
          $lowest_number = &$types[$key]['lowest_number'];
          $negate_nums = &$types[$key]['negate_nums'];
            if (!(strripos($type,'VARCHAR')) && is_numeric($value))
            {
            $length = strlen($value);
            if (ctype_digit($value)) {
                if ($value > $biggest_number) {
                    if (!$negate_nums) {
                        $biggest_number = (int)$value;
                        if ($biggest_number < 256) {
                            $type[$key] = 'TINYINT';
                        } elseif ($biggest_number < 65536) {
                            $type[$key] = 'SMALLINT';
                        } elseif ($biggest_number < 16777216) {
                            $type[$key] = 'MEDIUMINT';
                        } elseif ($biggest_number < 4294967296) {
                            $type[$key] = 'INT';
                        } else {
                            $type[$key] = 'BIGINT';
                        }
                    }
                    else
                    {
                        $biggest_number = (int)$value;
                        if ($biggest_number < 128) {
                            $type[$key] = 'TINYINT';
                        } elseif ($biggest_number < 32768) {
                            $type[$key] = 'SMALLINT';
                        } elseif ($biggest_number < 8388608) {
                            $type[$key] = 'MEDIUMINT';
                        } elseif ($biggest_number < 2147483648) {
                            $type[$key] = 'INT';
                        } else {
                            $type[$key] = 'BIGINT';
                        }
                    }
                }
                elseif (0<strripos($value,'.') and strripos($value,'.')<($length-1))
                { $type[$key]='DOUBLE';}
                elseif (strripos($value,'-') == 0)
                {   $negate_nums = true;
                    if ($value < $lowest_number) {
                        $lowest_number = (int)$value;
                        if ($lowest_number > -128) {
                            $type[$key] = 'TINYINT';
                        } elseif ($lowest_number > -32768) {
                            $type[$key] = 'SMALLINT';
                        } elseif ($lowest_number > -8388608) {
                            $type[$key] = 'MEDIUMINT';
                        } elseif ($lowest_number > -2147483648) {
                            $type[$key] = 'INT';
                        } else {
                            $type[$key] = 'BIGINT';
                        }
                    }
                }
            }
            /**
             * ЕСЛИ ЭТО НЕ ЧИСЛО
             */
            else {
                if ($length > 65535) {
                    $type = 'MEDIUMTEXT';
                } elseif ($length > 16777215) {
                    $type = 'LONGTEXT';
                } else
                {
                    if (strripos($type, 'VARCHAR')) {
                        $varchar_value = substr(substr($type, 0, 8), -1,1);
                    } else {
                        $varchar_value = 0;
                    }
                    if ($length > $varchar_value) {
                        $type = 'VARCHAR(' . $length . ')';
                    }
                }
                }
        }
            return $types;
        }

        }