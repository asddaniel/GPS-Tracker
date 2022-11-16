<?php declare(strict_types=1);

namespace App\Domains\Language\Model;

use App\Domains\Language\Model\Builder\Language as Builder;
use App\Domains\SharedApp\Model\ModelAbstract;

class Language extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'language';

    /**
     * @const string
     */
    public const TABLE = 'language';

    /**
     * @const string
     */
    public const FOREIGN = 'language_id';

    /**
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('enabled', static fn (Builder $q) => $q->where(static::TABLE.'.enabled', true));
    }

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \App\Domains\Language\Model\Builder\Language
     */
    public function newEloquentBuilder($q): Builder
    {
        return new Builder($q);
    }
}
