<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CategoryCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CategoryCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Category::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/category');
        CRUD::setEntityNameStrings('category', 'categories');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumns([
                [
                    'name'      => 'photo', // The db column name
                    'label'     => 'Фото', // Table column heading
                    'type'      => 'image',
                     'prefix' => 'storage/',
                    // image from a different disk (like s3 bucket)
                    // 'disk'   => 'disk-name',
                    // optional width/height if 25px is not ok with you
                     'height' => '150px',
                     'width'  => '250px',
                ],
                [
                    // 1-n relationship
                    'label' => 'Родительская категории', // Table column heading
                    'type' => 'checklist',
                    'name' => 'parent_id', // the column that contains the ID of that connected entity;
                    'entity' => 'parent', // the method that defines the relationship in your Model
                    'attribute' => 'name', // foreign key attribute that is shown to user
                    'model' => "App\Models\Category", // foreign key model
                ],
                [
                    'name'  => 'name',
                    'label' => 'Название категории',
                    'type'  => 'text'
                ],
                [
                    'name'  => 'is_active',
                    'label' => 'Статус',
                    'type'  => 'boolean',
                     'options' => [0 => 'Не Активен', 1 => 'Активен']
                ]
            ]
        );
//        CRUD::setFromDb(); // set columns from db columns.
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CategoryRequest::class);

        CRUD::field([
            'label'     => "Главная категория",
            'type'      => 'select',
            'name'      => 'parent_id',

            'entity'    => 'parent',

            'model'     => "App\Models\Category",
            'attribute' => 'name',

            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->whereNull('parent_id')->get();
            }),
        ]);

        CRUD::field([   // Text
            'name'  => 'name',
            'label' => "Название категории",
            'type'  => 'text',
        ]);

        CRUD::field([   // Upload
            'name'      => 'photo',
            'label'     => 'Фото',
            'type'      => 'upload',
            'withFiles' => true
        ]);

        CRUD::field([   // Checkbox
            'name'  => 'is_active',
            'label' => 'Активный?',
            'type'  => 'checkbox'
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    public function autoSetupShowOperation()
    {
        $this->setupListOperation();
    }
}
