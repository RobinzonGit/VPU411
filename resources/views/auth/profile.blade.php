@extends('layouts.main')

@section('content')
    <div class="container">

        <h1 class="mb-4">Профиль</h1>

        @if(session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <div class="row">

            {{-- Форма личных данных --}}
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Личные данные</div>
                    <div class="card-body">

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('profile.update') }}"
                              method="POST"
                              enctype="multipart/form-data">

                            @csrf
                            @method('PATCH')

                            <div class="mb-3 text-center">
                                @if($user->avatar)
                                    <img src="{{ Storage::disk('public')->url($user->avatar) }}"
                                         alt="Аватар"
                                         class="rounded-circle mb-2"
                                         style="width: 120px; height: 120px; object-fit: cover;">
                                @else
                                    <div class="rounded-circle bg-secondary d-inline-flex align-items-center justify-content-center mb-2"
                                         style="width: 120px; height: 120px; color: #fff;">
                                        Нет аватара
                                    </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="avatar" class="form-label">Аватар</label>
                                <input type="file"
                                       id="avatar"
                                       name="avatar"
                                       class="form-control @error('avatar') is-invalid @enderror"
                                       accept="image/*">
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Имя</label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       class="form-control @error('name') is-invalid @enderror"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       class="form-control @error('email') is-invalid @enderror"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Сохранить
                            </button>
                        </form>

                    </div>
                </div>
            </div>

            {{-- Форма смены пароля --}}
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">Смена пароля</div>
                    <div class="card-body">

                        @if($errors->has('current_password') || $errors->has('password'))
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach(['current_password', 'password'] as $field)
                                        @foreach($errors->get($field) as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('profile.password') }}" method="POST">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Текущий пароль</label>
                                <input type="password"
                                       id="current_password"
                                       name="current_password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Новый пароль</label>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Повторите пароль</label>
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="form-control"
                                       required>
                            </div>

                            <button type="submit" class="btn btn-warning">
                                Сменить пароль
                            </button>
                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection
