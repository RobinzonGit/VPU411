@php
    $isEdit = $category !== null;
@endphp

<div>
    <label class="block text-sm font-medium mb-1">Название</label>
    <input type="text" name="title"
           value="{{ old('title', $category?->title) }}"
           class="w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
    @error('title')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Slug</label>
    <input type="text" name="slug"
           value="{{ old('slug', $category?->slug) }}"
           class="w-full border rounded px-3 py-2 @error('slug') border-red-500 @enderror">
    @error('slug')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="block text-sm font-medium mb-1">Родительская категория</label>
    <select name="parent_id"
            class="w-full border rounded px-3 py-2 @error('parent_id') border-red-500 @enderror">
        <option value="">— Корневая —</option>
        @foreach ($parents as $parent)
            <option value="{{ $parent->id }}"
                @selected(old('parent_id', $category?->parent_id) == $parent->id)>
                {{ $parent->title }}
            </option>
        @endforeach
    </select>
    @error('parent_id')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

<div>
    <label class="inline-flex items-center gap-2">
        <input type="checkbox" name="active" value="1"
               @checked(old('active', $category?->active ?? true))>
        <span>Активна</span>
    </label>
</div>