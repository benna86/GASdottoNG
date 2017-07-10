<?php

if(isset($exclude_sender) == false)
    $exclude_sender = false;

if(isset($exclude_target) == false)
    $exclude_target = false;

?>

@if($movements->count() == 0)
    <div class="alert alert-info" role="alert">
        Non ci sono elementi da visualizzare.
    </div>
@else
    <table class="table">
        <thead>
            <tr>
                <th>Data</th>
                <th>Tipo</th>
                <th>Pagamento</th>
                @if($exclude_sender == false)
                    <th>Pagante</th>
                @endif
                @if($exclude_target == false)
                    <th>Pagato</th>
                @endif
                <th>Valore</th>
                @if(Gate::check('movements.admin', $currentgas))
                    <th>Modifica</th>
                @endif
            </tr>
        </thead>

        <tbody>
            @foreach($movements as $mov)
                <tr>
                    <td>{{ $mov->printableDate('registration_date') }}</td>
                    <td>{{ $mov->printableType() }}</td>
                    <td><span class="glyphicon {{ $mov->payment_icon }}" aria-hidden="true"></span></td>

                    @if($exclude_sender == false)
                        <td>{{ $mov->sender ? $mov->sender->printableName() : '' }}</td>
                    @endif

                    @if($exclude_target == false)
                        <td>{{ $mov->target ? $mov->target->printableName() : '' }}</td>
                    @endif

                    <td>{{ printablePrice($mov->amount) }} €</td>

                    @if(Gate::check('movements.admin', $currentgas))
                        <td>
                            <button class="btn btn-default async-modal" data-target-url="{{ url('/movements/' . $mov->id) }}">
                                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                            </button>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
