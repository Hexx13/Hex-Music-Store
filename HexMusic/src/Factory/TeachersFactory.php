<?php

namespace App\Factory;

use App\Entity\Teachers;
use App\Repository\TeachersRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Teachers>
 *
 * @method static Teachers|Proxy createOne(array $attributes = [])
 * @method static Teachers[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Teachers|Proxy find(object|array|mixed $criteria)
 * @method static Teachers|Proxy findOrCreate(array $attributes)
 * @method static Teachers|Proxy first(string $sortedField = 'id')
 * @method static Teachers|Proxy last(string $sortedField = 'id')
 * @method static Teachers|Proxy random(array $attributes = [])
 * @method static Teachers|Proxy randomOrCreate(array $attributes = [])
 * @method static Teachers[]|Proxy[] all()
 * @method static Teachers[]|Proxy[] findBy(array $attributes)
 * @method static Teachers[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Teachers[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static TeachersRepository|RepositoryProxy repository()
 * @method Teachers|Proxy create(array|callable $attributes = [])
 */
final class TeachersFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'name' => self::faker()->text(),
            'location' => self::faker()->text(),
            'rate' => self::faker()->randomFloat(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Teachers $teachers): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Teachers::class;
    }
}
