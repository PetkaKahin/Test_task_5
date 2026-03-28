<?php

namespace App\Http\Resources\api\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 */
class LoginResource extends JsonResource
{
    // Гарантируем, что поля будут только от User
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
            ]
        ];
    }
}
