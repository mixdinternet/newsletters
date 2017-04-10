@extends('mixdinternet/admix::form')

@section('title')
    Gerenciar newsletters
@endsection

@section('form')
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs pull-right">
            <li class="active"><a href="#tab_geral" data-toggle="tab">Geral</a></li>
        </ul>
        {!! BootForm::horizontal(['model' => $newsletter, 'store' => 'admin.newsletters.store', 'update' => 'admin.newsletters.update'
            , 'id' => 'form-model', 'class' => 'form-horizontal form-rocket jq-form-validate jq-form-save'
            , 'files' => true ]) !!}
        <div class="tab-content">
            <div class="tab-pane active" id="tab_geral">
                <div class="row">
                    <div class="col-md-10">
                        <div class="tab-content">
                            @if ($newsletter['id'])
                                {!! BootForm::text('id', 'Código', null, ['disabled' => true]) !!}
                            @endif
                                {!! BootForm::text('name', 'Nome', $newsletter->name, ['data-rule-required' => true, 'maxlength' => '150']) !!}
                                {!! BootForm::text('email', 'Email', $newsletter->email, ['data-rule-required' => true, 'maxlength' => '150']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! BootForm::close() !!}
    </div>
@endsection