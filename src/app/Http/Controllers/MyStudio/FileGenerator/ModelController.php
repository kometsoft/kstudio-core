<?php

namespace App\Http\Controllers\MyStudio\FileGenerator;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\MyStudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ModelController extends Controller
{
    const NEW_LINE = "\n";
    const TAB      = "\t";

    public function create(Request $request, $id)
    {
        $table = MyStudio::find($id);

        $name = ucfirst(Str::camel(Str::singular($table->name)));

        Artisan::call('mystudio:model ' . $name . ' --force');

        // Load latest model
        $file_name = $name . '.php';
        $file      = Storage::disk('models')->get('MyStudio/' . $file_name);

        $content = Str::replace('// {{ content }}', $this->generateContent($table), $file);

        Storage::disk('models')->put('MyStudio/' . $file_name, $content);

        return redirect()->back()->with('success', 'Model ' . $name . ' successfully created. (App\Models\MyStudio\\' . $name . '.php)');
    }

    private function generateContent($table)
    {
        $content = '';

        // Relationship
        if (!empty($table->settings['relationProperties'])) {
            foreach ($table->settings['relationProperties'] as $relation) {
                $type            = $relation['relation_name'] ?? '';
                $primary_table   = $relation['relation_table_first'] ?? '';
                $secondary_table = $relation['relation_table_second'] ?? '';
                $first_argument  = (!empty($relation['relation_first_argument'])) ? ", '" . $relation['relation_first_argument'] . "'" : '';
                $second_argument = (!empty($relation['relation_second_argument'])) ? ", '" . $relation['relation_second_argument'] . "'" : '';
                $third_argument  = (!empty($relation['relation_third_argument'])) ? ", '" . $relation['relation_third_argument'] . "'" : '';
                $fourth_argument = (!empty($relation['relation_fourth_argument'])) ? ", '" . $relation['relation_fourth_argument'] . "'" : '';

                $argument = Str::of($primary_table)->camel()->singular()->ucfirst() . "::class" . $first_argument . $second_argument . $third_argument . $fourth_argument;

                if (!empty($type)) {
                    $function = Str::plural($primary_table);

                    if ($type == 'hasOne' || $type == 'belongsTo' || $type == 'hasOneThrough') {
                        $function = Str::of($primary_table)->camel()->singular();
                    }

                    $content .= "public function $function()" . self::NEW_LINE . self::TAB .
                    "{" . self::NEW_LINE . self::TAB .
                    self::TAB . "return \$this->" . $type . "($argument);" . self::NEW_LINE . self::TAB .
                    "}" . self::NEW_LINE . self::NEW_LINE . self::TAB;
                }
            }
        }

        return $content;
    }
}
