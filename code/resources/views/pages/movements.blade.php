@extends($theme_layout)

@section('content')

<div class="row">
    <div class="col-md-12">
        @can('movements.admin', $currentgas)
            @include('commons.addingbutton', [
                'typename' => 'movement',
                'typename_readable' => _i('Movimento'),
                'dynamic_url' => url('movements/create')
            ])

            @include('commons.importcsv', [
                'modal_id' => 'importCSVmovements',
                'import_target' => 'movements'
            ])

            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#creditsStatus">{{ _i('Stato Crediti') }}</button>
            <div class="modal fade dynamic-contents" id="creditsStatus" tabindex="-1" data-contents-url="{{ url('movements/showcredits') }}">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    </div>
                </div>
            </div>
        @endcan

        @can('movements.types', $currentgas)
            <button type="button" class="btn btn-default" data-toggle="collapse" data-target="#handleMovementTypes">{{ _i('Amministra Tipi Movimento') }}</button>
            <div class="collapse dynamic-contents" id="handleMovementTypes" tabindex="-1" data-contents-url="{{ url('movtypes') }}">
            </div>
        @endcan
    </div>

    <div class="clearfix"></div>
    <hr/>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-horizontal form-filler" data-action="{{ url('movements') }}" data-toggle="validator" data-fill-target="#movements-in-range">
            @include('commons.genericdaterange', [
                'start_date' => strtotime('-1 weeks'),
            ])
            @include('commons.selectmovementtypefield', ['show_all' => true])
            @include('commons.radios', [
                'name' => 'method',
                'label' => _i('Pagamento'),
                'values' => ['all' => (object)['name' => _i('Tutti'), 'checked' => true]] + App\MovementType::payments()
            ])
            @include('commons.selectobjfield', [
                'obj' => null,
                'name' => 'user_id',
                'label' => _i('Utente'),
                'objects' => App\User::orderBy('lastname', 'asc')->get(),
                'extra_selection' => [
                    '0' => _i('Nessuno')
                ]
            ])
            @include('commons.selectobjfield', [
                'obj' => null,
                'name' => 'supplier_id',
                'label' => _i('Fornitore'),
                'objects' => App\Supplier::orderBy('name', 'asc')->get(),
                'extra_selection' => [
                    '0' => _i('Nessuno')
                ]
            ])
            @include('commons.decimalfield', ['obj' => null, 'name' => 'amountstart', 'label' => _i('Importo Minimo'), 'is_price' => true])
            @include('commons.decimalfield', ['obj' => null, 'name' => 'amountend', 'label' => _i('Importo Massimo'), 'is_price' => true])

            <div class="form-group">
                <div class="col-sm-{{ $fieldsize }} col-md-offset-{{ $labelsize }}">
                    <button type="submit" class="btn btn-success">{{ _i('Ricerca') }}</button>
                    <a href="{{ url('movements?format=csv') }}" class="btn btn-default form-filler-download">{{ _i('Esporta CSV') }}</a>
                    <a href="{{ url('movements?format=pdf') }}" class="btn btn-default form-filler-download">{{ _i('Esporta PDF') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-md-offset-2 current-balance">
        @include('movement.status', ['obj' => $currentgas])
    </div>
</div>

<hr/>

<div class="row">
    <div class="col-md-12" id="movements-in-range">
        @include('movement.list', ['movements' => $movements])
    </div>
</div>

@include('commons.deleteconfirm', [
    'url' => 'movements',
    'password_protected' => true,
    'extra' => [
        'close-all-modal' => '1',
        'post-saved-function' => ['refreshFilter', 'refreshBalanceView']
    ]
])

@include('commons.passwordmodal')

@endsection
