<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    use HasFactory;

    public const STATUS_NEW = 'new';

    public const STATUS_CONTACTED = 'contacted';

    public const STATUS_QUALIFIED = 'qualified';

    public const STATUS_CLOSED = 'closed';

    public const STATUS_SPAM = 'spam';

    protected $fillable = [
        'name', 'business_name', 'phone', 'email', 'service', 'budget', 'message',
        'ip_address', 'user_agent', 'referrer', 'status', 'read_at',
    ];

    protected $hidden = ['ip_address', 'user_agent'];

    protected function casts(): array
    {
        return ['read_at' => 'datetime'];
    }
}
