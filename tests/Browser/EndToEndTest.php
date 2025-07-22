<?php

use Laravel\Dusk\Browser;
use App\Models\User;
use App\Models\Student;
use App\Models\Payment;
use App\Models\Receivable;
use Illuminate\Foundation\Testing\DatabaseMigrations;

uses(DatabaseMigrations::class);

// Test login flow
it('can login as admin', function () {
    $user = User::factory()->create(['email' => 'admin@stefia.test', 'password' => bcrypt('password')]);
    $this->browse(function (Browser $browser) use ($user) {
        $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('Login')
                ->assertPathIs('/dashboard')
                ->assertSee('STEFIA Dashboard');
    });
});

// Test CRUD mahasiswa
it('can create, edit, and delete mahasiswa', function () {
    $user = User::factory()->create();
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/students')
                ->press('Tambah Mahasiswa')
                ->type('nim', 'TEST123')
                ->type('name', 'Mahasiswa Test')
                ->type('email', 'mahasiswa@test.com')
                ->press('Simpan')
                ->assertSee('Mahasiswa Test')
                ->click('@edit-student-TEST123')
                ->type('name', 'Mahasiswa Test Edit')
                ->press('Simpan')
                ->assertSee('Mahasiswa Test Edit')
                ->click('@delete-student-TEST123')
                ->whenAvailable('.modal-confirm', function ($modal) {
                    $modal->press('Ya, Hapus');
                })
                ->assertDontSee('Mahasiswa Test Edit');
    });
});

// Test CRUD pembayaran
it('can create, edit, and delete pembayaran', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();
    $this->browse(function (Browser $browser) use ($user, $student) {
        $browser->loginAs($user)
                ->visit('/payments')
                ->press('Tambah Pembayaran')
                ->select('student_id', $student->id)
                ->type('amount', '1000000')
                ->type('payment_date', now()->toDateString())
                ->press('Simpan')
                ->assertSee('1000000')
                ->click('@edit-payment-1')
                ->type('amount', '2000000')
                ->press('Simpan')
                ->assertSee('2000000')
                ->click('@delete-payment-1')
                ->whenAvailable('.modal-confirm', function ($modal) {
                    $modal->press('Ya, Hapus');
                })
                ->assertDontSee('2000000');
    });
});

// Test piutang status update
it('updates receivable status after payment', function () {
    $user = User::factory()->create();
    $student = Student::factory()->create();
    $receivable = Receivable::factory()->create(['student_id' => $student->id, 'outstanding_amount' => 1000000]);
    $this->browse(function (Browser $browser) use ($user, $student, $receivable) {
        $browser->loginAs($user)
                ->visit('/payments')
                ->press('Tambah Pembayaran')
                ->select('student_id', $student->id)
                ->type('amount', '1000000')
                ->type('payment_date', now()->toDateString())
                ->press('Simpan')
                ->visit('/receivables')
                ->assertSee('paid');
    });
});

// Test reminder scheduling
it('can schedule and run reminder', function () {
    $user = User::factory()->create();
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/reminders')
                ->press('Jadwalkan Reminder')
                ->type('title', 'Reminder Test')
                ->type('schedule_date', now()->addDay()->toDateString())
                ->press('Simpan')
                ->assertSee('Reminder Test')
                ->click('@run-reminder-1')
                ->assertSee('Berhasil');
    });
});

// Test laporan export
it('can export laporan', function () {
    $user = User::factory()->create();
    $this->browse(function (Browser $browser) use ($user) {
        $browser->loginAs($user)
                ->visit('/reports/collection-report')
                ->press('Export Excel')
                ->waitForText('Berhasil')
                ->assertSee('Berhasil');
    });
});

// Test user management
it('can add, edit, and suspend user', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
                ->visit('/settings/users')
                ->press('Tambah User')
                ->type('name', 'User Test')
                ->type('email', 'usertest@stefia.test')
                ->type('password', 'password')
                ->select('role', 'finance')
                ->press('Simpan')
                ->assertSee('User Test')
                ->click('@edit-user-2')
                ->type('name', 'User Test Edit')
                ->press('Simpan')
                ->assertSee('User Test Edit')
                ->click('@suspend-user-2')
                ->assertSee('suspended');
    });
});

// Test settings update
it('can update settings and see audit log', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
                ->visit('/settings/general')
                ->type('site_name', 'STEFIA Test')
                ->press('Simpan')
                ->assertSee('STEFIA Test')
                ->visit('/settings/audit')
                ->assertSee('Updated settings');
    });
});

// Test scholarship approval
it('can approve scholarship application', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $this->browse(function (Browser $browser) use ($admin) {
        $browser->loginAs($admin)
                ->visit('/scholarships/applications')
                ->click('@approve-scholarship-1')
                ->assertSee('approved');
    });
}); 