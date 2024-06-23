<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PropCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'label' => $this->label,
            'type' => $this->type,
            'searchable' => (bool) $this->searchable,
            'priceable'=> (bool) $this->priceable,
            'unit' => $this->unit,
            'required' => $this->required,
            'width' => $this->width,
            'icon' => $this->icon,
            'dataList' => $this->dataz,
            'optionList' => $this->optionz,
        ];
    }
}
