@extends('mixdinternet/admix::index')

@section('title')
    Listagem de emails
@endsection

@section('btn-insert')
    @if((!checkRule('admin.newsletters.trash')) && (!$trash))
        @include('mixdinternet/admix::partials.actions.btn.trash', ['route' => route('admin.newsletters.trash')])
    @endif
    @if($trash)
        @include('mixdinternet/admix::partials.actions.btn.list', ['route' => route('admin.newsletters.index')])
    @endif
@endsection

@section('btn-delete-all')
    @if((!checkRule('admin.newsletters.destroy')) && (!$trash))
        @include('mixdinternet/admix::partials.actions.btn.delete-all', ['route' => route('admin.newsletters.destroy')])
    @endif
@endsection

@section('search')
    {!! Form::model($search, ['route' => ($trash) ? 'admin.newsletters.trash' : 'admin.newsletters.index', 'method' => 'get', 'id' => 'form-search'
        , 'class' => '']) !!}
    <div class="row">
        @if(config('mnewsletters.fields.name') !== false)
            <div class="col-md-4">
                {!! BootForm::text('name', 'Nome') !!}
            </div>
        @endif
        <div class="col-md-4">
            {!! BootForm::text('email', 'Email') !!}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="pull-right">
                <a href="/admix/newsletters/download?{{ http_build_query($search) }}" class="btn btn-default btn-flat" >
                    <i class="fa fa-download"></i>
                    <i class="fs-normal hidden-xs texto-download">Download</i>
                </a>
                <a href="{{ route(($trash) ? 'admin.newsletters.trash' : 'admin.newsletters.index') }}"
                   class="btn btn-default btn-flat">
                    <i class="fa fa-list"></i>
                    <i class="fs-normal hidden-xs">Mostrar tudo</i>
                </a>
                <button class="btn btn-success btn-flat">
                    <i class="fa fa-search"></i>
                    <i class="fs-normal hidden-xs">Buscar</i>
                </button>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@endsection

@section('table')
    @if (count($newsletters) > 0)
        <table class="table table-striped table-hover table-action jq-table-rocket">
            <thead>
            <tr>
                @if((!checkRule('admin.newsletters.destroy')) && (!$trash))
                    <th>
                        <div class="checkbox checkbox-flat">
                            <input type="checkbox" id="checkbox-all">
                            <label for="checkbox-all">
                            </label>
                        </div>
                    </th>
                @endif
                <th>{!! columnSort('#', ['field' => 'id', 'sort' => 'asc']) !!}</th>
                @if(config('mnewsletters.fields.name') !== false)
                    <th>{!! columnSort('Nome', ['field' => 'name', 'sort' => 'asc']) !!}</th>
                @endif
                <th>{!! columnSort('Email', ['field' => 'email', 'sort' => 'asc']) !!}</th>
                <th>{!! columnSort('Data de cadastro', ['field' => 'created_at', 'sort' => 'asc']) !!}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($newsletters as $newsletter)
                <tr>
                    @if((!checkRule('admin.newsletters.destroy')) && (!$trash))
                        <td>
                            @include('mixdinternet/admix::partials.actions.checkbox', ['row' => $newsletter])
                        </td>
                    @endif
                    <td>{{ $newsletter->id }}</td>
                    @if (config('mnewsletters.fields.name') !== false)
                        <td>{{ $newsletter->name }}</td>
                    @endif
                    <td>{{ $newsletter->email }}</td>
                    <td>{{ $newsletter->created_at->format('d/m/Y') }}</td>
                    <td>
                        @if((!checkRule('admin.newsletters.destroy')) && (!$trash))
                            @include('mixdinternet/admix::partials.actions.btn.delete', ['route' => route('admin.newsletters.destroy'), 'id' => $newsletter->id])
                        @endif
                        @if($trash)
                            @include('mixdinternet/admix::partials.actions.btn.restore', ['route' => route('admin.newsletters.restore', ['newsletters' => $newsletter->id]), 'id' => $newsletter->id])
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        @include('mixdinternet/admix::partials.nothing-found')
    @endif
@endsection

@section('pagination')
    {!! $newsletters->appends(request()->except(['page']))->render() !!}
@endsection

@section('pagination-showing')
    @include('mixdinternet/admix::partials.pagination-showing', ['model' => $newsletters])
@endsection