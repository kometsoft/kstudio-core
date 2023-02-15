<?php

namespace App\Http\Controllers\MyStudio\FileGenerator;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\MyStudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DataTablesController extends Controller
{
    public function create(Request $request, $id)
    {
        $form  = MyStudio::find($id);
        $table = MyStudio::find($form->settings['tableForm'][0]['table_id']);

        $name      = Str::of($form->name)->singular()->camel()->ucfirst();
        $model     = Str::of($table['name'])->singular()->camel()->ucfirst();
        $routeName = 'mystudio.' . Str::kebab(Str::singular($form->name));
        $columns   = $this->getColumn($form);

        $command = 'mystudio:datatables ' . $name .
            ' --model=App\\\\Models\\\\MyStudio\\\\' . $model .
            ' --force --columns=' . $columns;

        Artisan::call($command);

        // Load latest model
        $file_name = $name . 'DataTable.php';
        $file      = Storage::disk('datatables')->get('MyStudio/' . $file_name);

        $content = Str::replace('DummyRoute', $routeName, $file);

        Storage::disk('datatables')->put('MyStudio/' . $file_name, $content);

        return redirect()->back()->with('success', 'DataTables file successfully created');
    }

    private function getColumn($form)
    {
        // Initialize
        $columns = $form->settings['indexList']['list_properties'] ?? [];

        // DataTable Column
        if (collect($columns)->count() > 0) {
            return implode(',', collect($columns)->pluck('field_name')->toArray());
        }

        return 'id,created_at,updated_at';
    }
}
