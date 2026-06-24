{{-- This file is used for menu items by any Backpack v7 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Servicos" icon="la la-question" :link="backpack_url('servico')" />
<x-backpack::menu-item title="Barbeiros" icon="la la-question" :link="backpack_url('barbeiro')" />
<x-backpack::menu-item title="Users" icon="la la-question" :link="backpack_url('user')" />
<x-backpack::menu-item title="Produtos" icon="la la-question" :link="backpack_url('produto')" />
<x-backpack::menu-dropdown title="Autenticação" icon="la la-lock">
    <x-backpack::menu-dropdown-item title="Usuários" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Papéis (Roles)" icon="la la-id-badge" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Permissões" icon="la la-key" :link="backpack_url('permission')" />
</x-backpack::menu-dropdown>