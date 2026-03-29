<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use Tests\TestCase;

#[RequiresPhpExtension('pdo_mysql')]
class FortoDatabaseIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_creates_admin_login_user(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', [
            'email' => 'winkytiopratama@gmail.com',
            'name' => 'Admin',
        ]);
    }

    public function test_public_pages_render_from_config_without_content_tables(): void
    {
        $this->seed(DatabaseSeeder::class);

        Schema::dropIfExists('projects');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('site_likes');

        $firstProject = (array) config('forto.projects.0');
        $firstSkill = (array) config('forto.skills.0');

        $this->get('/')
            ->assertOk()
            ->assertSee('Selamat Datang');

        $this->get('/projects')
            ->assertOk()
            ->assertSee((string) ($firstProject['title'] ?? ''));

        $this->get('/skills')
            ->assertOk()
            ->assertSee((string) ($firstSkill['title'] ?? ''));

        $this->get('/community')
            ->assertOk()
            ->assertSee('Counter like sederhana tanpa database');
    }

    public function test_seeded_admin_can_login_and_open_dashboard(): void
    {
        $this->seed(DatabaseSeeder::class);
        $token = 'forto-login-token';

        $this->withSession(['_token' => $token])->post('/login', [
            '_token' => $token,
            'email' => 'winkytiopratama@gmail.com',
            'password' => 'winkyganteng',
        ])->assertRedirect(route('dashboard'));

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Login admin aktif')
            ->assertSee((string) config('forto.projects.0.title'))
            ->assertSee((string) config('forto.skills.0.title'));
    }
}
