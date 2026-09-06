<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Attributes\Fillable;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    /**
     * @property int $parent_id
     * @property string $slug
     * @property string $title
     * @property bool $active
     */
    #[Fillable('parent_id', 'slug', 'title', 'active')]
    class Category extends Model
    {
        use HasFactory;

        public function parent(): BelongsTo
        {
            return $this->belongsTo(Category::class, 'parent_id', 'id');
        }

        public function children(): HasMany
        {
            return $this->hasMany(Category::class, 'parent_id', 'id');
        }

        public function products(): HasMany
        {
            return $this->hasMany(Product::class);
        }
    //    protected $fillable = [
    //        'parent_id',
    //        'slug',
    //        'title',
    //        'active'
    //    ];
    }
