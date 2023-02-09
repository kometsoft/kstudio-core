<?php

namespace App\Http\Controllers\MyStudio;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\MyStudio;
use App\Processors\GenerateMenu;
use App\Processors\MakeBladeDocument;
use Illuminate\Support\Facades\Route;

class GenerateFileController extends Controller
{
    // Generate create/edit/show/index blade file
    public function GenerateBladeFile($form_id)
    {
        $form = MyStudio::find($form_id);

        MakeBladeDocument::make($form)->process();

        return redirect()->route('form.index', $form->id)->with('success', 'Blade file created successfully');

    }

    public function GenerateMenuFile()
    {
        GenerateMenu::make()->process();

        return redirect()->back()->with('success', 'Menu file created successfully');

    }

}
