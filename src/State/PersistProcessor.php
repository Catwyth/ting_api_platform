<?php

declare(strict_types=1);

namespace CCMBenchmark\Ting\ApiPlatform\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use CCMBenchmark\Ting\ApiPlatform\Ting\ManagerRegistry;

use function is_object;

/**
 * @phpstan-ignore-next-line
 * @template T of object
 * @implements ProcessorInterface<T>
 * TODO: Handle PUT requests
 */
final class PersistProcessor implements ProcessorInterface
{
    public function __construct(private readonly ManagerRegistry $managerRegistry)
    {
    }

    /**
     * @param T $data
     * @param Operation<T>         $operation
     * @param array<string, mixed> $uriVariables
     * @param array<string, mixed> $context
     *
     * @return T
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        if (! is_object($data)) {
            return $data;
        }

        $manager = $this->managerRegistry->getManagerForClass($data::class);
        if ($manager === null) {
             return $data;
        }

        $manager->getRepository()->save($data);

        return $data;
    }
}
