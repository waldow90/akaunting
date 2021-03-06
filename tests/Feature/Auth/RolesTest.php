<?php

namespace Tests\Feature\Auth;

use App\Jobs\Auth\CreateRole;
use App\Models\Auth\Permission;
use Tests\Feature\FeatureTestCase;

class RolesTest extends FeatureTestCase
{

    public function testItShouldSeeRoleListPage()
    {
        $this->loginAs()
            ->get(route('roles.index'))
            ->assertStatus(200)
            ->assertSeeText(trans_choice('general.roles', 2));
    }

    public function testItShouldSeeRoleCreatePage()
    {
        $this->loginAs()
            ->get(route('roles.create'))
            ->assertStatus(200)
            ->assertSeeText(trans('general.title.new', ['type' => trans_choice('general.roles', 1)]));
    }

    public function testItShouldCreateRole()
    {
        $this->loginAs()
            ->post(route('roles.store'), $this->getRoleRequest())
            ->assertStatus(200);

        $this->assertFlashLevel('success');
    }

    public function testItShouldSeeRoleUpdatePage()
    {
        $role = $this->dispatch(new CreateRole($this->getRoleRequest()));

        $this->loginAs()
            ->get(route('roles.edit', ['role' => $role->id]))
            ->assertStatus(200)
            ->assertSee($role->name);
    }

    public function testItShouldUpdateRole()
    {
        $request = $this->getRoleRequest();

        $role = $this->dispatch(new CreateRole($request));

        $request['name'] = $this->faker->name;

        $this->loginAs()
            ->patch(route('roles.update', $role->id), $request)
            ->assertStatus(200);

        $this->assertFlashLevel('success');
    }

    public function testItShouldDeleteRole()
    {
        $role = $this->dispatch(new CreateRole($this->getRoleRequest()));

        $this->loginAs()
            ->delete(route('roles.destroy', $role->id))
            ->assertStatus(200);

        $this->assertFlashLevel('success');
    }

    private function getRoleRequest()
    {
        return [
            'name' => $this->faker->text(5),
            'display_name' => $this->faker->text(5),
            'description' => $this->faker->text(5),
            'permissions' => Permission::take(10)->pluck('id')->toArray(),
        ];
    }
}