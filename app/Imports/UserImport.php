<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class UserImport implements ToModel, WithStartRow 
{
    protected $role;
    protected $pin;

    public function __construct($role, $pin)
    {
        $this->role = $role;
        $this->pin = $pin;
    }

    public function model(array $row): Model|null
    {
        if (empty($row[1]) || empty($row[2])) {
            return null;
        }
        $user = User::where('username', $row[1])->first();
        if ($user) {
            return null;
        }
        return new User([
            'username' => $row[1],
            'password' => sha1((string) $row[1]),
            'peran' => $this->role,
            'pin' => $this->pin,
            'nama' => $row[2]
        ]);
    }

    public function startRow(): int
    {
        return 2;
    }
}
