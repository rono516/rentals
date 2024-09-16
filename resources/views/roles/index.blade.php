@extends('layouts.app', ['pageTitle' => 'Roles'])

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-md-6">
            <p class="text-end">
                <a href="{{ route('roles.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Add Role
                </a>
            </p>
            <h1 class="m-0">Roles</h1>
            <table class="table" id="datatable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col" class="text-center">Users</th>
                        <th scope="col">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $index => $role)
                        <tr>
                            <th scope="row">{{ ++$index }}</th>
                            <td>{{ $role->name }}</td>
                            <td class="text-center">{{ $role->users()->count() }}</td>
                            <td class="text-end">
                                <a href="{{ route('roles.delete', ['roleUuid' => $role->uuid]) }}" class="text-danger text-decoration-none">Delete</a>
                                -
                                <a href="{{ route('roles.edit', ['roleUuid' => $role->uuid]) }}" class="text-decoration-none">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
