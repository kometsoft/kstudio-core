<?php

namespace App\Http\Controllers\MyStudio\FileGenerator;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\MyStudio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class RouteController extends Controller
{
    public function create(Request $request, $id)
    {
        $form  = MyStudio::find($id);
        $table = MyStudio::find($form->settings['tableForm'][0]['table_id']);

        $name     = Str::of($form->name)->singular()->camel()->ucfirst();
        $resource = ucfirst($name) . 'Controller';

        $command = 'mystudio:route ' . $name .
            ' --resource=App\\\\Http\\\\Controllers\\\\MyStudio\\\\' . $resource
        ;

        Artisan::call($command);

        return redirect()->back()->with('success', 'Route file successfully created');
    }
}
