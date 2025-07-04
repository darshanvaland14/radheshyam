<?php

namespace App\Containers\AppSection\Authorization\Tests\Unit\Data\Factories;

use App\Containers\AppSection\Authorization\Data\Factories\RoleFactory;
use App\Containers\AppSection\Authorization\Models\Roles;
use App\Containers\AppSection\Authorization\Tests\UnitTestCase;
use App\Ship\Enums\AuthGuard;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Group;

#[Group('authorization')]
#[CoversClass(RoleFactory::class)]
final class RoleFactoryTest extends UnitTestCase
{
    public function testCanCreateRole(): void
    {
        $role = RoleFactory::new()->createOne();

        $this->assertInstanceOf(Role::class, $role);
    }

    public function testCanCreateAdminRole(): void
    {
        // Since 'admin' is seeded in the database, we need to delete it first
        // to avoid "duplicate key" error.
        $roleName = config('appSection-authorization.admin_role');
        $adminRole = Role::findByName($roleName);
        $adminRole->delete();
        $this->assertModelMissing($adminRole);

        $role = RoleFactory::new()->admin()->createOne();

        $this->assertSame($roleName, $role->name);
    }

    public function testCanSetGuard(): void
    {
        $role = RoleFactory::new()->withGuard(AuthGuard::API->value)->createOne();

        $this->assertSame(AuthGuard::API->value, $role->guard_name);
    }
}
