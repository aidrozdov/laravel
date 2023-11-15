<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    protected bool $isAttachCompany = true;

    public function __construct($resource, $isAttachCompany = true)
    {
        parent::__construct($resource);
        $this->isAttachCompany = $isAttachCompany;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $company = null;
        if ($this->isAttachCompany) {
            if ($this->company) {
                $company = CompanyResource::make($this->company);
            } else {
                $company = $this->companies()->first();
            }
        }

        $roles = [];
        foreach ($this->roles as $role) {
            $roles[$role->name] = PermissionResource::collection($role->permissions);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'midname' => $this->midname,
            'email' => $this->email,
            'position' => $this->position,
            'status' => $this->status,
            'company' => $company,
            'employed_at' => $this->employed_at?->toDateString(),
            'roles' => $roles,
            ...$this->additional
        ];
    }
}
