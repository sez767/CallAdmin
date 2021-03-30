<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{Role, User};

class ProvideUserWithRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:role {code} {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Provides user with role {code} {email}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $code = $this->argument('code');
    	$email = $this->argument('email');
    	$role = Role::roleByCode($code);
    	if ($role) {
    		$user = User::where('email', $email)->first();
    		if ($user) {
				$this->updateRole($user, $role);
			} else {
				$this->printResult("There is no user with email alike => {$email}.\n", 'error');
			}		
    	} else {
    		$this->printResult("There is no role code alike => {$code}.\n", 'error');
    	}
    }

    /**
     * updates user role
     * @param Role $role
     * @param User $user
     */
    private function updateRole(User $user, $role)
    {
        $userRoles = $user->roles->pluck('id')->toArray();
        if(!in_array($role->id, $userRoles)) {
            $user->roles()->create([
                'role_id' => $role->id
            ]);
            $this->printResult("The user, {$user->email}, has got role => {$role->name}!\n");
        } else {
            $this->printResult("The user, {$user->email}, already has role => {$role->name}!\n");
        }
    }

    /**
     * prints result of commited command
     * @param string $message
     */
    private function printResult($message, $type = 'info')
    {
        $bgColor = $type === 'info' ? 'cyan' : 'magenta';
        $this->line("<fg=white;bg={$bgColor}>{$message}</>");
    }
}
