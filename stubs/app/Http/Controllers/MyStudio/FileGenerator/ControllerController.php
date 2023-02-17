<?php

namespace App\Http\Controllers\MyStudio\FileGenerator;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\MyStudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class ControllerController extends Controller
{

    const NEW_LINE  = "\n";
    const SEPARATOR = "\t";

    public function create(Request $request, $id)
    {
        $form  = MyStudio::find($id);
        $table = MyStudio::find($form->settings['tableForm'][0]['table_id']);

        $name   = Str::of($form->name)->singular()->camel()->ucfirst();
        $model  = Str::of($table['name'])->singular()->camel()->ucfirst();
        $module = Str::of($name)->kebab();
        $class  = 'App\Models\MyStudio\\' . $model;

        if (class_exists($class)) {

            $command = 'mystudio:controller ' . $name . 'Controller' .
                ' --module=' . $module .
                ' --model=MyStudio\\\\' . $model .
                ' --resource --force';

            Artisan::call($command);

            return redirect()->back()->with('success', 'Controller file successfully created');

        } else {

            return redirect()->back()->with('failed', 'Model not Exists.');

        }
    }
}
