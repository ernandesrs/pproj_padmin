<?php

namespace App\Console\Defaults;

use App\Models\Admin\Role;

class RoleBuilder
{
    /**
     * Start a default visitor role
     *
     * @return null|Role
     */
    public function visitor()
    {
        $name = "Visitor";
        if (Role::where("name", $name)->count()) {
            echo "{$name} role exists\n";
            return;
        }

        $rulables = array_fill_keys(Role::RULABLES, array_fill_keys(Role::RULES, false));
        foreach ($rulables as $rulableName => $rulableValue) {
            foreach ($rulableValue as $ruleKey => $ruleValue) {
                if (in_array($ruleKey, ["view", "viewAny"]))
                    $rulables[$rulableName][$ruleKey] = true;
            }
        }

        $role = (new Role())->create([
            "name" => $name,
            "admin_access" => true,
            "rulables" => $rulables
        ]);
        if (!$role) {
            echo "fail on create {$name} role\n";
            return null;
        }

        echo "{$name} role created\n";
        return $role;
    }

    /**
     * Start a default administrator role
     *
     * @return Role
     */
    public function administrator()
    {
        $name = "Administrator";
        if (Role::where("name", $name)->count()) {
            echo "{$name} role exists\n";
            return;
        }

        $rulables = array_fill_keys(Role::RULABLES, array_fill_keys(Role::RULES, false));
        foreach ($rulables as $rulableName => $rulableValue) {
            if (in_array($rulableName, ["role"])) {
                foreach ($rulableValue as $ruleKey => $ruleValue) {
                    if (!in_array($ruleKey, ["view", "viewAny"]))
                        $rulables[$rulableName][$ruleKey] = false;
                }
            }
        }

        $role = (new Role())->create([
            "name" => $name,
            "admin_access" => true,
            "rulables" => $rulables
        ]);
        if (!$role) {
            echo "fail on create {$name} role\n";
            return null;
        }

        echo "{$name} role created\n";
        return $role;
    }
}
