<?php

namespace App\Traits;

use App\Models\AdminActivityLog;
use Illuminate\Database\Eloquent\Model;

trait LogsAdminActivity
{
    protected function logActivity(
        string $action,
        ?Model $model = null,
        ?string $description = null,
        ?array $oldValues = null,
        ?array $newValues = null,
    ): AdminActivityLog {
        return AdminActivityLog::create([
            'admin_id' => auth('admin')->id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->getKey(),
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
