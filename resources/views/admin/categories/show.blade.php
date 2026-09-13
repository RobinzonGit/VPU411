@extends('layouts.main')

@section('content')
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>
                {{ $category->title }}
            </h1>

            <div>
                <a href="{{ route('admin.categories.edit', $category) }}"
                   class="btn btn-warning">
                    Изменить
                </a>

                <a href="{{ route('admin.categories.index') }}"
                   class="btn btn-secondary">
                    Назад
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <dl class="row mb-0">

                    <dt class="col-sm-3">
                        ID
                    </dt>

                    <dd class="col-sm-9">
                        {{ $category->id }}
                    </dd>

                    <dt class="col-sm-3">
                        Название
                    </dt>

                    <dd class="col-sm-9">
                        {{ $category->title }}
                    </dd>

                    <dt class="col-sm-3">
                        Slug
                    </dt>

                    <dd class="col-sm-9">
                        {{ $category->slug }}
                    </dd>

                    <dt class="col-sm-3">
                        Родитель
                    </dt>

                    <dd class="col-sm-9">
                        {{ $category->parent?->title ?? '—' }}
                    </dd>

                    <dt class="col-sm-3">
                        Статус
                    </dt>

                    <dd class="col-sm-9">
                        @if($category->active)
                            <span class="badge bg-success">
                                Активна
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                Неактивна
                            </span>
                        @endif
                    </dd>

                    <dt class="col-sm-3">
                        Дата создания
                    </dt>

                    <dd class="col-sm-9">
                        {{ $category->created_at?->format('d.m.Y H:i') }}
                    </dd>

                    <dt class="col-sm-3">
                        Дата обновления
                    </dt>

                    <dd class="col-sm-9">
                        {{ $category->updated_at?->format('d.m.Y H:i') }}
                    </dd>

                </dl>

            </div>
        </div>

        @if($category->children->count())
            <div class="card mt-4">
                <div class="card-header">
                    Дочерние категории
                </div>

                <div class="card-body">
                    <ul class="mb-0">
                        @foreach($category->children as $child)
                            <li>
                                <a href="{{ route('admin.categories.show', $child) }}">
                                    {{ $child->title }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

    </div>
@endsection
