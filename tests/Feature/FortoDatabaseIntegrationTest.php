<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Skill;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
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
            ->assertSee('Like satu kali per browser tanpa database');
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
            ->assertSee('Project baru')
            ->assertSee('Belum ada project di database')
            ->assertSee('Belum ada skill di database');
    }

    public function test_dashboard_can_crud_projects_and_skills(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->withoutMiddleware(ValidateCsrfToken::class);

        $session = [
            'forto_admin' => [
                'authenticated' => true,
                'name' => 'Admin',
                'email' => 'winkytiopratama@gmail.com',
                'logged_in_at' => now()->format('d M Y, H:i'),
            ],
        ];

        $this->withSession($session)->post(route('dashboard.projects.store'), [
            'title' => 'Dashboard CRUD Project',
            'category' => 'Portfolio Website',
            'summary' => 'Project hasil input dashboard.',
            'stack' => "Laravel\nBlade\nMySQL",
            'status' => 'Published',
            'github_url' => 'github.com/winky/project',
            'sort_order' => 3,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('projects', [
            'title' => 'Dashboard CRUD Project',
            'category' => 'Portfolio Website',
            'status' => 'Published',
            'sort_order' => 3,
        ]);

        $project = Project::query()->firstOrFail();

        $this->withSession($session)->put(route('dashboard.projects.update', $project), [
            'title' => 'Dashboard CRUD Project Updated',
            'category' => 'Landing Page',
            'summary' => 'Project hasil update dashboard.',
            'stack' => "Laravel\nBlade\nMariaDB",
            'status' => 'Ready',
            'github_url' => 'https://github.com/winky/project-updated',
            'sort_order' => 1,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Dashboard CRUD Project Updated',
            'category' => 'Landing Page',
            'status' => 'Ready',
            'sort_order' => 1,
        ]);

        $this->withSession($session)->post(route('dashboard.skills.store'), [
            'title' => 'Dashboard Skill',
            'items' => "Laravel\nResponsive UI\nMySQL",
            'sort_order' => 2,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('skills', [
            'title' => 'Dashboard Skill',
            'sort_order' => 2,
        ]);

        $skill = Skill::query()->firstOrFail();

        $this->withSession($session)->put(route('dashboard.skills.update', $skill), [
            'title' => 'Dashboard Skill Updated',
            'items' => "Laravel\nAdmin CRUD\nDatabase",
            'sort_order' => 4,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('skills', [
            'id' => $skill->id,
            'title' => 'Dashboard Skill Updated',
            'sort_order' => 4,
        ]);

        $this->get('/projects')
            ->assertOk()
            ->assertSee('Dashboard CRUD Project Updated')
            ->assertDontSee((string) config('forto.projects.0.title'));

        $this->get('/skills')
            ->assertOk()
            ->assertSee('Dashboard Skill Updated')
            ->assertSee('Admin CRUD');

        $this->withSession($session)->delete(route('dashboard.projects.destroy', $project))
            ->assertRedirect(route('dashboard'));

        $this->withSession($session)->delete(route('dashboard.skills.destroy', $skill))
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseMissing('projects', [
            'id' => $project->id,
        ]);

        $this->assertDatabaseMissing('skills', [
            'id' => $skill->id,
        ]);

        $this->get('/projects')
            ->assertOk()
            ->assertDontSee('Dashboard CRUD Project Updated')
            ->assertSee('Belum ada project public');

        $this->get('/skills')
            ->assertOk()
            ->assertDontSee('Dashboard Skill Updated')
            ->assertSee('Belum ada skill public');
    }
}
