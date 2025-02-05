@extends('layouts.app')
@section('title', 'GameApp - Edit Game')
@section('class', 'my-profile')
@section('content')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <header>
        <a href="{{ url('games') }}" class="btn-back">
            <img src="{{ asset('images/btn-back.png') }}" alt="Back">
        </a>
        <img src="{{ asset('images/logo-games.png') }}" alt="Game Logo">
        <svg class="btn-burger" viewBox="0 0 100 100" width="80">
            <path class="line top" d="m 70,33 h -40 c 0,0 -8.5,-0.149796 -8.5,8.5 0,8.649796 8.5,8.5 8.5,8.5 h 20 v -20" />
            <path class="line middle" d="m 70,50 h -40" />
            <path class="line bottom"
                d="m 30,67 h 40 c 0,0 8.5,0.149796 8.5,-8.5 0,-8.649796 -8.5,-8.5 -8.5,-8.5 h -20 v 20" />
        </svg>
    </header>
    @include('menuburguer')
    <section class="scroll">
        <form action="{{ url('games/' . $game->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @if (count($errors->all()) > 0)
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            @endif
            <div class="form-group">
                <img id="upload" class="mask" src="images/bg-svg-mask.svg" alt="">
                <img class="border" src="{{asset('images/shape-border.svg')}}" alt="">
                <input id="photo" type="file" name="image" accept="image/*">
                <input type="hidden" name="originphoto" value="{{ $game->photo }}">
                <input type="hidden" name="id" value="{{ $game->id }}">
            </div>
            <div class="form-group">
                <label>
                    Title:
                </label>
                <input type="text" name="title" value="{{ old('title', $game->title) }}">
            </div>
            <div class="form-group">
                <label>
                    Developer:
                </label>
                <input type="text" name="developer" value="{{ old('developer', $game->developer) }}">
            </div>
            <div class="form-group">
                <label>
                    Release Date:
                </label>
                <input type="date" name="releasedate" value="{{ old('releasedate', $game->releasedate) }}">
            </div>
            <div class="form-group">
                <label>
                    Category:
                </label>
                <select name="category_id" value="{{ old('category_id') }}">
                    @foreach ($cats as $cat)
                        <option value="{{ $cat->id }}" @if (old('category_id') == $cat->id) selected @endif>
                            {{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>
                    Price:
                </label>
                <input type="number" name="price" value="{{ old('price', $game->price) }}">
            </div>
            <div class="form-group">
                <label>
                    Genre:
                </label>
                <input type="text" name="genre" value="{{ old('genre', $game->genre) }}">
            </div>
            <div class="form-group">
                <label>
                    Slider:
                </label>
                <select name="slider">
                    <option value="">Select...</option>
                    <option value="0" @if (old('slider') == 1) selected @endif>Inactive</option>
                    <option value="1" @if (old('slider') == 0) selected @endif>Active</option>
                </select>
            </div>
            <div class="form-group">
                <label>
                    Description:
                </label>
                <textarea name="description">{{ old('description', $game->description) }}</textarea>
            </div>
            <div class="form-group">
                <button type="submit">
                    <img src="{{ asset('images/content-btn-edit.svg') }}" alt="Login">
                </button>
            </div>
        </form>
    </section>
@endsection

@section('js')
    <script>
        $(document).ready(function() {

            $('header').on('click', '.btn-burger', function() {
                $(this).toggleClass('active')
                $('.nav').toggleClass('active')
            })
            //----------------------------
            $togglePass = false
            $('section').on('click', '.ico-eye', function() {
                !$togglePass ? $(this).next().attr('type', 'text') :
                    $(this).next().attr('type', 'password')

                    !$togglePass ? $(this).attr('src', 'images/ico-eye.svg') :
                    $(this).attr('src', 'images/closedico-eye.svg')

                $togglePass = !$togglePass

            })
            //----------------------------
            $('.border').click(function(e) {
                $('#photo').click()
            })
            $('#photo').change(function(e) {
                e.preventDefault()
                let reader = new FileReader()
                reader.onload = function(evt) {
                    $('#upload').attr('src', event.target.result)
                }
                reader.readAsDataURL(this.files[0])
            })
            //----------------------------
        })
    </script>
    <script>
        @if (count($errors->all()) > 0)
            @php    $error = '' @endphp
            @foreach ($errors->all() as $message)
                @php        $error .= "<li>" . $message . "</li>" @endphp
            @endforeach
    </script>
    <script>
        $(document).ready(function() {
            Swal.fire({
                position: "top",
                title: "Error!",
                html: `@php echo $error @endphp`,
                icon: 'error',
                toast: true,
                showConfirmButton: false,
                timer: 5000,
            })
        })
    </script>
    @endif
@endsection
