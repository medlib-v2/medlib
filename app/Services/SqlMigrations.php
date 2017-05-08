<?php

namespace Medlib\Services;

use Illuminate\Support\Facades\DB;

/**
 * Suppress all rules containing "unused" in this
 * class SqlMigrations
 *
 * @SuppressWarnings("unused")
 * @SuppressWarnings("PHPMD.CyclomaticComplexity")
 * @SuppressWarnings("PHPMD.NPathComplexity")
 * @SuppressWarnings("PHPMD.ExcessiveMethodLength")
 */
class SqlMigrations
{

    private static $ignore = ['migrations'];
    private static $only = [];
    private static $database = "";
    private static $migrations = false;
    private static $schema = [];
    private static $selects = ['column_name as Field', 'column_type as Type', 'is_nullable as Null', 'column_key as Key', 'column_default as Default', 'extra as Extra', 'data_type as Data_Type'];
    private static $instance;
    private static $up = "";
    private static $down = "";

    private static function getTables()
    {
        return DB::select('SELECT table_name FROM information_schema.tables WHERE table_schema="' . self::$database . '"');
    }

    private static function getTableDescribes($table)
    {
        return DB::table('information_schema.columns')
            ->where('table_schema', '=', self::$database)
            ->where('table_name', '=', $table)
            ->get(self::$selects);
    }

    private static function getForeignTables()
    {
        return DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('CONSTRAINT_SCHEMA', '=', self::$database)
            ->where('REFERENCED_TABLE_SCHEMA', '=', self::$database)
            ->select('TABLE_NAME')->distinct()
            ->get();
    }

    private static function getForeigns($table)
    {
        return DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('CONSTRAINT_SCHEMA', '=', self::$database)
            ->where('REFERENCED_TABLE_SCHEMA', '=', self::$database)
            ->where('TABLE_NAME', '=', $table)
            ->select('COLUMN_NAME', 'REFERENCED_TABLE_NAME', 'REFERENCED_COLUMN_NAME')
            ->get();
    }

    private static function compileSchema($name, $values)
    {
        $schema = "<?php
use Illuminate\\Database\\Schema\\Blueprint;
use Illuminate\\Database\\Migrations\\Migration;

//
// Auto-generated Migration Created: " . date("Y-m-d H:i:s") . "
// ------------------------------------------------------------

class Create" . str_replace('_', '', Str::title($name)) . "Table extends Migration {

\t/**
\t * Run the migrations.
\t *
\t * @return void
\t*/
\tpublic function up()
\t{
{$values['up']}
\t}

\t/**
\t * Reverse the migrations.
\t *
\t * @return void
\t*/
\tpublic function down()
\t{
{$values['down']}
\t}
}";

        return $schema;
    }

    public function up($up)
    {
        self::$up = $up;
        return self::$instance;
    }

    public function down($down)
    {
        self::$down = $down;
        return self::$instance;
    }

    public function ignore($tables)
    {
        self::$ignore = array_merge($tables, self::$ignore);
        return self::$instance;
    }

    public function only($tables)
    {
        self::$only = array_merge($tables, self::$only);
        return self::$instance;
    }

    public function migrations()
    {
        self::$migrations = true;
        return self::$instance;
    }

    /**
     * Iterates over the schemas and writes each one individually
     *
     * @return void
     */
    public function write()
    {
        echo "\nStarting schema migration.\n";
        echo "--------------------------\n";
        //print_r(self::$ignore);
        //print_r(self::$only); exit;
        foreach (self::$schema as $name => $values) {
            // determine if only or ignore is required
            if (count(self::$only) > 0) {
                if (!in_array($name, self::$only)) {
                    continue;
                }
            } else {
                if (in_array($name, self::$ignore)) {
                    continue;
                }
            }

            $schema = self::compileSchema($name, $values);
            $filename = date('Y_m_d_His') . "_create_" . $name . "_table.php";
            file_put_contents("database/migrations/{$filename}", $schema);
            echo "Writing database/migrations/{$filename}...\n";
        }

        echo "--------------------------\n";
        echo "Schema migration COMPLETE.\n\n";
    }

