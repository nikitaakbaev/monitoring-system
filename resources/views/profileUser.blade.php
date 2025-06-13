<x-layout>
    @php
        function wordToColor($word) {
            $sum = 0;
            $length = strlen($word);

            for ($i = 0; $i < $length; $i++) {
                $char = $word[$i];
                $ascii = ord($char);
                $sum += $ascii;
            }

            $r = ($sum * 13) % 256;
            $g = ($sum * 27) % 256;
            $b = ($sum * 55) % 256;

            return "rgb($r, $g, $b)";
        }

        $bgWord = Auth::user()->first_name;
        $textWord = Auth::user()->middle_name;

        $bgColor = wordToColor($bgWord);
        $textColor = wordToColor($textWord);

        $initial = mb_substr($bgWord, 0, 1);

        $birthDate = '';
        if (Auth::user()->birth_date) {
            try {
                $birthDate = \Carbon\Carbon::parse(Auth::user()->birth_date)->format('Y-m-d');
            } catch (\Exception $e) {
                $birthDate = '';
            }
        }
    @endphp

    <section>
        <div class="container py-5">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <div class="row">
                <!-- Левая колонка профиля (аватар, имя, роль) -->
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body d-flex align-items-center justify-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 100px; height: 100px; background-color: {{ $bgColor }};">
                                <p class="pt-2 display-4 text-light" style="font-size: 54px;">{{ $initial }}</p>
                            </div>
                            <h5 class="my-3">{{ Auth::user()->first_name }} {{ Auth::user()->middle_name }}</h5>
                            <p class="text-muted mb-1">{{ Auth::user()->role->role_name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Правая колонка профиля (форма) -->
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- Форма профиля -->
                            <form action="{{ route('updateProfile') }}" method="POST">
                                @csrf
                                @method('POST')

                                <!-- Фамилия -->
                                <div class="row mb-3">
                                    <label for="first_name" class="col-sm-3 col-form-label">Фамилия</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="first_name" id="first_name" class="form-control"
                                               value="{{ Auth::user()->first_name }}">
                                    </div>
                                </div>
                                <hr>

                                <!-- Имя -->
                                <div class="row mb-3">
                                    <label for="middle_name" class="col-sm-3 col-form-label">Имя</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="middle_name" id="middle_name" class="form-control"
                                               value="{{ Auth::user()->middle_name }}">
                                    </div>
                                </div>
                                <hr>

                                <!-- Отчество -->
                                <div class="row mb-3">
                                    <label for="last_name" class="col-sm-3 col-form-label">Отчество</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="last_name" id="last_name" class="form-control"
                                               value="{{ Auth::user()->last_name }}">
                                    </div>
                                </div>
                                <hr>

                                <!-- Почта -->
                                <div class="row mb-3">
                                    <label for="email" class="col-sm-3 col-form-label">Почта</label>
                                    <div class="col-sm-9">
                                        <input type="email" id="email" name="email" class="form-control"
                                               value="{{ Auth::user()->email }}">
                                    </div>
                                </div>
                                <hr>

                                <!-- Дата рождения -->
                                <div class="row mb-3">
                                    <label for="birth_date" class="col-sm-3 col-form-label">Дата рождения</label>
                                    <div class="col-sm-9">
                                        <input type="date" id="birth_date" name="birth_date" class="form-control" value="{{ $birthDate }}">
                                    </div>
                                </div>
                                <hr>

                                <!-- Телефон -->
                                <div class="row mb-3">
                                    <label for="phone" class="col-sm-3 col-form-label">Телефон</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="phone" name="phone" class="form-control" value="{{ Auth::user()->phone ?? '' }}">
                                    </div>
                                </div>
                                <hr>

                                <!-- Адрес -->
                                <div class="row mb-3">
                                    <label for="address" class="col-sm-3 col-form-label">Адрес</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="address" name="address" class="form-control" value="{{ Auth::user()->address ?? '' }}">
                                    </div>
                                </div>
                                <hr>

                                <!-- Кнопки Сохранить и Выйти в одной строке -->
                                <div class="d-flex justify-content-end align-items-center gap-2">
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                    <a href="{{ route('logout') }}" class="btn btn-danger">Выйти из аккаунта</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Скрипт форматирования телефона -->
    <script>
        const phoneInput = document.getElementById('phone');

        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, ''); // Убираем все нецифровые символы

            if (value.startsWith('7')) {
                value = value.slice(1);
            }

            if (value.length > 10) {
                value = value.slice(0, 10); // Ограничиваем длину до 10 цифр
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
    </script>
</x-layout>
