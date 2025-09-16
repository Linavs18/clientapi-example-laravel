@extends('templates.base')
@section('title', 'Tipo de actividades')
@section('header', 'Tipo de actividades')
@section('content')

<div class="row">
    <div class="col-lg-12 mb-4 d-grid gap-2 d-md-block">
        <a href="{{ route('type_activity.create') }}" class="btn btn-primary">Crear</a>
    </div>
</div>

@include('templates.messages')

<div class="row">
    <div class="col-lg-12 mb-4">
        <table id="table_data" class="table table-striped table-hover text-center">
            <thead>
                <tr>
                <th>Id</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
                @foreach ($typeActivities as $typeActivity)
                <tr>
                    <td>{{ $typeActivity["id"] }}</td>
                    <td>{{ $typeActivity["description"] }}</td>
                    <td>
                        <a href="{{ route('type_activity.edit', $typeActivity["id"]) }}"  class="btn btn-primary btn-circle" title="Editar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="{{ route('type_activity.destroy', $typeActivity["id"]) }}" class="btn btn-danger btn-circle" title="Eliminar" onclick="return remove();">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>


@endsection

@section('scripts')
    <script src="{{ asset('js/general.js') }}"></script>
@endsection