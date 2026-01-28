<?php

use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// --- DEBUG SCRIPT ---
echo "--- STARTING DEBUG ---\n";

// 1. Pick the Admin User
$user = User::where('email', 'ikram@example.com')->first();
if (!$user) {
    echo "Admin User not found, falling back to first.\n";
    $user = User::first();
}
echo "User: " . $user->name . " (ID: " . $user->id . ")\n";

// Load roles
$user->load('roles', 'permissions'); // Ensure loaded
echo "User Roles: " . $user->roles->pluck('name')->implode(', ') . "\n";

if ($user->roles->isEmpty()) {
    echo "User has no roles. Attaching Admin role for test.\n";
    $role = Role::where('name', 'admin')->first();
    $user->roles()->attach($role);
    $user->refresh();
}

$rolePermIds = $user->roles->flatMap->permissions->pluck('id')->toArray();
echo "Role Permissions (Count: ".count($rolePermIds)."): " . implode(', ', array_slice($rolePermIds, 0, 5)) . "...\n";

// 4. Mimic "Desired Permissions"
// Let's FORBID the first permission found in the role
$firstRolePerm = $user->roles->first()->permissions->first();
$desiredPermissions = $rolePermIds;

if ($firstRolePerm) {
    echo "Testing by Forbidding: " . $firstRolePerm->name . " (ID: " . $firstRolePerm->id . ")\n";
    $desiredPermissions = array_diff($desiredPermissions, [$firstRolePerm->id]);
} else {
    echo "Role has no permissions? CAnnot test forbid.\n";
}

// 5. Run Calculation Logic (Copied from Controller)
$rolePermissions = array_map('intval', $rolePermIds);
$desiredPermissions = array_map('intval', $desiredPermissions);

$toGrant = array_diff($desiredPermissions, $rolePermissions); // Should be empty
$toForbid = array_diff($rolePermissions, $desiredPermissions); // Should have 1

echo "To Grant: " . implode(', ', $toGrant) . "\n";
echo "To Forbid: " . implode(', ', $toForbid) . "\n";

$syncData = [];
foreach ($toGrant as $permId) {
    $syncData[$permId] = ['is_forbidden' => false];
}
foreach ($toForbid as $permId) {
    $syncData[$permId] = ['is_forbidden' => true];
}

print_r($syncData);

// 6. Attempt Sync
echo "Syncing...\n";
$user->permissions()->sync($syncData);
echo "Sync Success!\n";

// 7. Verify Result via Model
$user->refresh(); // Reload relations
$user->load('permissions');

echo "Direct Permissions in DB:\n";
foreach ($user->permissions as $p) {
    echo "- " . $p->name . " (ID: " . $p->id . ") [Forbidden: " . $p->pivot->is_forbidden . "]\n";
}

echo "Effective Permissions (Method):\n";
$effective = $user->getEffectivePermissions();
foreach ($effective as $p) {
    echo "- " . $p->name . " (ID: " . $p->id . ")\n";
}

if ($effective->contains('id', $firstRolePerm->id)) {
    echo "ERROR: Permission ID " . $firstRolePerm->id . " IS STILL PRESENT!\n";
} else {
    echo "SUCCESS: Permission ID " . $firstRolePerm->id . " IS GONE!\n";
}
