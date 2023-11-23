<?php declare(strict_types=1);

namespace App\Domains\Timezone\Model\Builder;

use App\Domains\CoreApp\Model\Builder\BuilderAbstract;
use App\Domains\Timezone\Model\Timezone as Model;

class Timezone extends BuilderAbstract
{
    /**
     * @param float $latitude
     * @param float $longitude
     *
     * @return self
     */
    public function byLatitudeLongitude(float $latitude, float $longitude): self
    {
        return $this->whereRaw('ST_CONTAINS(`geojson`, POINT(?, ?))', [$longitude, $latitude]);
    }

    /**
     * @param string $zone
     *
     * @return self
     */
    public function byZone(string $zone): self
    {
        return $this->where('zone', $zone);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('default', 'DESC')->orderBy('zone', 'ASC');
    }

    /**
     * @param string ...$columns
     *
     * @return self
     */
    public function selectOnly(string ...$columns): self
    {
        return $this->withoutGlobalScope('selectIdZone')->select($columns);
    }

    /**
     * @param ?int $id
     *
     * @return self
     */
    public function whenIdOrDefault(?int $id): self
    {
        return $this->when($id, static fn ($q) => $q->byId($id), static fn ($q) => $q->whereDefault(true));
    }

    /**
     * @param bool $default = true
     *
     * @return self
     */
    public function whereDefault(bool $default = true): self
    {
        return $this->where('default', $default);
    }

    /**
     * @return self
     */
    public function whereGeojson(): self
    {
        return $this->whereRaw('`geojson` != '.Model::emptyGeoJSON());
    }
}