    /**
     * @param $database
     * @return SqlMigrations
     */
    public function convert($database)
    {
        self::$instance = new self();
        self::$database = $database;
        $tableHeaders = ['Field', 'Type', 'Null', 'Key', 'Default', 'Extra'];
        $tables = self::getTables();
        foreach ($tables as $key => $value) {
            if (in_array($value->table_name, self::$ignore)) {
                continue;
            }

            $down = "\t\tSchema::drop('{$value->table_name}');";
            $up = "\t\tSchema::create('{$value->table_name}', function(Blueprint $" . "table) {\n";
            $tableDescribes = self::getTableDescribes($value->table_name);
            foreach ($tableDescribes as $values) {
                $method = "";
                $para = strpos($values->Type, '(');
                $type = $para > -1 ? substr($values->Type, 0, $para) : $values->Type;
                $numbers = "";
                $nullable = $values->Null == "NO" ? "" : "->nullable()";
                $default = empty($values->Default) ? "" : "->default(\"{$values->Default}\")";
                $unsigned = strpos($values->Type, "unsigned") === false ? '' : '->unsigned()';
                $unique = $values->Key == 'UNI' ? "->unique()" : "";
                switch ($type) {
                    // bigIncrements
                    case 'bigint':
                        $method = 'bigInteger';
                        break;
                    case 'blob':
                        $method = 'binary';
                        break;
                    case 'boolean':
                        $method = 'boolean';
                        break;
                    case 'char':
                    case 'varchar':
                        $para = strpos($values->Type, '(');
                        $numbers = ", " . substr($values->Type, $para + 1, -1);
                        $method = 'string';
                        break;
                    case 'date':
                        $method = 'date';
                        break;
                    case 'datetime':
                        $method = 'dateTime';
                        break;
                    case 'decimal':
                        $para = strpos($values->Type, '(');
                        $numbers = ", " . substr($values->Type, $para + 1, -1);
                        $method = 'decimal';
                        break;

                    // double

                    // enum

                    case 'float':
                        $method = 'float';
                        break;

                    // increments

                    case 'int':
                        $method = 'unsignedInteger';
                        break;

                    // longText

                    // mediumInteger

                    case 'mediumtext':
                        $method = 'mediumtext';
                        break;

                    case 'smallint':
                        $method = 'smallInteger';
                        break;
                    case 'tinyint':
                        $method = 'boolean';
                        break;
                    case 'text':
                        $method = 'text';
                        break;

                    // time

                    // nullableTimestamps
                    case 'timestamp':
                        $method = 'timestamp';
                        break;
                }
                if ($values->Key == 'PRI') {
                    $method = 'increments';
                }
                $up .= "\t\t\t$" . "table->{$method}('{$values->Field}'{$numbers}){$nullable}{$default}{$unsigned}{$unique};\n";
            }

            $up .= "\t\t});\n";
            self::$schema[$value->table_name] = [
                'up' => $up,
                'down' => $down
            ];
        }

        /**
         * add foreign constraints, if any
         */
        $tableForeigns = self::getForeignTables();
        if (sizeof($tableForeigns) !== 0) {
            foreach ($tableForeigns as $key => $value) {
                $up = "Schema::table('{$value->TABLE_NAME}', function($" . "table) {\n";
                $foreign = self::getForeigns($value->TABLE_NAME);
                foreach ($foreign as $k => $v) {
                    $up .= "\t\t\t$" . "table->foreign('{$v->COLUMN_NAME}')->references('{$v->REFERENCED_COLUMN_NAME}')->on('{$v->REFERENCED_TABLE_NAME}');\n";
                }
                $up .= "\t\t});\n";
                self::$schema[$value->TABLE_NAME . '_foreign'] = [
                    'up' => $up,
                    'down' => $down
                ];
            }
        }
        return self::$instance;
    }
}
