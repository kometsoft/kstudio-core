<?php

namespace App\Http\Controllers\MyStudio;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\MyStudio;
use App\Models\MyStudio\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mystudio.list.index', [
            'lists' => MyStudio::where('type', 'list')->get(),
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
        $filterCondition = Settings::where('name', 'filter_condition')->first();
        $filterCondition = collect($filterCondition?->settings);
        $filterCondition = $filterCondition->where('enabled', true);
        $modelProperties = [];

        $models = MyStudio::where('type', 'table')->get();
        if (!empty($models)) {
            foreach ($models as $model) {
                // Model naming as ModelController
                $name = ucfirst(Str::camel(Str::singular($model->name)));
                // Get Column Data
                $columns = $model->settings['migrationProperties'];

                // initialize default id,create_at,update_at
                $defaultColumn = [
                    '0' => [
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
                    '1' => [
                        "column_id"            => null,
                        "column_name"          => "created_at",
                        "column_type"          => null,
                        "column_index"         => null,
                        "column_length"        => null,
                        "column_comment"       => null,
                        "column_nullable"      => null,
                        "column_protected"     => null,
                        "column_default_value" => null,
                    ],
                    '2' => [
                        "column_id"            => null,
                        "column_name"          => "updated_at",
                        "column_type"          => null,
                        "column_index"         => null,
                        "column_length"        => null,
                        "column_comment"       => null,
                        "column_nullable"      => null,
                        "column_protected"     => null,
                        "column_default_value" => null,
                    ],

                ];

                // combine data default and migrationsProperties
                $combinedColumn = array_merge($columns, $defaultColumn);

                // Store needed data to $modelProperties
                $modelProperties[] = [
                    'model'    => $name,
                    'table_id' => $model->id,
                    'columns'  => $combinedColumn,
                ];
            }
        }

        return view('mystudio.list.create', [
            'models'     => $modelProperties,
            'conditions' => $filterCondition,
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

        $settings = [
            'table'      => Str::snake(Str::plural($request->table)),
            'model'      => $request->model,
            'conditions' => $request->condition,
            'indexList'  => [
                'item_per_page'   => $request->item_per_page,
                'list_properties' => $request->list,
            ],
        ];

        MyStudio::create([
            'name'        => $request->name,
            'type'        => 'list',
            'description' => $request->description,
            'settings'    => $settings,
        ]);

        return redirect()->route('list.index')->with('success', 'List create successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = MyStudio::find($id);
        return view('mystudio.list.show', [
            'list'  => $list,
            'model' => $list->settings['model'],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // get predefined column type from setting table
        $filterCondition = Settings::where('name', 'filter_condition')->first();
        $filterCondition = collect($filterCondition->settings);
        $filterCondition = $filterCondition->where('enabled', true);

        $list = MyStudio::find($id);

        $models = MyStudio::where('type', 'table')->get();

        foreach ($models as $model) {
            // Model naming as ModelController
            $name = ucfirst(Str::camel(Str::singular($model->name)));
            // Get Column Data
            $columns = $model->settings['migrationProperties'];

            // initialize default id,create_at,update_at
            $defaultColumn = [
                '0' => [
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
                '1' => [
                    "column_id"            => null,
                    "column_name"          => "created_at",
                    "column_type"          => null,
                    "column_index"         => null,
                    "column_length"        => null,
                    "column_comment"       => null,
                    "column_nullable"      => null,
                    "column_protected"     => null,
                    "column_default_value" => null,
                ],
                '2' => [
                    "column_id"            => null,
                    "column_name"          => "updated_at",
                    "column_type"          => null,
                    "column_index"         => null,
                    "column_length"        => null,
                    "column_comment"       => null,
                    "column_nullable"      => null,
                    "column_protected"     => null,
                    "column_default_value" => null,
                ],

            ];

            // combine data default and migrationsProperties
            $combinedColumn = array_merge($columns, $defaultColumn);

            // Store needed data to $modelProperties
            $modelProperties[] = [
                'model'    => $name,
                'table_id' => $model->id,
                'columns'  => $combinedColumn,
            ];
        }

        // get list of model data
        $collect       = collect($modelProperties);
        $column_option = $collect->where('model', $list->settings['model'])->first();
        $columns       = $column_option['columns'];

        // get total condition of list
        $total_condition = count($collect);

        return view('mystudio.list.edit', [
            'list'       => MyStudio::find($id),
            'models'     => $modelProperties,
            'conditions' => $filterCondition,
            'columns'    => $columns,
            'total'      => $total_condition,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $settings = [
            'table'      => Str::snake(Str::plural($request->table)),
            'model'      => $request->model,
            'conditions' => $request->condition,
            'indexList'  => [
                'item_per_page'   => $request->item_per_page,
                'list_properties' => $request->list,
            ],
        ];

        $list = MyStudio::find($id);
        $list->update([
            'name'        => $request->name,
            'type'        => 'list',
            'description' => $request->description,
            'settings'    => $settings,
        ]);

        return redirect()->route('list.show', $id)->with('success', 'List update successfully');
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
