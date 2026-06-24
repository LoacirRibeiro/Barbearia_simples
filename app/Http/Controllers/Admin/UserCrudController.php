<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('usuário', 'usuários');
    }

    /**
     * Define what happens when the List operation is loaded.
     */
    protected function setupListOperation()
    {
        CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addColumn(['name' => 'email', 'type' => 'email', 'label' => 'E-mail']);
        CRUD::addColumn(['name' => 'created_at', 'type' => 'datetime', 'label' => 'Criado em']);
    }

    /**
     * Define what happens when the Create operation is loaded.
     */
    protected function setupCreateOperation()
    {
        $this->crud->setValidation([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.CRUD::getCurrentEntryId(),
            'password' => CRUD::getCurrentEntryId() ? 'nullable|min:6' : 'required|min:6',
        ]);

        CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nome']);
        CRUD::addField(['name' => 'email', 'type' => 'email', 'label' => 'E-mail']);
        
        CRUD::addField([
            'name'  => 'password',
            'type'  => 'password',
            'label' => 'Senha',
            'hint'  => CRUD::getCurrentEntryId() ? 'Deixe em branco para manter a senha atual.' : 'Mínimo de 6 caracteres.'
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Intercepta a CRIAÇÃO para tratar a senha de forma correta
     */
    public function store()
    {
        $this->handlePasswordInput();
        return $this->traitStore();
    }

    /**
     * Intercepta a EDIÇÃO para tratar a senha de forma correta
     */
    public function update()
    {
        $this->handlePasswordInput();
        return $this->traitUpdate();
    }

    /**
     * Lógica unificada para garantir que a senha seja salva encriptada
     * apenas uma vez, ou removida se estiver em branco.
     */
    protected function handlePasswordInput()
    {
        $request = $this->crud->getRequest();

        // Se o campo de senha foi preenchido, aplica o Hash puro do Laravel antes de salvar
        if ($request->filled('password')) {
            $request->request->set('password', Hash::make($request->input('password')));
        } else {
            // Se veio vazio (no caso de edição), remove para manter a antiga
            $request->request->remove('password');
        }
    }
}