@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>
                Редактирование категории
            </h1>

            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-secondary">
                Назад
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.categories.update', $category) }}"
              method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">
                    Название
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $category->title) }}"
                    class="form-control @error('title') is-invalid @enderror"
                    required
                >

                @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="slug" class="form-label">
                    Slug
                </label>

                <input
                    type="text"
                    id="slug"
                    name="slug"
                    value="{{ old('slug', $category->slug) }}"
                    class="form-control @error('slug') is-invalid @enderror"
                    required
                >

                @error('slug')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">
                    Родительская категория
                </label>

                <select
                    id="parent_id"
                    name="parent_id"
                    class="form-select @error('parent_id') is-invalid @enderror"
                >
                    <option value="">
                        — Без родительской категории —
                    </option>

                    @foreach($categories as $parent)
                        <option
                            value="{{ $parent->id }}"
                            @selected(old('parent_id', $category->parent_id) == $parent->id)
                        >
                            {{ $parent->title }}
                        </option>
                    @endforeach
                </select>

                @error('parent_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-check mb-4">
                <input
                    type="checkbox"
                    id="active"
                    name="active"
                    value="1"
                    class="form-check-input"
                    @checked(old('active', $category->active))
                >

                <label for="active" class="form-check-label">
                    Активна
                </label>
            </div>

            <button type="submit"
                    class="btn btn-primary">
                Сохранить изменения
            </button>

            <a href="{{ route('admin.categories.index') }}"
               class="btn btn-secondary">
                Отмена
            </a>

        </form>

    </div>
@endsection
