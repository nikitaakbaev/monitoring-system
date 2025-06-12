<x-layout>
    <h1>Роли пользователей</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Пользователь</th>
                <th>Текущая роль</th>
                <th>Изменить</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->last_name }} {{ $user->first_name }}</td>
                <td>{{ $user->role->role_name ?? '' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.roles.update', $user) }}" class="d-flex">
                        @csrf
                        <select name="roleID" class="form-select me-2">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @selected($role->id == $user->roleID)>{{ $role->role_name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-primary">Сохранить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
