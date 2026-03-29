<?php

namespace Tests\Feature;

use App\Support\FortoProjectStore;
use App\Support\FortoSiteLikeStore;
use App\Support\FortoSkillStore;
use App\Support\FortoVisitorStore;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use Tests\TestCase;

#[RequiresPhpExtension('pdo_mysql')]
class FortoDatabaseIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_populates_forto_content_and_admin_tables(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('projects', count(config('forto.projects')));
        $this->assertDatabaseCount('skills', count(config('forto.skills')));
        $this->assertDatabaseCount('site_likes', count(config('forto.site_like.people')));
        $this->assertDatabaseHas('users', [
            'email' => config('forto.admin.email'),
        ]);
    }

    public function test_forto_stores_and_pages_run_from_database_records(): void
    {
        $this->seed(DatabaseSeeder::class);

        $projectStore = app(FortoProjectStore::class);
        $skillStore = app(FortoSkillStore::class);
        $siteLikeStore = app(FortoSiteLikeStore::class);
        $visitorStore = app(FortoVisitorStore::class);

        $project = $projectStore->create([
            'title' => 'MySQL Launch Project',
            'category' => 'Showcase',
            'summary' => 'Project baru yang harus muncul dari database.',
            'stack' => 'Laravel, MySQL, Blade',
            'status' => 'Live',
            'github_url' => 'github.com/example/mysql-launch',
        ]);

        $skill = $skillStore->create([
            'title' => 'Database Engineering',
            'items' => 'Schema Design, Query Optimization',
        ]);

        $firstLikeSummary = $siteLikeStore->add('Visitor Tester');
        $secondLikeSummary = $siteLikeStore->add('visitor tester');
        $visitorSummary = $visitorStore->add('Pengunjung Baru', 'token-visitor-1');
        $adminVisitorSummary = $visitorStore->add((string) config('forto.admin.name'), 'token-admin');

        $projectStore->update($project['id'], [
            'title' => 'MySQL Launch Project',
            'category' => 'Showcase',
            'summary' => 'Project baru yang sudah diperbarui dari database.',
            'stack' => 'Laravel, MySQL, Blade, Testing',
            'status' => 'Featured',
            'github_url' => 'https://github.com/example/mysql-launch',
        ]);

        $this->assertDatabaseHas('projects', [
            'id' => $project['id'],
            'title' => 'MySQL Launch Project',
            'status' => 'Featured',
        ]);
        $this->assertDatabaseHas('skills', [
            'id' => $skill['id'],
            'title' => 'Database Engineering',
        ]);
        $this->assertSame($firstLikeSummary['total'], $secondLikeSummary['total']);
        $this->assertTrue($visitorSummary['recorded']);
        $this->assertFalse($adminVisitorSummary['recorded']);

        $this->post('/login', [
            'email' => (string) config('forto.admin.email'),
            'password' => (string) config('forto.admin.password'),
        ])->assertRedirect(route('dashboard'));

        $this->get('/')
            ->assertOk()
            ->assertSee('Selamat Datang');

        $this->get('/projects')
            ->assertOk()
            ->assertSee('MySQL Launch Project');

        $this->get('/skills')
            ->assertOk()
            ->assertSee('Database Engineering');

        $this->get('/community')
            ->assertOk()
            ->assertSee('Visitor Tester')
            ->assertSee('Pengunjung Baru');

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('MySQL Launch Project')
            ->assertSee('Database Engineering');
    }

    public function test_site_visitor_endpoint_persists_popup_visitors_and_skips_admin_name(): void
    {
        $firstResponse = $this->postJson(route('site-visitor.store'), [
            'name' => 'Pengunjung Popup',
            'token' => 'popup-token-1',
        ]);

        $firstResponse
            ->assertOk()
            ->assertJson([
                'recorded' => true,
                'is_admin' => false,
                'visitor_name' => 'Pengunjung Popup',
                'total' => 1,
            ]);

        $this->assertDatabaseHas('visitors', [
            'token' => 'popup-token-1',
            'name' => 'Pengunjung Popup',
        ]);

        $repeatResponse = $this->postJson(route('site-visitor.store'), [
            'name' => 'Pengunjung Popup Baru',
            'token' => 'popup-token-1',
        ]);

        $repeatResponse
            ->assertOk()
            ->assertJson([
                'recorded' => true,
                'is_admin' => false,
                'visitor_name' => 'Pengunjung Popup Baru',
                'total' => 1,
            ]);

        $this->assertDatabaseCount('visitors', 1);
        $this->assertDatabaseHas('visitors', [
            'token' => 'popup-token-1',
            'name' => 'Pengunjung Popup Baru',
        ]);

        $adminName = (string) config('forto.admin.name');

        $adminResponse = $this->postJson(route('site-visitor.store'), [
            'name' => strtoupper($adminName),
            'token' => 'popup-token-admin',
        ]);

        $adminResponse
            ->assertOk()
            ->assertJson([
                'recorded' => false,
                'is_admin' => true,
                'visitor_name' => $adminName,
                'total' => 1,
            ]);

        $this->assertDatabaseMissing('visitors', [
            'token' => 'popup-token-admin',
        ]);
    }

    public function test_visitor_features_fail_softly_when_visitors_table_is_not_ready_during_deploy(): void
    {
        $this->seed(DatabaseSeeder::class);

        Schema::dropIfExists('visitors');

        $this->get('/')
            ->assertOk()
            ->assertSee('Selamat Datang');

        $this->get('/community')
            ->assertOk()
            ->assertSee('Community');

        $this->post('/login', [
            'email' => (string) config('forto.admin.email'),
            'password' => (string) config('forto.admin.password'),
        ])->assertRedirect(route('dashboard'));

        $this->get('/dashboard')
            ->assertOk()
            ->assertSee('Dashboard');

        $this->postJson(route('site-visitor.store'), [
            'name' => 'Pengunjung Deploy',
            'token' => 'deploy-token-1',
        ])->assertOk()
            ->assertJson([
                'recorded' => false,
                'is_admin' => false,
                'visitor_name' => 'Pengunjung Deploy',
                'total' => 0,
            ]);
    }
}
