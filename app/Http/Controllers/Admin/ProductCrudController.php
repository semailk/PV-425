<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProductRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ProductCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ProductCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Product::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/product');
        CRUD::setEntityNameStrings('product', 'products');
    }

    protected function setupListOperation()
    {
        $this->crud->addColumns([
                [
                    'name' => 'image',
                    'label' => 'Фото',
                    'type' => 'image',
                    'prefix' => 'storage/',
                    'height' => '150px',
                    'width' => '250px',
                ],
                [
                    'label' => 'Родительская категории',
                    'type' => 'checklist',
                    'name' => 'category_id',
                    'entity' => 'category',
                    'attribute' => 'name',
                ],
                [
                    'name'  => 'name',
                    'label' => 'Название продукта',
                    'type'  => 'text'
                ],
                [
                    'name'  => 'price',
                    'label' => 'Цена',
                    'type'  => 'text',
                    'prefix' => "$",
                ]
            ]
        );
    }


    protected function setupCreateOperation()
    {
        CRUD::setValidation(ProductRequest::class);
        CRUD::setFromDb(); // set fields from db columns.

        CRUD::field([
            'label'     => "Категория",
            'type'      => 'select',
            'name'      => 'category_id',

            'entity'    => 'category',

            'model'     => "App\Models\Category",
            'attribute' => 'name',

            'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->whereNotNull('parent_id')->get();
            }),
        ]);

        CRUD::field([   // Upload
            'name' => 'image',
            'label' => 'Фото',
            'type' => 'upload',
            'withFiles' => true,
            'path' => 'products/',
        ]);
    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        CRUD::addField([
            'name' => 'current_image',
            'label' => 'Текущие изображения',
            'type' => 'view',
            'view' => 'admin.image-preview',
            'tab' => 'Основное',
        ]);

        // Поле для замены изображения
        CRUD::field('image')
            ->label('Заменить изображение')
            ->type('upload')
            ->upload(true)
//            ->disk('public')
            ->hint('Если вы загрузите новое изображение — старое будет автоматически удалено.')
            ->wrapper(['class' => 'form-group col-md-12']);
    }
}
