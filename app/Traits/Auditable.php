<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\AuditLog;

trait Auditable
{
    protected static function bootAuditable()
    {
        static::created(function ($model) {
            self::logChange($model, 'CREATE');
        });

        static::updated(function ($model) {
            self::logChange($model, 'UPDATE');
        });

        static::deleted(function ($model) {
            self::logChange($model, 'DELETE');
        });
    }

    private static function logChange($model, $action)
    {
        $oldValues = $action === 'UPDATE' ? $model->getOriginal() : null;
        $newValues = $action !== 'DELETE' ? $model->getAttributes() : null;

        AuditLog::create([
            'action' => $action,
            'table_name' => $model->getTable(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'user_id' => Auth::id(),
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }
}
