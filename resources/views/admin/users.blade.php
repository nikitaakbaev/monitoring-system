<x-layout>
    <h1>Пользователи</h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Активен</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->last_name }} {{ $user->first_name }} {{ $user->middle_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role->role_name ?? '' }}</td>
                <td>{{ $user->is_active ? 'Да' : 'Нет' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.users.block', $user) }}" class="d-inline">
                        @csrf
                        <button class="btn btn-sm btn-warning">Блокировать</button>
                    </form>
                    <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</x-layout>
