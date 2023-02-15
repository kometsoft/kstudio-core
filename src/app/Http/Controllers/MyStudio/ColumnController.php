<?php

namespace App\Http\Controllers\MyStudio;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\MyStudio;
use App\Models\MyStudio\Settings;
use Illuminate\Http\Request;

class ColumnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($table_id)
    {
        // get predefined column type from setting table
        $colTypes = Settings::where('name', 'column_type')->first();
        $colTypes = collect($colTypes->settings);
        $colTypes = $colTypes->where('enabled', true);

        // get predefined filed type from setting table
        $fieldTypes = Settings::where('name', 'field_type')->first();
        $fieldTypes = collect($fieldTypes->settings);
        $fieldTypes = $fieldTypes->where('enabled', true);

        return view('mystudio.table.column.create', [
            'table'      => MyStudio::find($table_id),
            'colTypes'   => $colTypes,
            'fieldTypes' => $fieldTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($table_id, $column_id)
    {
        //Get Table
        $data = MyStudio::find($table_id);
        $data = $data->settings;

        //Get settings data attribute
        $migrationcolumns = $data['migrationProperties'];
        $htmls            = $data['htmlProperties'];
        $validations      = $data['validationProperties'];

        $column     = collect($migrationcolumns);
        $columnitem = $column->where('column_id', $column_id)->first();

        $html     = collect($htmls);
        $htmlitem = $html->where('column_id', $column_id)->first();

        $validation     = collect($validations);
        $validationitem = $validation->where('column_id', $column_id);

        return view('mystudio.table.column.show', [
            'table'      => MyStudio::find($table_id),
            'column'     => $columnitem,
            'html'       => $htmlitem,
            'validation' => $validationitem,
            'data'       => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($table_id, $column_id)
    {
        $colTypes = Settings::where('name', 'column_type')->first();
        $colTypes = collect($colTypes->settings);
        $colTypes = $colTypes->where('enabled', true);

        $fieldTypes = Settings::where('name', 'field_type')->first();
        $fieldTypes = collect($fieldTypes->settings);
        $fieldTypes = $fieldTypes->where('enabled', true);

        //Get Table
        $data = MyStudio::find($table_id);
        $data = $data->settings;

        //Get settings data attribute
        $migrationcolumns = $data['migrationProperties'];
        $htmls            = $data['htmlProperties'];
        $validations      = $data['validationProperties'];

        $column     = collect($migrationcolumns);
        $columnitem = $column->where('column_id', $column_id)->first();

        $html     = collect($htmls);
        $htmlitem = $html->where('column_id', $column_id)->first();

        $validation     = collect($validations);
        $validationitem = $validation->where('column_id', $column_id);

        return view('mystudio.table.column.edit', [
            'table'      => MyStudio::find($table_id),
            'colTypes'   => $colTypes,
            'fieldTypes' => $fieldTypes,
            'column'     => $columnitem,
            'html'       => $htmlitem,
            'validation' => $validationitem,
            'data'       => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $table_id, $column_id)
    {

        //Get Table
        $data = MyStudio::find($table_id);
        $data = $data->settings;

        //Get settings data attribute
        $defaultMigration = $data['defaultMigration'];
        $migrationcolumns = $data['migrationProperties'];
        $htmls            = $data['htmlProperties'];
        $validations      = $data['validationProperties'];
        $relations        = $data['relationProperties'];

        // update json data based on column_id
        foreach ($migrationcolumns as $migration) {
            if ($migration['column_id'] == $column_id) {
                $newMigrations[] = [
                    "column_id"            => $column_id,
                    "column_name"          => $request->column_name,
                    "column_type"          => $request->column_type,
                    "column_index"         => $request->column_index,
                    "column_length"        => $request->column_length,
                    "column_comment"       => $request->column_comment,
                    "column_nullable"      => $request->column_nullable,
                    "column_default_value" => $request->column_default_value,
                    "column_protected"     => $request->column_protected,
                ];
            } else {
                $newMigrations[] = $migration;
            }

        }

        foreach ($htmls as $html) {
            if ($html['column_id'] == $column_id) {
                $newhtmls[] = [
                    "column_id"        => $column_id,
                    "html_label"       => $request->html_label,
                    "html_value"       => $request->html_value,
                    "html_disabled"    => $request->html_disabled,
                    "html_readonly"    => $request->html_readonly,
                    "html_required"    => $request->html_required,
                    "html_autofocus"   => $request->html_autofocus,
                    "html_input_type"  => $request->html_input_type,
                    "html_placeholder" => $request->html_placeholder,
                ];
            } else {
                $newhtmls[] = $html;
            }

        }

        // remove validation with $column_id
        foreach ($validations as $validation) {

            if ($validation['column_id'] == $column_id) {
                // $newvalidations[] = [];
            } else {
                $newvalidations[] = $validation;
            }

        }
        // add new validation with $column_id
        foreach ($request->validation as $val) {
            $newvalidations[] = [
                "column_id"                => $val['column_id'],
                "validation_rule"          => $val['validation_rule'],
                "validation_error_message" => $val['validation_error_message'],
            ];
        }

        $settings = [
            'defaultMigration'     => $defaultMigration,
            'migrationProperties'  => $newMigrations,
            'htmlProperties'       => $newhtmls,
            'validationProperties' => $newvalidations,
            'relationProperties'   => $relations,
        ];

        $newdata           = MyStudio::find($table_id);
        $newdata->settings = $settings;
        $newdata->update();

        return redirect()->route('column.show', [$table_id, $column_id])->with('success', 'Column updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
