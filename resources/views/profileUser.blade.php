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
    @endphp
    <section>
        <div class="container py-5">
            {{--            <div class="row">--}}
            {{--                <div class="col">--}}
            {{--                    <nav aria-label="breadcrumb" class="bg-body-tertiary rounded-3 p-3 mb-4">--}}
            {{--                        <ol class="breadcrumb mb-0">--}}
            {{--                            <li class="breadcrumb-item"><a href="#">Home</a></li>--}}
            {{--                            <li class="breadcrumb-item"><a href="#">User</a></li>--}}
            {{--                            <li class="breadcrumb-item active" aria-current="page">User Profile</li>--}}
            {{--                        </ol>--}}
            {{--                    </nav>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body d-flex align-items-center justify-content-center flex-column">
                            <div class="d-flex align-items-center justify-content-center rounded-circle" style="width: 100px; height: 100px; background-color: {{ $bgColor }};">
                                <p class="pt-2 display-4" style="color: {{ $textColor }};">{{$initial}}</p>
                            </div>
                            <h5 class="my-3">{{Auth::user()->first_name}} {{Auth::user()->middle_name}}</h5>
                            <p class="text-muted mb-1">{{Auth::user() -> role -> role_name}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Full Name</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">{{Auth::user()->first_name}} {{Auth::user()->middle_name}} {{Auth::user()->last_name}}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">
                                        {{Auth::user()->email}}
                                        <img src="{{asset('assets/icon/bootstrap-icons-1.13.1/pencil-fill.svg')}}" alt="pencil" height="16" width="16">
                                    </p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Mobile</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">(098) 765-4321</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <p class="mb-0">Address</p>
                                </div>
                                <div class="col-sm-9">
                                    <p class="text-muted mb-0">Bay Area, San Francisco, CA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
</x-layout>
