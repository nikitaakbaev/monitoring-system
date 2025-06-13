<x-layout>
    <div class="d-flex justify-content-center align-items-center h-100">
        <form action="{{Route('createUserAccount')}}" method="POST" class="col-sm-7 col-md-6 col-lg-4 col-12 p-3 d-flex flex-column border rounded-3" id="addUserForm">
            @csrf
            @method('POST')
            @if ($errors -> any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors -> all() as $error)
                            <li>
                                {{$error}}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="alert alert-success d-none" id="addUserResponse"></div>
            <div class="mb-3">
                <label for="first_name" class="form-label">Фамилия</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{old('first_name"')}}">
            </div>
            <div class="mb-3">
                <label for="middle_name" class="form-label">Имя</label>
                <input type="text" name="middle_name" id="middle_name" class="form-control" value="{{old('middle_name')}}">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Отчество</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{old('last_name')}}">
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Выберите роль</label>
                <select class="form-select" name="roleID" id="role">
                    <option value="1">Админ</option>
                    <option value="2">Учитель</option>
                    <option value="3">Родитель</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Почта</label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Создать пользователя</button>
        </form>
    </div>
</x-layout>
