<?php

namespace App\Http\Controllers\MyStudio;

use App\Http\Controllers\Controller;
use App\Http\Requests\TableField\StoreRequest;
use App\Models\MyStudio\MyStudio;
use App\Models\MyStudio\Settings;
use App\Processors\DeleteTable;
use App\Processors\ResetMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TableFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $table = MyStudio::where('type', 'table')->get();
        return view('mystudio.table.index', [
            'tables' => $table,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // get predefined column type from setting table
        $colTypes = Settings::where('name', 'column_type')->first();
        $colTypes = collect($colTypes->settings);
        $colTypes = $colTypes->where('enabled', true);

        // get predefined field type from setting table
        $fieldTypes = Settings::where('name', 'field_type')->first();
        $fieldTypes = collect($fieldTypes->settings);
        $fieldTypes = $fieldTypes->where('enabled', true);

        return view('mystudio.table.create', [
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
    public function store(StoreRequest $request)
    {
        $table = MyStudio::create([
            'name'        => $request->name,
            'type'        => 'table',
            'description' => $request->description,
        ]);

        return redirect()->route('table.edit', $table->id)->with('success', 'Table create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($table_id)
    {
        //Get Table
        $data = MyStudio::find($table_id);
        $data = $data->settings;

        $relations = $data['relationProperties'];

        //Get settings data attribute
        if (!empty($data)) {
            $migrationcolumns = $data['migrationProperties'];
            $htmls            = $data['htmlProperties'];
            $validations      = $data['validationProperties'];

            //Merge validation  Data
            $validationData = array();
            foreach ($validations as $validation) {
                $validationData[$validation['column_id']]['column_id']    = $validation['column_id'];
                $validationData[$validation['column_id']]['validation'][] = array('validation_rule' => $validation['validation_rule'], 'validation_error_message' => $validation['validation_error_message']);
            }

            //Combine array of migrationcolumns & html based on column_id into migraton_html_data
            foreach ($migrationcolumns as $key_1 => $value_1) {
                foreach ($htmls as $key_2 => $value_2) {
                    if ($value_1['column_id'] == $value_2['column_id']) {
                        $migraton_html_data[] = array_merge($value_1, $value_2);
                    }
                }
            }

            //Combine array of migraton_html_data & validationData based on column_id into newData
            foreach ($migraton_html_data as $key_1 => $value_1) {
                foreach ($validationData as $key_2 => $value_2) {
                    if ($value_1['column_id'] == $value_2['column_id']) {
                        $newData[] = array_merge($value_1, $value_2);
                    }
                }
            }
        } else {

            $newData = [];
        }

        return view('mystudio.table.show', [
            'table'     => MyStudio::find($table_id),
            'columns'   => $newData,
            'relations' => $relations,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(MyStudio $table_id)
    {
        // get predefined column type from setting table
        $colTypes = Settings::where('name', 'column_type')->first();
        $colTypes = collect($colTypes->settings);
        $colTypes = $colTypes->where('enabled', true);

        // get predefined field type from setting table
        $fieldTypes = Settings::where('name', 'field_type')->first();
        $fieldTypes = collect($fieldTypes->settings);
        $fieldTypes = $fieldTypes->where('enabled', true);

        return view('mystudio.table.edit', [
            'table'      => $table_id,
            'colTypes'   => $colTypes,
            'fieldTypes' => $fieldTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyStudio $table_id)
    {

        $settings = [
            'defaultMigration'     => $request->defaultMigration,
            'migrationProperties'  => $request->migrationProperties,
            'htmlProperties'       => $request->htmlProperties,
            'validationProperties' => $request->validationProperties,
            'relationProperties'   => [],
        ];

        $table_id->update([
            'name'        => $request->name,
            'description' => $request->description,
            'settings'    => $settings,
        ]);

        return redirect()->route('table.show', $table_id)->with('success', 'Table column create successfully');
    }

    public function edittablecolumn($table_id)
    {
        $newData = [];
        $max_id  = 0;

        $colTypes = Settings::where('name', 'column_type')->first();
        $colTypes = collect($colTypes->settings);
        $colTypes = $colTypes->where('enabled', true);

        $fieldTypes = Settings::where('name', 'field_type')->first();
        $fieldTypes = collect($fieldTypes->settings);
        $fieldTypes = $fieldTypes->where('enabled', true);

        // //Get Table
        $data = MyStudio::find($table_id);
        $data = $data->settings;

        if (!empty($data)) {

            //Get settings data attribute
            $migrationcolumns = $data['migrationProperties'];
            $htmls            = $data['htmlProperties'];
            $validations      = $data['validationProperties'];
            $relations        = $data['relationProperties'];

            //Merge validation  Data
            $validationData = array();
            foreach ($validations as $validation) {
                $validationData[$validation['column_id']]['column_id']    = $validation['column_id'];
                $validationData[$validation['column_id']]['validation'][] = array('validation_rule' => $validation['validation_rule'], 'validation_error_message' => $validation['validation_error_message']);
            }

            //Combine array of migrationcolumns & html based on column_id into migraton_html_data
            foreach ($migrationcolumns as $key_1 => $value_1) {
                foreach ($htmls as $key_2 => $value_2) {
                    if ($value_1['column_id'] == $value_2['column_id']) {
                        $migraton_html_data[] = array_merge($value_1, $value_2);
                    }
                }
            }

            //Combine array of migraton_html_data & validationData based on column_id into newData
            foreach ($migraton_html_data as $key_1 => $value_1) {
                foreach ($validationData as $key_2 => $value_2) {
                    if ($value_1['column_id'] == $value_2['column_id']) {
                        $newData[] = array_merge($value_1, $value_2);
                    }
                }
            }

            $max_id = collect($migrationcolumns);
            $max_id = $max_id->max('column_id');

        }

        // get data for defaultMigration - id(),timestamp(),softDelete()
        $default           = collect($data['defaultMigration']);
        $defaultid         = $default->where('column_name', 'id()')->first();
        $defaulttimestamp  = $default->where('column_name', 'timestamps()')->first();
        $defaultsoftdelete = $default->where('column_name', 'softDeletes()')->first();

        return view('mystudio.table.edit_table_column', [
            'table'             => MyStudio::find($table_id),
            'colTypes'          => $colTypes,
            'fieldTypes'        => $fieldTypes,
            'newData'           => $newData,
            'maxid'             => $max_id,
            'defaultid'         => $defaultid,
            'defaulttimestamp'  => $defaulttimestamp,
            'defaultsoftdelete' => $defaultsoftdelete,
        ]);
    }

    public function updateTableColumn(Request $request, MyStudio $table)
    {
        // GET data
        $default    = $request->defaultMigration;
        $migration  = $request->migrationProperties;
        $html       = $request->htmlProperties;
        $validation = $request->validationProperties;

        $update_data = [
            'name'                           => $request->name,
            'description'                    => $request->description,
            'settings->defaultMigration'     => $default,
            'settings->migrationProperties'  => $migration,
            'settings->htmlProperties'       => $html,
            'settings->validationProperties' => $validation,
        ];

        $table->update($update_data);

        return redirect()->route('table.show', $table)->with('success', 'Table updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($table_id)
    {
        $table = MyStudio::find($table_id);

        if (!($table instanceof MyStudio && $table->type == 'table')) {
            return redirect()->route('table.index')->with('error', 'Table deleted failed');
        }

        // Delete table
        DeleteTable::make($table)->process();

        // Reset menu
        ResetMenu::make()->process();

        return redirect()->route('table.index')->with('success', 'Table ' . $table->name . ' deleted successfully');
    }

    // CRUD Table Relation
    public function createRelation($table_id)
    {
        return view('mystudio.table.relation.create', [
            'table'     => MyStudio::find($table_id),
            'tableList' => MyStudio::where('type', 'table')->get(),

        ]);
    }

    public function storeRelation(Request $request, $table_id)
    {
        $table = MyStudio::find($table_id);

        // merge existing relation with new relation
        $relations = array_merge($table['relationProperties'], $request->relation);

        $update_data = [
            'settings->relationProperties' => $relations,
        ];

        $table->update($update_data);

        return redirect()->route('table.show', $table_id)->with('success', 'Table relation create successfully');
    }

    public function editRelation($table_id)
    {
        $table = MyStudio::find($table_id);

        return view('mystudio.table.relation.edit', [
            'table'     => MyStudio::find($table_id),
            'tableList' => MyStudio::where('type', 'table')->get(),
            'relations' => data_get($table->settings, 'relationProperties'),
        ]);
    }

    public function updateRelation(Request $request, $table_id)
    {
        $table = MyStudio::find($table_id);

        // merge existing relation with new relation
        $relations = array_merge($table['relationProperties'], $request->relation);

        $update_data = [
            'settings->relationProperties' => $relations,
        ];
        $table->update($update_data);

        return redirect()->route('table.show', $table_id)->with('success', 'Table relation update successfully');

    }
    // CRUD Table Relation
}
