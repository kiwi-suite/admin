<?php
/**
 * @link https://github.com/ixocreate
 * @copyright IXOLIT GmbH
 * @license MIT License
 */

declare(strict_types=1);

namespace Ixocreate\Admin\Action\Api\User;

use Ixocreate\Admin\Command\User\UpdateUserCommand;
use Ixocreate\Admin\Entity\User;
use Ixocreate\Admin\Repository\UserRepository;
use Ixocreate\Admin\Response\ApiErrorResponse;
use Ixocreate\Admin\Response\ApiSuccessResponse;
use Ixocreate\CommandBus\CommandBus;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class UpdateAction implements MiddlewareInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * UpdateAction constructor.
     * @param UserRepository $userRepository
     * @param CommandBus $commandBus
     */
    public function __construct(
        UserRepository $userRepository,
        CommandBus $commandBus
    ) {
        $this->userRepository = $userRepository;
        $this->commandBus = $commandBus;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $data = $request->getParsedBody();

        $data['userId'] = $request->getAttribute('id');

        /** @var User $entity */
        $entity = $this->userRepository->find($data['userId']);

        if ($entity === null || $entity->deletedAt() !== null) {
            return new ApiErrorResponse('admin_user_notfound', 'User not found');
        }

        $result = $this->commandBus->command(UpdateUserCommand::class, $data);
        if ($result->isSuccessful()) {
            return new ApiSuccessResponse();
        }

        return new ApiErrorResponse('execution_error', $result->messages());
    }
}
