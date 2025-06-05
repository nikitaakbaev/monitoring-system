<x-layout>
    <div class="d-flex justify-content-center align-items-center h-100">
        <form class="col-sm-7 col-lg-4 col-md-6 col-12 p-3 d-flex flex-column border rounded-3" action="{{ Route('authUser') }}"
              method="POST">
            @csrf
            @method('POST')
            @if ($errors->any())
                <div class="alert alert-warning" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li> {{ $error }} </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-3">
                <label for="email" class="form-label">Почта</label>
                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Пароль</label>
                <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1" name="remember">
                <label class="form-check-label" for="exampleCheck1">Запомнить это устройство?</label>
            </div>
            <button type="submit" class="btn btn-primary">Войти</button>
        </form>
    </div>
</x-layout>
