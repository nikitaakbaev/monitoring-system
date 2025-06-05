<x-layout>
    <div class="d-flex justify-content-center align-items-center h-100">
        <form action="{{ Route('userPassChange') }}" method="POST"
              class="col-sm-7 col-md-6 col-lg-4 col-12 p-3 d-flex flex-column">
            @csrf
            @method('POST')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-3">
                <label for="old_password" class="form-label">Старый пароль</label>
                <input type="password" name="old_password" id="old_password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="new_password" class="form-label">Новый пароль</label>
                <input type="password" name="new_password" id="new_password" class="form-control">
            </div>

            <div class="mb-3">
                <label for="new_password_confirmation" class="form-label">Подтвердите пароль</label>
                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                       class="form-control">
            </div>
            <button type="submit" class="btn btn-primary">Сменить пароль</button>
        </form>
    </div>
</x-layout>
