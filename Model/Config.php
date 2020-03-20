<?php

namespace DNAFactory\Framework\Model;

use DNAFactory\Framework\Api\Data\ConfigInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Config
 * @package DNAFactory\Framework\Model
 * @property string code
 * @property string value
 * @property boolean system
 */
class Config extends Model implements ConfigInterface
{
    const TABLE = 'configs';
    public $table = self::TABLE;

    const FOREIGN = 'config_id';

    public $timestamps = false;

    protected $fillable = ['code', 'value', 'system'];

    protected $casts = [
        'code' => 'string',
        'value' => 'string',
        'system' => 'boolean',
    ];
}
