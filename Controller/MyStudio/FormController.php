<?php

namespace App\Http\Controllers\MyStudio;

use App\Http\Controllers\Controller;
use App\Models\Admin\Lookup;
use App\Models\MyStudio\MyStudio;
use App\Models\Role;
use App\Processors\DeleteForm;
use App\Processors\ResetMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mystudio.form.index', [
            'forms' => MyStudio::where('type', 'form')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mystudio.form.create', [
            'tables'    => MyStudio::where('type', 'table')->where('settings', '!=', null)->get(),
            'formCount' => MyStudio::where('type', 'form')->count(),
        ]);
    }

    // AJAX get column data from Table
    public function getData(Request $request, $table_id)
    {
        $table = MyStudio::find($table_id);
        $data  = $table->settings['migrationProperties'];

        // initiate default column - id, created_at, updated_at
        // save to $defaultColumn
        $defaultColumn = [
            'id' => [
                "column_id"            => null,
                "column_name"          => "id",
                "column_type"          => null,
                "column_index"         => null,
                "column_length"        => null,
                "column_comment"       => null,
                "column_nullable"      => null,
                "column_protected"     => null,
                "column_default_value" => null,
            ],
        ];

        // combine default column and table->migrationProperties into $combineData
        $combineData = array_merge($data, $defaultColumn);

        $data = [
            'id'     => $table->id,
            'table'  => $table->name,
            'column' => $combineData,
        ];

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $settings = [
            'tableForm'   => $request->table,
            'formDetails' => '',
            'indexList'   => [
                'item_per_page'   => $request->item_per_page,
                'list_properties' => $request->list,
            ],
        ];

        $form = MyStudio::create([
            'name'        => $request->name,
            'type'        => 'form',
            'description' => $request->description,
            'settings'    => $settings,
        ]);

        // store data into initiate on session
        Session::put('initiate', $request->initiate);
        // store table type in session
        Session::put('table-type', $request->tabletype);

        //Sync permission
        $this->syncPermission($request->name);

        return redirect()->route('form.designForm', $form->id)->with('success', 'Form create successfully');

    }

    public function designForm($form_id)
    {

        $form = MyStudio::find($form_id);

        // get Table used for from
        $tables = $form->settings['tableForm'];
        foreach ($tables as $table) {
            $tableUses = MyStudio::find($table['table_id']);

            // merge htmlProperties and migrationProperties into 1 based on column_id
            $htmlmigrationData = array_replace_recursive($tableUses->settings['htmlProperties'], $tableUses->settings['migrationProperties']);

            $tabledetails[] = [
                'table_id'   => $tableUses->id,
                'table_name' => $tableUses->name,
                'htmlField'  => $htmlmigrationData,
            ];
        }

        //define empty array
        $notinitiateData = [];
        // get initiate data from session
        $initiate = Session::get('initiate');
        // get initiate data from session
        $tableType = Session::get('table-type');
        // get total of data in initiate session
        if (!empty($initiate)) {
            $countinitiate = count($initiate);
        }

        if (!empty($initiate)) {
            foreach ($tabledetails as $details) {
                // get total of column
                if ($tableType == 'single') {
                    $tableData = count($details['htmlField']);
                } else {
                    $tableData[] = count($details['htmlField']);
                }

                foreach ($details['htmlField'] as $column) {
                    foreach ($initiate as $init) {
                        if ($column['column_name'] != $init['column_name']) {
                            // save data into $notinitiate that not inside the initiate session
                            $notinitiate[] = $column['column_name'];
                        }

                    }
                }
            }

            if ($tableType == 'single') {
                $tableData = $tableData;
            } else {
                $tableData = array_sum($tableData);
            }

            // check if all column are inside from design or not
            if ($countinitiate === $tableData) {
                $notinitiateData = [];
            } else {

                /* get count of frequent values inside $notinitiate */
                $max    = 0;
                $counts = array_count_values($notinitiate);
                foreach ($counts as $value => $amount) {
                    if ($amount > $max) {
                        $max = $amount;
                    }
                }

                // save all column_name inside $notinitiate that has same count as $max
                foreach ($tabledetails as $details) {
                    foreach ($details['htmlField'] as $column) {
                        // get count of each column inside $notinitiate
                        $count = $counts[$column['column_name']];
                        if ($count === $max) {
                            $notinitiateData[] = [
                                'column_name' => $column['column_name'],
                            ];
                        }
                    }
                }
            }
        }

        $lookup_columns = DB::getSchemaBuilder()->getColumnListing('lookups');
        $lookup_keys    = Lookup::select('key')->distinct()->get();

        return view('mystudio.form.form-design', [
            'tableDetails'   => $tabledetails,
            'form_id'        => $form_id,
            'initiate'       => Session::get('initiate'),
            'notinitiate'    => $notinitiateData,
            'tables'         => MyStudio::where('type', 'table')->get(),
            'lookup_keys'    => $lookup_keys,
            'lookup_columns' => $lookup_columns,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeForm(Request $request, $form_id)
    {
        // get input properties
        $properties = $request->properties;

        // get value and convert to collection
        $value = collect($request->properties_value);
        
        // get form structure and put into $content
        $formStructure = $request->htmlStructure;

        $count = count($formStructure['column']);
        for ($x = 1; $x <= $count; $x++) {
            $contents[] = [
                'table'  => $formStructure['table'][$x],
                'column' => $formStructure['column'][$x],
            ];
        }

        // combine input properties and value in $data
        foreach ($properties as $pro) {

            // check if array has option_type element
            if (array_key_exists("option_type", $pro)) {

                // store data baseon option_type
                if ($pro['option_type'] == 'table') {
                    $getvalue = $value->where('column_name', $pro['column_name']);
                    $getvalue = $getvalue['' . $pro['table_name'] . '-' . $pro['column_name'] . ''];

                    $table      = MyStudio::find($getvalue['table_reference']);
                    $table_name = Str::snake(Str::plural($table->name));

                    $inputvalue = [
                        'reference_table'    => $table_name,
                        'description_column' => $getvalue['description_column'],
                        'value_column'       => $getvalue['value_column'],
                    ];

                    $option_type = $pro['option_type'];

                } elseif ($pro['option_type'] == 'data-dictionary') {
                    $getvalue = $value->where('column_name', $pro['column_name']);
                    $getvalue = $getvalue['' . $pro['table_name'] . '-' . $pro['column_name'] . ''];

                    $inputvalue = [
                        'reference_table' => 'lookups',
                        'lookup_type'     => data_get($getvalue, 'lookup_type'),
                        'lookup_filter'   => data_get($getvalue, 'lookup_filter'),
                    ];

                    $option_type = $pro['option_type'];

                } else {

                    // get value based on column_name and pass to $data
                    $inputvalue = $value->where('column_name', $pro['column_name']);
                    // convert value from collection into array
                    $inputvalue = $inputvalue->toArray();

                    foreach ($inputvalue as $val) {
                        if (array_key_exists("description", $val)) {
                            $inputval[] = [
                                'description' => $val['description'],
                                'value'       => $val['value'],
                            ];
                        }
                    }

                    $inputvalue = $inputval;

                    $option_type = $pro['option_type'];

                }

            } else {

                // get value based on column_name and pass to $data
                $inputvalue = $value->where('column_name', $pro['column_name']);
                // convert value from collection into array
                $inputvalue = $inputvalue->toArray();

                $option_type = '';

            }

            // define $data and its structure
            $data[] = [
                'table_name'              => $pro['table_name'],
                'column_name'             => $pro['column_name'],
                'type'                    => $pro['field_type'],
                'mandatory'               => $pro['mandatory'],
                'mandatory_error_message' => $pro['mandatory_error_message'],
                'label'                   => $pro['label'],
                'placeholder'             => $pro['placeholder'],
                'option_type'             => $option_type,
                'value'                   => $inputvalue,
            ];
        }

        // convert data into colection
        $data = collect($data);

        // sort $data based on $content structure and store into $sortable_data
        foreach ($contents as $content) {
            if (!empty($content['table'])) {
                $newContent      = $data->where('table_name', $content['table'])->where('column_name', $content['column'])->first();
                $sortable_data[] = $newContent;
            }
        }

        $form        = MyStudio::find($form_id);
        $formsetting = $form->settings;

        // update settings content
        $settings = [
            'tableForm'   => $formsetting['tableForm'],
            'indexList'   => $formsetting['indexList'],
            'formDetails' => $sortable_data,
        ];

        $form->settings = $settings;
        $form->update();

        // remove initiate from session
        Session::forget('initiate');
        // remove initiate from session
        Session::forget('table-type');

        return redirect()->route('form.index', $form->id)->with('success', 'Form updated successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($form_id)
    {
        $form = MyStudio::find($form_id);
    }

    public function showForm($form_id)
    {
        $form        = MyStudio::find($form_id);
        $formDetails = $form->settings['formDetails'];

        return view('mystudio.form.show', [
            'form'        => $form,
            'formDetails' => $formDetails,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editForm($form_id)
    {

        $form = MyStudio::find($form_id);
        // get Table used for from
        $tables = $form->settings['tableForm'];
        foreach ($tables as $table) {
            $tableUses = MyStudio::find($table['table_id']);

            // merge htmlProperties and migrationProperties into 1 based on column_id
            $htmlmigrationData = array_replace_recursive($tableUses->settings['htmlProperties'], $tableUses->settings['migrationProperties']);

            $tabledetails[] = [
                'table_id'   => $tableUses->id,
                'table_name' => $tableUses->name,
                'htmlField'  => $htmlmigrationData,
            ];
        }

        $formData  = $form->settings['formDetails'];
        $countData = count($formData);

        $notinForm = [];
        if (!empty($formData)) {
            foreach ($tabledetails as $details) {
                $tableData = count($details['htmlField']);
                foreach ($details['htmlField'] as $column) {
                    foreach ($formData as $data) {
                        if ($column['column_name'] != $data['column_name']) {
                            $right[] = $column['column_name'];
                        }
                    }
                }
            }

            if ($countData === $tableData) {
                $notinForm = [];
            } else {
                /* get count of frequent values */
                $max    = 0;
                $counts = array_count_values($right);
                foreach ($counts as $value => $amount) {
                    if ($amount > $max) {
                        $max = $amount;
                    }
                }
                foreach ($tabledetails as $details) {
                    foreach ($details['htmlField'] as $column) {
                        $count = $counts[$column['column_name']];
                        if ($count === $max) {
                            $notinForm[] = [
                                'column_name' => $column['column_name'],
                            ];
                        }
                    }
                }
            }

        }

        $lookup_columns = DB::getSchemaBuilder()->getColumnListing('lookups');
        $lookup_keys    = Lookup::select('key')->distinct()->get();

        return view('mystudio.form.edit', [
            'tableDetails'   => $tabledetails,
            'form_id'        => $form_id,
            'notinForm'      => $notinForm,
            'formData'       => $formData,
            'countData'      => $countData,
            'tables'         => MyStudio::where('type', 'table')->where('settings', '!=', null)->get(),
            'formCount'      => MyStudio::where('type', 'form')->count(),
            'lookup_keys'    => $lookup_keys,
            'lookup_columns' => $lookup_columns,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateForm(Request $request, $form_id)
    {

        // get input properties
        $properties = $request->properties;
        // get value and convert to collection
        $value = collect($request->properties_value);
        
        // get form structure and put into $content
        $formStructure = $request->htmlStructure;
        $count         = count($formStructure['column']);
        for ($x = 1; $x <= $count; $x++) {
            $contents[] = [
                'table'  => $formStructure['table'][$x],
                'column' => $formStructure['column'][$x],
            ];
        }

        // combine input properties and value in $data
        foreach ($properties as $pro) {

            // check if array has option_type element
            if (array_key_exists("option_type", $pro)) {

                // store data baseon option_type
                if ($pro['option_type'] == 'table') {
                    $getvalue = $value->where('column_name', $pro['column_name']);
                    $getvalue = $getvalue['' . $pro['table_name'] . '-' . $pro['column_name'] . ''];

                    $table      = MyStudio::find($getvalue['table_reference']);
                    $table_name = Str::snake(Str::plural($table->name));

                    $inputvalue = [
                        'reference_table'    => $table_name,
                        'description_column' => $getvalue['description_column'],
                        'value_column'       => $getvalue['value_column'],
                    ];

                    $option_type = $pro['option_type'];

                } elseif ($pro['option_type'] == 'data-dictionary') {
                    $getvalue = $value->where('column_name', $pro['column_name']);
                    $getvalue = $getvalue['' . $pro['table_name'] . '-' . $pro['column_name'] . ''];

                    $inputvalue = [
                        'reference_table' => 'lookups',
                        'lookup_type'     => data_get($getvalue, 'lookup_type'),
                        'lookup_filter'   => data_get($getvalue, 'lookup_filter'),
                    ];

                    $option_type = $pro['option_type'];

                } else {

                    // get value based on column_name and pass to $data
                    $inputvalue = $value->where('column_name', $pro['column_name']);
                    // convert value from collection into array
                    $inputvalue = $inputvalue->toArray();

                    foreach ($inputvalue as $val) {
                        if (array_key_exists("description", $val)) {
                            $inputval[] = [
                                'description' => $val['description'],
                                'value'       => $val['value'],
                            ];
                        }
                    }

                    $inputvalue = $inputval;

                    $option_type = $pro['option_type'];

                }

            } else {

                // get value based on column_name and pass to $data
                $inputvalue = $value->where('column_name', $pro['column_name']);
                // convert value from collection into array
                $inputvalue = $inputvalue->toArray();

                $option_type = '';

            }

            // define $data and its structure
            $data[] = [
                'table_name'              => $pro['table_name'],
                'column_name'             => $pro['column_name'],
                'type'                    => $pro['field_type'],
                'mandatory'               => $pro['mandatory'],
                'mandatory_error_message' => $pro['mandatory_error_message'],
                'label'                   => $pro['label'],
                'placeholder'             => $pro['placeholder'],
                'option_type'             => $option_type,
                'value'                   => $inputvalue,
            ];
        }

        // convert data into colection
        $data = collect($data);

        // sort $data based on $content structure and store into $sortable_data
        foreach ($contents as $content) {
            if (!empty($content['table'])) {
                $newContent      = $data->where('table_name', $content['table'])->where('column_name', $content['column'])->first();
                $sortable_data[] = $newContent;
            }
        }
        
        $form = MyStudio::find($form_id);
        
        //Sync permission
        $this->syncPermission($form->name);

        // update settings content
        $form->update([
            'settings->formDetails' => $sortable_data,
        ]);

        return redirect()->route('form.showForm', $form->id)->with('success', 'Form updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($form_id)
    {
        $form = MyStudio::find($form_id);

        if (!($form instanceof MyStudio && $form->type == 'form')) {
            return redirect()->route('form.index')->with('error', 'Form deleted failed');
        }

        // Delete form
        DeleteForm::make($form)->process();

        // Reset menu
        ResetMenu::make()->process();

        return redirect()->route('form.index')->with('success', 'Form ' . $form->name . ' deleted successfully');
    }

    private function syncPermission($name)
    {
        //permission name
        $permissionName = Str::of($name)->lower()->kebab();

        // create form permission
        Permission::updateOrCreate(['name' => $permissionName . ':list']);
        Permission::updateOrCreate(['name' => $permissionName . ':create']);
        Permission::updateOrCreate(['name' => $permissionName . ':edit']);
        Permission::updateOrCreate(['name' => $permissionName . ':show']);

        // update roles and assign created form permissions
        Role::updateOrCreate(['name' => 'Admin'])
            ->syncPermissions([
                Permission::all(),
            ]);
    }
}
