<?php

namespace App\Factory;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Booking>
 *
 * @method static Booking|Proxy createOne(array $attributes = [])
 * @method static Booking[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Booking|Proxy find(object|array|mixed $criteria)
 * @method static Booking|Proxy findOrCreate(array $attributes)
 * @method static Booking|Proxy first(string $sortedField = 'id')
 * @method static Booking|Proxy last(string $sortedField = 'id')
 * @method static Booking|Proxy random(array $attributes = [])
 * @method static Booking|Proxy randomOrCreate(array $attributes = [])
 * @method static Booking[]|Proxy[] all()
 * @method static Booking[]|Proxy[] findBy(array $attributes)
 * @method static Booking[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Booking[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static BookingRepository|RepositoryProxy repository()
 * @method Booking|Proxy create(array|callable $attributes = [])
 */
final class BookingFactory extends ModelFactory
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
            'beginAt' => null, // TODO add DATETIME ORM type manually
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Booking $booking): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Booking::class;
    }
}
