@extends('layouts.app')
@section('title', 'GameApp - Users Module')
@section('class', 'users')

@section('content')

    <header>
        <a href="{{ url('dashboard') }}" class="btn-back">
            <img src="images/btn-back.png" alt="Back">
        </a>
        <img src="images/logo-games.png" alt="User Logo">
        <svg class="btn-burger" viewBox="0 0 100 100" width="80">
            <path class="line top" d="m 70,33 h -40 c 0,0 -8.5,-0.149796 -8.5,8.5 0,8.649796 8.5,8.5 8.5,8.5 h 20 v -20" />
            <path class="line middle" d="m 70,50 h -40" />
            <path class="line bottom"
                d="m 30,67 h 40 c 0,0 8.5,0.149796 8.5,-8.5 0,-8.649796 -8.5,-8.5 -8.5,-8.5 h -20 v 20" />
        </svg>
    </header>
    <nav class="nav">
        <figure class="avatar">
            <img class="mask" src="images/photo.png" alt="Photo">
            <img class="border" src="images/borde2.svg" alt="Border">
        </figure>
        <h2>Lily Collins</h2>
        <h4>Administrator</h4>
        <menu>
            <a href='my-profile.html'>
                <img src="images/ico-login.svg" alt="My Profile">
                My Profile
            </a>
            <a href='dashboard.html'>
                <img src="images/ico-categories.svg" alt="Dashboard">
                Dashboard
            </a>
            <a href='index.html'>
                <img src="images/ico-logout.svg" alt="Logout">
                Logout
            </a>
        </menu>
    </nav>
    <section>
        <div class="area">
            <a class='add' href='{{ url('games/create') }}'>
                <img src="images/btn-add.svg" alt="Add">
            </a>
            <div class="options">

                <a href="{{ url('export/games/pdf') }}">
                    <img src="{{ asset('images/btn-export-pdf.svg') }}" alt="PDF" width="30px">
                </a>
                <a href="{{ url('export/games/excel') }}">
                    <img src="{{ asset('images/btn-export-excel.svg') }}" alt="Excel" width="25px">
                </a>
                <input type="text" id="qserch" name="qserch" placeholder="Search">
            </div>
            <div class="loader"></div>
            <div id="list">
                @foreach ($games as $game)
                    <article class="record">
                        <figure class="avatar">
                            <img class="mask" src="{{ asset('images') . '/' . $game->image }}" alt="Photo">
                            <img class="border" src="images/shape-border-small.svg" alt="Border">
                        </figure>
                        <aside>
                            <h3>{{ $game->title }}</h3>
                            <h4>{{ $game->category->name }}</h4>
                        </aside>
                        <figure class="actions">
                            <a href='{{ url('games/' . $game->id) }}'>
                                <img src="images/ico-search.svg" alt="Show">
                            </a>
                            <a href='{{ url('games/' . $game->id . '/edit') }}'>
                                <img src="images/ico-edit.svg" alt="Edit">
                            </a>
                            <a href="javascript:;" class="delete" data-title="{{ $game->title }}">
                                <img src="{{ asset('images/ico-delete.svg') }}" alt="Delete">
                            </a>
                            <form action="{{ url('games/' . $game->id) }}" method="POST" style="display: none">
                                @csrf
                                @method('DELETE')
                            </form>
                        </figure>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

@endsection
<div class="paginate">
    {{ $games->links('layouts.paginator') }}

    <!-- <span>01/03</span>
                    <a class="btn-prev" href="javascript:;">
                        <img src="images/btn-next.png" alt="next">
                    </a> -->
</div>

@section('js')
    <script>
        $(document).ready(function() {
            $('.loader').hide()
            //----------------------------------

            ///-----------------------------------
            @if (session('message'))
                Swal.fire({
                    position: "top",
                    title: '{{ session('message') }}',
                    icon: 'success',
                    toast: true,
                    timer: 5000
                })
            @endif

            //---------------------------
            $('figure').on('click', '.delete', function() {

                $title = $(this).attr('data-title')
                Swal.fire({
                    title: "Are you sure?",
                    text: "Desea eliminar a: " + $title,
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(this).next().submit()
                    }
                });
            })
        })
        //----------------------------------
        $('body').on('keyup', '#qserch', function(e) {
            e.preventDefault()
            $query = $(this).val()
            $token = $('input[name=_token]').val()
            $model = 'games'

            $('.loader').show()
            $('#list').hide()


            setTimeout(() => {
                $.post($model + '/search', {
                        q: $query,
                        _token: $token
                    },
                    function(data) {
                        $('#list').html(data)
                        $('.loader').hide()
                        $('#list').fadeIn('slow')
                    }
                )
            }, 1000);


        })
    </script>
@endsection
