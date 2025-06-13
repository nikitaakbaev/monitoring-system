<x-layout>
    <div class="container py-5">
        <h1>Управление пользователями</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Форма фильтрации -->
        <form method="GET" action="{{ route('usersList') }}" class="mb-4 form-inline">
            <div class="form-group mr-2">
                <label for="name" class="mr-2">Имя:</label>
                <input type="text" name="name" id="name" value="{{ request('name') }}" class="form-control" placeholder="Введите имя">
            </div>
            <div class="form-group mr-2">
                <label for="role" class="mr-2">Роль:</label>
                <select name="role" id="role" class="form-control">
                    <option value="">Все роли</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" @if(request('role') == $role->id) selected @endif>
                            {{ $role->role_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Найти</button>
        </form>

        <!-- Таблица пользователей -->
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ФИО</th>
                    <th>Email</th>
                    <th>Телефон</th>
                    <th>Адрес</th>
                    <th>Дата рождения</th>
                    <th>Роль</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->first_name }} {{ $user->middle_name }} {{ $user->last_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->birth_date }}</td>
                        <td>{{ $user->role ? $user->role->role_name : 'Нет роли' }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal{{ $user->id }}">
                                Редактировать
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Пользователи не найдены.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <!-- Модальные окна для редактирования -->
        @foreach($users as $user)
            <!-- Модальное окно -->
            <div class="modal fade" id="editModal{{ $user->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $user->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="editModalLabel{{ $user->id }}">
                                    Редактировать: {{ $user->first_name }} {{ $user->middle_name }}
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                            </div>

                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label>Фамилия</label>
                                    <input type="text" name="first_name" value="{{ $user->first_name }}" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Имя</label>
                                    <input type="text" name="middle_name" value="{{ $user->middle_name }}" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Отчество</label>
                                    <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" value="{{ $user->email }}" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Телефон</label>
                                    <input type="text" name="phone" value="{{ $user->phone }}" class="form-control phone-input" id="phone{{ $user->id }}">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Адрес</label>
                                    <input type="text" name="address" value="{{ $user->address }}" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Дата рождения</label>
                                    <input type="date" name="birth_date" value="{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('Y-m-d') : '' }}" class="form-control">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Роль</label>
                                    <select name="roleID" class="form-control">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->id }}" @if($role->id == $user->roleID) selected @endif>
                                                {{ $role->role_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
    <script>
        const phoneInputs = document.querySelectorAll('.phone-input');

        phoneInputs.forEach(input => {
            input.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');

                if (value.startsWith('7')) {
                    value = value.slice(1);
                }

                if (value.length > 10) {
                    value = value.slice(0, 10);
                }

                let formattedValue = '+7 ';

                if (value.length > 0) {
                    formattedValue += '(' + value.substring(0, 3);
                }
                if (value.length >= 4) {
                    formattedValue += ') ' + value.substring(3, 6);
                }
                if (value.length >= 7) {
                    formattedValue += '-' + value.substring(6, 8);
                }
                if (value.length >= 9) {
                    formattedValue += '-' + value.substring(8, 10);
                }

                e.target.value = formattedValue;
            });
        });

    </script>
</x-layout>
