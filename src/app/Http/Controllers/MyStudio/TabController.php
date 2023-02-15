<?php

namespace App\Http\Controllers\MyStudio;

use App\Http\Controllers\Controller;
use App\Models\MyStudio\MyStudio;
use App\Models\MyStudio\Tab;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TabController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('mystudio.tab.index', [
            'tabs' => Tab::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('mystudio.tab.create', [
            'forms'  => MyStudio::where('type', 'form')->get(),
            'tables' => MyStudio::where('type', 'table')->get(),
            'refs'   => MyStudio::where('type', 'form')->first(),
        ]);
    }

    // AJAX get column data from Table
    public function getData(Request $request, $table_id)
    {
        $table = MyStudio::find($table_id);
        $data  = $table->settings['migrationProperties'];

        return $data;
    }

    // AJAX get table data from form
    public function getTable(Request $request, $form_id)
    {
        $form   = MyStudio::find($form_id);
        $tables = $form->settings['tableForm'];

        // foreach table used for form
        foreach ($tables as $table) {
            // get each table information
            $table_used = MyStudio::find($table['table_id']);

            // store table name and id into $data for each table used in form
            $data[] = [
                'table_name' => $table_used->name,
                'table_id'   => $table_used->id,
            ];
        }

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
        $parent_form  = MyStudio::find($request->form);
        $parent_table = MyStudio::find($request->table);

        // get data for subtab table
        foreach ($request->child as $child) {

            $child_form  = MyStudio::find($child['form']);
            $child_table = MyStudio::find($child['table']);

            // set foriegnKey & localKey basedon relation type
            if ($child['relation_type'] === 'hasMany') {
                $foreign_key  = $child['hasMany_foreignKey'];
                $local_key    = $child['hasMany_localKey'];
                $ref_table    = '';
                $ref_table_id = '';
            } else {
                $foreign_key    = $child['belongsToMany_foreignKey'];
                $local_key      = $child['belongsToMany_localKey'];
                $relation_table = MyStudio::find($child['relation_table']);
                $ref_table      = Str::snake(Str::plural($relation_table->name));
                $ref_table_id   = $relation_table->id;
            }

            $childtabs[] = [
                'parent_table'  => Str::snake(Str::plural($parent_table->name)),
                'form'          => $child_form->name,
                'form_id'       => $child_form->id,
                'table'         => Str::snake(Str::plural($child_table->name)),
                'table_id'      => $child_table->id,
                'title'         => $child['title'],
                'relation_type' => $child['relation_type'],
                'ref_table'     => $ref_table,
                'ref_table_id'  => $ref_table_id,
                'foreign_key'   => $foreign_key,
                'local_key'     => $local_key,
            ];

        }

        // store parent tab and child tab into data
        $data = [
            'form'     => $parent_form->name,
            'form_id'  => $parent_form->id,
            'table'    => Str::snake(Str::plural($parent_table->name)),
            'table_id' => $parent_table->id,
            'title'    => $request->title,
            'subtab'   => $childtabs,
        ];

        // update parent table relation with child table

        //Get relation data from parent table settings attribute
        $parent_table_relations = $parent_table->settings['relationProperties'];

        if (!empty($parent_table_relations)) {
            $collect_relation = collect($parent_table_relations);
            // define variable
            $parent_tab_relation = [];
            foreach ($childtabs as $childtab) {
                // check if relation already create on table or not
                if (count($collect_relation->where('relation_name', $childtab['relation_type'])->where('relation_table_first', $childtab['table'])) > 0) {
                    //skip to insert relation
                } else {
                    // check relation type and store based on relation type in to $tab_relation
                    if ($childtab['relation_type'] === 'hasMany') {

                        $parent_tab_relation[] = [
                            'relation_name'            => $childtab['relation_type'],
                            'relation_table_first'     => $childtab['table'],
                            'relation_table_second'    => '',
                            'relation_first_argument'  => $childtab['foreign_key'],
                            'relation_second_argument' => $childtab['local_key'],
                            'relation_third_argument'  => '',
                            'relation_fourth_argument' => '',
                        ];

                    } elseif ($childtab['relation_type'] === 'belongsToMany') {

                        $parent_tab_relation[] = [
                            'relation_name'            => $childtab['relation_type'],
                            'relation_table_first'     => $childtab['table'],
                            'relation_table_second'    => '',
                            'relation_first_argument'  => $childtab['ref_table'],
                            'relation_second_argument' => $childtab['foreign_key'],
                            'relation_third_argument'  => $childtab['local_key'],
                            'relation_fourth_argument' => '',
                        ];

                    } else {
                        $parent_table_relation = [];
                    }
                }
            }

            // merge existing relation with new relation
            $parent_relations = array_merge($parent_table_relations, $parent_tab_relation);
        } else {
            foreach ($childtabs as $childtab) {

                if ($childtab['relation_type'] === 'hasMany') {

                    $parent_tab_relation[] = [
                        'relation_name'            => $childtab['relation_type'],
                        'relation_table_first'     => $childtab['table'],
                        'relation_table_second'    => '',
                        'relation_first_argument'  => $childtab['foreign_key'],
                        'relation_second_argument' => $childtab['local_key'],
                        'relation_third_argument'  => '',
                        'relation_fourth_argument' => '',
                    ];

                } elseif ($childtab['relation_type'] === 'belongsToMany') {

                    $parent_tab_relation[] = [
                        'relation_name'            => $childtab['relation_type'],
                        'relation_table_first'     => $childtab['table'],
                        'relation_table_second'    => '',
                        'relation_first_argument'  => $childtab['ref_table'],
                        'relation_second_argument' => $childtab['foreign_key'],
                        'relation_third_argument'  => $childtab['local_key'],
                        'relation_fourth_argument' => '',
                    ];

                } else {
                    //skip to insert relation
                }
            }

            // insert new relation
            $parent_relations = $parent_tab_relation;
        }

        $parent_settings = [
            'defaultMigration'     => $parent_table->settings['migrationProperties'],
            'migrationProperties'  => $parent_table->settings['migrationProperties'],
            'htmlProperties'       => $parent_table->settings['htmlProperties'],
            'validationProperties' => $parent_table->settings['validationProperties'],
            'relationProperties'   => $parent_relations,
        ];

        // update relation into table in mystudio table
        $addrelation           = MyStudio::find($parent_table->id);
        $addrelation->settings = $parent_settings;
        $addrelation->update();

        // update each child tab table relation with parent table
        foreach ($childtabs as $childtab) {

            $child_table = MyStudio::find($childtab['table_id']);

            // define variable
            $child_tab_relation = [];

            //Get relation data from child tab table settings attribute
            $child_relations = $child_table->settings['relationProperties'];

            // decide inverse relation based on relation type
            $inverse_relation = match($childtab['relation_type']) {
                'hasMany' => 'belongsTo',
                'belongsToMany' => 'belongsToMany',
            default=> '',
            };

            if (!empty($child_relations)) {
                $collect_child_tab_relation = collect($child_relations);

                // check if relation already create on table or not
                if (count($collect_child_tab_relation->where('relation_name', $childtab['relation_type'])->where('relation_table_first', $inverse_relation)) > 0) {
                    //skip to save relation
                } else {
                    // check relation type and store based on relation type in to $tab_relation
                    if ($childtab['relation_type'] === 'hasMany') {

                        $child_tab_relation[] = [
                            'relation_name'            => $inverse_relation,
                            'relation_table_first'     => $childtab['parent_table'],
                            'relation_table_second'    => '',
                            'relation_first_argument'  => $childtab['foreign_key'],
                            'relation_second_argument' => $childtab['local_key'],
                            'relation_third_argument'  => '',
                            'relation_fourth_argument' => '',
                        ];

                    } elseif ($childtab['relation_type'] === 'belongsToMany') {

                        $child_tab_relation[] = [
                            'relation_name'            => $inverse_relation,
                            'relation_table_first'     => $childtab['parent_table'],
                            'relation_table_second'    => '',
                            'relation_first_argument'  => $childtab['ref_table'],
                            'relation_second_argument' => $childtab['local_key'],
                            'relation_third_argument'  => $childtab['foreign_key'],
                            'relation_fourth_argument' => '',
                        ];

                    } else {
                        //skip to insert relation
                    }
                }

                // merge existing relation with new relation
                $child_relations = array_merge($child_relations, $child_tab_relation);
            } else {
                // check relation type and store based on relation type in to $child_tab_relation
                if ($childtab['relation_type'] === 'hasMany') {

                    $child_tab_relation = [
                        'relation_name'            => $inverse_relation,
                        'relation_table_first'     => $childtab['parent_table'],
                        'relation_table_second'    => '',
                        'relation_first_argument'  => $childtab['foreign_key'],
                        'relation_second_argument' => $childtab['local_key'],
                        'relation_third_argument'  => '',
                        'relation_fourth_argument' => '',
                    ];

                } elseif ($childtab['relation_type'] === 'belongsToMany') {

                    $child_tab_relation = [
                        'relation_name'            => $inverse_relation,
                        'relation_table_first'     => $childtab['parent_table'],
                        'relation_table_second'    => '',
                        'relation_first_argument'  => $childtab['ref_table'],
                        'relation_second_argument' => $childtab['local_key'],
                        'relation_third_argument'  => $childtab['foreign_key'],
                        'relation_fourth_argument' => '',
                    ];

                } else {
                    //skip to insert relation
                    $child_tab_relation = [];
                }

                // insert new relation
                $child_relations = [$child_tab_relation];
            }

            $child_settings = [
                'defaultMigration'     => $child_table->settings['migrationProperties'],
                'migrationProperties'  => $child_table->settings['migrationProperties'],
                'htmlProperties'       => $child_table->settings['htmlProperties'],
                'validationProperties' => $child_table->settings['validationProperties'],
                'relationProperties'   => $child_relations,
            ];

            // update relation into child table in mystudio table
            $addsubrelation           = MyStudio::find($child_table->id);
            $addsubrelation->settings = $child_settings;
            $addsubrelation->update();

        }

        // store tab data in tab table
        $tab = Tab::create([
            'name'     => $parent_form->name,
            'settings' => $data,
        ]);

        return redirect()->route('tabs.index')->with('success', 'Tab create successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($tab_id)
    {

        $tab         = Tab::find($tab_id);
        $countSubtab = count($tab->settings['subtab']);

        // get list of column based-on form selected for each subtab
        // store new subtab data into $newTabData
        foreach ($tab->settings['subtab'] as $subtab) {
            // get form details based on id stored

            // $columns by default value
            $columns = '';
            // get table column from reference table if it has belongsToMany relation
            if ($subtab['relation_type'] === 'belongsToMany') {
                $relation_table = MyStudio::find($subtab['ref_table_id']);
                $columns        = $relation_table->settings['migrationProperties'];
            }

            $newTabData[] = [
                "parent_table"  => $subtab['parent_table'],
                "form"          => $subtab['form'],
                "form_id"       => $subtab['form_id'],
                "table"         => $subtab['table'],
                "table_id"      => $subtab['table_id'],
                "title"         => $subtab['title'],
                "relation_type" => $subtab['relation_type'],
                "ref_table"     => $subtab['ref_table'],
                "ref_table_id"  => $subtab['ref_table_id'],
                "foreign_key"   => $subtab['foreign_key'],
                "local_key"     => $subtab['local_key'],
                'list_column'   => $columns,
            ];

        }

        return view('mystudio.tab.show', [
            'tab'      => Tab::find($tab_id),
            'forms'    => MyStudio::where('type', 'form')->get(),
            'tables'   => MyStudio::where('type', 'table')->get(),
            'refs'     => MyStudio::where('type', 'form')->first(),
            'countTab' => $countSubtab,
            'subtabs'  => $newTabData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($tab_id)
    {
        $tab         = Tab::find($tab_id);
        $countSubtab = count($tab->settings['subtab']);

        // get list of column based-on form selected for each subtab
        // store new subtab data into $newTabData
        foreach ($tab->settings['subtab'] as $subtab) {
            // get form details based on id stored

            // $columns by default value
            $columns = '';
            // get table column from reference table if it has belongsToMany relation
            if ($subtab['relation_type'] === 'belongsToMany') {
                $relation_table = MyStudio::find($subtab['ref_table_id']);
                $columns        = $relation_table->settings['migrationProperties'];
            }

            $newTabData[] = [
                "parent_table"  => $subtab['parent_table'],
                "form"          => $subtab['form'],
                "form_id"       => $subtab['form_id'],
                "table"         => $subtab['table'],
                "table_id"      => $subtab['table_id'],
                "title"         => $subtab['title'],
                "relation_type" => $subtab['relation_type'],
                "ref_table"     => $subtab['ref_table'],
                "ref_table_id"  => $subtab['ref_table_id'],
                "foreign_key"   => $subtab['foreign_key'],
                "local_key"     => $subtab['local_key'],
                'list_column'   => $columns,
            ];

        }

        return view('mystudio.tab.edit', [
            'tab'      => Tab::find($tab_id),
            'forms'    => MyStudio::where('type', 'form')->get(),
            'tables'   => MyStudio::where('type', 'table')->get(),
            'refs'     => MyStudio::where('type', 'form')->first(),
            'countTab' => $countSubtab,
            'subtabs'  => $newTabData,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $tab_id)
    {
        $parent_form  = MyStudio::find($request->form);
        $parent_table = MyStudio::find($request->table);

        // get data for subtab table
        foreach ($request->child as $child) {

            $child_form  = MyStudio::find($child['form']);
            $child_table = MyStudio::find($child['table']);

            // set foriegnKey & localKey basedon relation type
            if ($child['relation_type'] === 'hasMany') {
                $foreign_key  = $child['hasMany_foreignKey'];
                $local_key    = $child['hasMany_localKey'];
                $ref_table    = '';
                $ref_table_id = '';
            } else {
                $foreign_key    = $child['belongsToMany_foreignKey'];
                $local_key      = $child['belongsToMany_localKey'];
                $relation_table = MyStudio::find($child['relation_table']);
                $ref_table      = Str::snake(Str::plural($relation_table->name));
                $ref_table_id   = $relation_table->id;
            }

            $childtabs[] = [
                'parent_table'  => Str::snake(Str::plural($parent_table->name)),
                'form'          => $child_form->name,
                'form_id'       => $child_form->id,
                'table'         => Str::snake(Str::plural($child_table->name)),
                'table_id'      => $child_table->id,
                'title'         => $child['title'],
                'relation_type' => $child['relation_type'],
                'ref_table'     => $ref_table,
                'ref_table_id'  => $ref_table_id,
                'foreign_key'   => $foreign_key,
                'local_key'     => $local_key,
            ];

        }

        // store parent tab and child tab into data
        $data = [
            'form'     => $parent_form->name,
            'form_id'  => $parent_form->id,
            'table'    => Str::snake(Str::plural($parent_table->name)),
            'table_id' => $parent_table->id,
            'title'    => $request->title,
            'subtab'   => $childtabs,
        ];

        // update parent table relation with child table

        //Get relation data from parent table settings attribute
        $parent_table_relations = $parent_table->settings['relationProperties'];

        if (!empty($parent_table_relations)) {
            $collect_relation = collect($parent_table_relations);
            // define variable
            $parent_tab_relation = [];
            foreach ($childtabs as $childtab) {
                // check if relation already create on table or not
                if (count($collect_relation->where('relation_name', $childtab['relation_type'])->where('relation_table_first', $childtab['table'])) > 0) {
                    //skip to insert relation
                } else {
                    // check relation type and store based on relation type in to $tab_relation
                    if ($childtab['relation_type'] === 'hasMany') {

                        $parent_tab_relation[] = [
                            'relation_name'            => $childtab['relation_type'],
                            'relation_table_first'     => $childtab['table'],
                            'relation_table_second'    => '',
                            'relation_first_argument'  => $childtab['foreign_key'],
                            'relation_second_argument' => $childtab['local_key'],
                            'relation_third_argument'  => '',
                            'relation_fourth_argument' => '',
                        ];

                    } elseif ($childtab['relation_type'] === 'belongsToMany') {

                        $parent_tab_relation[] = [
                            'relation_name'            => $childtab['relation_type'],
                            'relation_table_first'     => $childtab['table'],
                            'relation_table_second'    => '',
                            'relation_first_argument'  => $childtab['ref_table'],
                            'relation_second_argument' => $childtab['foreign_key'],
                            'relation_third_argument'  => $childtab['local_key'],
                            'relation_fourth_argument' => '',
                        ];

                    } else {
                        $parent_table_relation = [];
                    }
                }
            }

            // merge existing relation with new relation
            $parent_relations = array_merge($parent_table_relations, $parent_tab_relation);
        } else {
            foreach ($childtabs as $childtab) {

                if ($childtab['relation_type'] === 'hasMany') {

                    $parent_tab_relation[] = [
                        'relation_name'            => $childtab['relation_type'],
                        'relation_table_first'     => $childtab['table'],
                        'relation_table_second'    => '',
                        'relation_first_argument'  => $childtab['foreign_key'],
                        'relation_second_argument' => $childtab['local_key'],
                        'relation_third_argument'  => '',
                        'relation_fourth_argument' => '',
                    ];

                } elseif ($childtab['relation_type'] === 'belongsToMany') {

                    $parent_tab_relation[] = [
                        'relation_name'            => $childtab['relation_type'],
                        'relation_table_first'     => $childtab['table'],
                        'relation_table_second'    => '',
                        'relation_first_argument'  => $childtab['ref_table'],
                        'relation_second_argument' => $childtab['foreign_key'],
                        'relation_third_argument'  => $childtab['local_key'],
                        'relation_fourth_argument' => '',
                    ];

                } else {
                    //skip to insert relation
                }
            }

            // insert new relation
            $parent_relations = $parent_tab_relation;
        }

        $parent_settings = [
            'defaultMigration'     => $parent_table->settings['migrationProperties'],
            'migrationProperties'  => $parent_table->settings['migrationProperties'],
            'htmlProperties'       => $parent_table->settings['htmlProperties'],
            'validationProperties' => $parent_table->settings['validationProperties'],
            'relationProperties'   => $parent_relations,
        ];

        // update relation into table in mystudio table
        $addrelation           = MyStudio::find($parent_table->id);
        $addrelation->settings = $parent_settings;
        $addrelation->update();

        // update each child tab table relation with parent table
        foreach ($childtabs as $childtab) {

            $child_table = MyStudio::find($childtab['table_id']);

            // define variable
            $child_tab_relation = [];

            //Get relation data from child tab table settings attribute
            $child_relations = $child_table->settings['relationProperties'];

            // decide inverse relation based on relation type
            $inverse_relation = match($childtab['relation_type']) {
                'hasMany' => 'belongsTo',
                'belongsToMany' => 'belongsToMany',
            default=> '',
            };

            if (!empty($child_relations)) {
                $collect_child_tab_relation = collect($child_relations);

                // check if relation already create on table or not
                if (count($collect_child_tab_relation->where('relation_name', $childtab['relation_type'])->where('relation_table_first', $inverse_relation)) > 0) {
                    //skip to save relation
                } else {
                    // check relation type and store based on relation type in to $tab_relation
                    if ($childtab['relation_type'] === 'hasMany') {

                        $child_tab_relation[] = [
                            'relation_name'            => $inverse_relation,
                            'relation_table_first'     => $childtab['parent_table'],
                            'relation_table_second'    => '',
                            'relation_first_argument'  => $childtab['foreign_key'],
                            'relation_second_argument' => $childtab['local_key'],
                            'relation_third_argument'  => '',
                            'relation_fourth_argument' => '',
                        ];

                    } elseif ($childtab['relation_type'] === 'belongsToMany') {

                        $child_tab_relation[] = [
                            'relation_name'            => $inverse_relation,
                            'relation_table_first'     => $childtab['parent_table'],
                            'relation_table_second'    => '',
                            'relation_first_argument'  => $childtab['ref_table'],
                            'relation_second_argument' => $childtab['local_key'],
                            'relation_third_argument'  => $childtab['foreign_key'],
                            'relation_fourth_argument' => '',
                        ];

                    } else {
                        //skip to insert relation
                    }
                }

                // merge existing relation with new relation
                $child_relations = array_merge($child_relations, $child_tab_relation);
            } else {
                // check relation type and store based on relation type in to $child_tab_relation
                if ($childtab['relation_type'] === 'hasMany') {

                    $child_tab_relation = [
                        'relation_name'            => $inverse_relation,
                        'relation_table_first'     => $childtab['parent_table'],
                        'relation_table_second'    => '',
                        'relation_first_argument'  => $childtab['foreign_key'],
                        'relation_second_argument' => $childtab['local_key'],
                        'relation_third_argument'  => '',
                        'relation_fourth_argument' => '',
                    ];

                } elseif ($childtab['relation_type'] === 'belongsToMany') {

                    $child_tab_relation = [
                        'relation_name'            => $inverse_relation,
                        'relation_table_first'     => $childtab['parent_table'],
                        'relation_table_second'    => '',
                        'relation_first_argument'  => $childtab['ref_table'],
                        'relation_second_argument' => $childtab['local_key'],
                        'relation_third_argument'  => $childtab['foreign_key'],
                        'relation_fourth_argument' => '',
                    ];

                } else {
                    //skip to insert relation
                    $child_tab_relation = [];
                }

                // insert new relation
                $child_relations = [$child_tab_relation];
            }

            $child_settings = [
                'defaultMigration'     => $child_table->settings['migrationProperties'],
                'migrationProperties'  => $child_table->settings['migrationProperties'],
                'htmlProperties'       => $child_table->settings['htmlProperties'],
                'validationProperties' => $child_table->settings['validationProperties'],
                'relationProperties'   => $child_relations,
            ];

            // update relation into child table in mystudio table
            $addsubrelation           = MyStudio::find($child_table->id);
            $addsubrelation->settings = $child_settings;
            $addsubrelation->update();

        }

        // update tab data in tab table
        $tab = Tab::find($tab_id);
        $tab->update([
            'name'     => $parent_form->name,
            'settings' => $data,
        ]);

        return redirect()->route('tabs.show', $tab_id)->with('success', 'Tab updated successfully');

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
